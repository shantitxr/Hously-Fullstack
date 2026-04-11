<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        // Load the user's properties that have inquiries, with senders
        $properties = auth()->user()
            ->properties()
            ->with(['inquiries.sender'])
            ->whereHas('inquiries')
            ->get();

        return view('user.inquiries', compact('properties'));
    }

    public function store(Request $request, Property $property)
    {
        $request->validate([
            'message'           => 'required|string',
            'preferred_contact' => 'required|in:email,phone,whatsapp',
        ]);

        $property->inquiries()->create([
            'sender_id'         => auth()->id(),
            'message'           => $request->message,
            'preferred_contact' => $request->preferred_contact,
            'is_read'           => false,
        ]);

        return back()->with('success', 'Inquiry sent!');
    }

    public function markRead(Inquiry $inquiry)
    {
        $inquiry->update(['is_read' => true]);
        return back();
    }
}
