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

            // Foreign Key linking to the users (landlords) table
            $table->foreignId('landlord_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->string('name'); // e.g., "Sunset Apartments" or "123 Main St Single House"
            $table->string('address');
            $table->enum('type', ['single_family', 'multi_family', 'commercial'])->default('single_family');
            $table->text('notes')->nullable();

            $table->timestamps();

            // Indexing for high performance when filtering by landlord
            $table->index('landlord_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
