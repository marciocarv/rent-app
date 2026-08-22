<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nationality')->nullable();
            $table->string('profession')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('rg')->nullable();
            $table->string('document_number')->nullable(); // CPF ou CNPJ
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Dados do Cônjuge (Spouse data)
            $table->string('spouse_name')->nullable();
            $table->string('spouse_document')->nullable(); // CPF do Cônjuge
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nationality', 'profession', 'marital_status', 'rg',
                'document_number', 'phone', 'address', 'spouse_name', 'spouse_document'
            ]);
        });
    }
};
