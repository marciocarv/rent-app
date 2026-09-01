<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('plan_tier')->default('free');
            $table->string('mp_subscription_id')->nullable(); // To store the Mercado Pago Assinatura ID
            $table->timestamp('plan_expires_at')->nullable(); // To handle cancellations or failed payments
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['plan_tier', 'mp_subscription_id', 'plan_expires_at']);
        });
    }
};
