<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Relacionamentos (Permite nullable caso a despesa seja do imóvel e não de um inquilino/contrato específico)
            $table->foreignId('unit_id')->constrained('units')->cascadeOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->nullOnDelete();
            $table->foreignId('landlord_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('users')->cascadeOnDelete();
            // Dados Financeiros
            $table->string('type'); // 'revenue' (receita) ou 'expense' (despesa)
            $table->string('description'); // Ex: "Aluguel - Maio/2026" ou "Conserto da Torneira"
            $table->decimal('amount', 10, 2);
            $table->date('due_date'); // Data que precisa ser pago
            $table->date('paid_date')->nullable(); // Data em que realmente foi pago
            $table->string('status')->default('pending'); // 'pending', 'paid', 'overdue'

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
