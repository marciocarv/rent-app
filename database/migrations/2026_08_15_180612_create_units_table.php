<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();

            // Security constraint
            $table->foreignId('landlord_id')->constrained('users')->cascadeOnDelete();

            // Relationship to Property
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();

            $table->string('name'); // e.g., "Apt 4B" or "Main House"
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->string('status')->default('vacant');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
