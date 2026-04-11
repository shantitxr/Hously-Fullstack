<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ────────────────────────────────────────────────────────
        $categories = collect(['Apartment', 'House', 'Studio', 'Villa'])
            ->map(fn($name) => Category::create(['name' => $name]));

        // ── Admin user ────────────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@hously.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Regular users ─────────────────────────────────────────────────────
        $john = User::create([
            'name'     => 'John Doe',
            'email'    => 'john@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $jane = User::create([
            'name'     => 'Jane Smith',
            'email'    => 'jane@example.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // ── Properties ────────────────────────────────────────────────────────
        $p1 = Property::create([
            'user_id'        => $john->id,
            'category_id'    => $categories[0]->id, // Apartment
            'title'          => 'Modern Apartment in Budapest',
            'description'    => 'A beautifully renovated apartment in the heart of Budapest. Close to public transport, restaurants, and cultural sites.',
            'price'          => 850,
            'sq_meters'      => 65,
            'bedrooms'       => 2,
            'bathrooms'      => 1,
            'address'        => 'Andrássy út 22',
            'city'           => 'Budapest',
            'listing_type'   => 'rent',
            'property_type'  => 'apartment',
            'is_available'   => true,
            'has_pool'       => false,
            'has_gym'        => true,
            'has_parking'    => true,
            'available_from' => now()->addDays(7),
        ]);

        $p2 = Property::create([
            'user_id'        => $john->id,
            'category_id'    => $categories[3]->id, // Villa
            'title'          => 'Luxury Villa in Lisbon',
            'description'    => 'Stunning villa with panoramic ocean views, private pool, and landscaped gardens.',
            'price'          => 1250000,
            'sq_meters'      => 320,
            'bedrooms'       => 5,
            'bathrooms'      => 4,
            'address'        => 'Rua do Alecrim 5',
            'city'           => 'Lisbon',
            'listing_type'   => 'sale',
            'property_type'  => 'villa',
            'is_available'   => true,
            'has_pool'       => true,
            'has_gym'        => true,
            'has_parking'    => true,
            'available_from' => now(),
        ]);

        $p3 = Property::create([
            'user_id'        => $jane->id,
            'category_id'    => $categories[2]->id, // Studio
            'title'          => 'Cozy Studio in Vienna',
            'description'    => 'Compact and stylish studio apartment perfect for young professionals. Great city views.',
            'price'          => 550,
            'sq_meters'      => 35,
            'bedrooms'       => 1,
            'bathrooms'      => 1,
            'address'        => 'Mariahilfer Str. 88',
            'city'           => 'Vienna',
            'listing_type'   => 'rent',
            'property_type'  => 'studio',
            'is_available'   => true,
            'has_pool'       => false,
            'has_gym'        => false,
            'has_parking'    => false,
            'available_from' => now()->addDays(14),
        ]);

        $p4 = Property::create([
            'user_id'        => $jane->id,
            'category_id'    => $categories[1]->id, // House
            'title'          => 'Family House in Prague',
            'description'    => 'Spacious family home with a large garden, garage, and quiet neighborhood.',
            'price'          => 420000,
            'sq_meters'      => 180,
            'bedrooms'       => 4,
            'bathrooms'      => 2,
            'address'        => 'Wenceslas Square 14',
            'city'           => 'Prague',
            'listing_type'   => 'sale',
            'property_type'  => 'house',
            'is_available'   => true,
            'has_pool'       => false,
            'has_gym'        => false,
            'has_parking'    => true,
            'available_from' => now()->addMonth(),
        ]);

        // ── Wishlist entries ───────────────────────────────────────────────────
        $jane->wishlist()->attach([$p1->id, $p2->id], ['added_at' => now()]);
        $john->wishlist()->attach([$p3->id], ['added_at' => now()]);

        // ── Inquiries ─────────────────────────────────────────────────────────
        Inquiry::create([
            'property_id'       => $p1->id,
            'sender_id'         => $jane->id,
            'message'           => 'Is the apartment still available? I would love to schedule a viewing this weekend.',
            'preferred_contact' => 'email',
            'is_read'           => false,
        ]);

        Inquiry::create([
            'property_id'       => $p1->id,
            'sender_id'         => $admin->id,
            'message'           => 'Can we schedule a viewing for next Wednesday afternoon?',
            'preferred_contact' => 'whatsapp',
            'is_read'           => true,
        ]);

        Inquiry::create([
            'property_id'       => $p2->id,
            'sender_id'         => $jane->id,
            'message'           => 'Is the price negotiable? Very interested in the villa.',
            'preferred_contact' => 'phone',
            'is_read'           => false,
        ]);
    }
}
