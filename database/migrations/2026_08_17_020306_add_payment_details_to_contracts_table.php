<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->integer('due_day')->nullable(); // Dia do vencimento (ex: 5)
            $table->string('payment_method')->nullable(); // PIX, Boleto, etc.
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['due_day', 'payment_method']);
        });
    }
};
