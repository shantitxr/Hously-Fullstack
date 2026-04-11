<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->integer('price');
            $table->integer('sq_meters');
            $table->integer('bedrooms')->default(0);
            $table->integer('bathrooms')->default(0);
            $table->string('address');
            $table->string('city');
            $table->enum('listing_type', ['rent', 'sale']);
            $table->enum('property_type', ['apartment', 'house', 'studio', 'villa']);
            $table->boolean('is_available')->default(true);
            $table->boolean('has_pool')->default(false);
            $table->boolean('has_gym')->default(false);
            $table->boolean('has_parking')->default(false);
            $table->date('available_from');
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
