<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Http\Request;

class InquiryApiController extends Controller
{
    // GET /api/inquiries — returns inquiries received on user's own properties
    public function index(Request $request)
    {
        $inquiries = Inquiry::with(['property:id,title', 'sender:id,name,email'])
            ->whereHas('property', fn($q) =>
                $q->where('user_id', $request->user()->id))
            ->latest()
            ->get();

        return response()->json($inquiries);
    }

    // POST /api/inquiries — send an inquiry to a property owner
    public function store(Request $request)
    {
        $data = $request->validate([
            'property_id'       => 'required|exists:properties,id',
            'message'           => 'required|string',
            // preferred_contact matches the enum in migration: email, phone, whatsapp
            'preferred_contact' => 'required|in:email,phone,whatsapp',
        ]);

        $property = Property::findOrFail($data['property_id']);

        // Prevent owners from inquiring about their own listing
        if ($property->user_id === $request->user()->id) {
            return response()->json(
                ['message' => 'You cannot send an inquiry to your own listing.'],
                403
            );
        }

        $inquiry = Inquiry::create([
            'property_id'       => $data['property_id'],
            'sender_id'         => $request->user()->id,
            'message'           => $data['message'],
            'preferred_contact' => $data['preferred_contact'],
            'is_read'           => false,
        ]);

        return response()->json($inquiry->load('sender:id,name,email'), 201);
    }

    // PATCH /api/inquiries/{id} — mark as read, owner of property only
    public function markRead(Request $request, $id)
    {
        $inquiry = Inquiry::with('property')->findOrFail($id);

        abort_if(
            $inquiry->property->user_id !== $request->user()->id,
            403,
            'You do not own the property this inquiry was sent to.'
        );

        $inquiry->update(['is_read' => true]);

        return response()->json($inquiry);
    }

    // DELETE /api/inquiries/{id} — owner of property or admin
    public function destroy(Request $request, $id)
    {
        $inquiry = Inquiry::with('property')->findOrFail($id);

        $isOwner = $inquiry->property->user_id === $request->user()->id;
        $isAdmin = $request->user()->role === 'admin';

        abort_if(! $isOwner && ! $isAdmin, 403, 'Unauthorized.');

        $inquiry->delete();

        return response()->json(['message' => 'Inquiry deleted.']);
    }
}