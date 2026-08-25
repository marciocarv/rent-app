<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Document snapshot
            $table->longText('document_body')->nullable()->after('due_day');
            $table->string('document_hash')->nullable()->after('document_body');

            // Landlord signature evidence
            $table->timestamp('landlord_signed_at')->nullable();
            $table->string('landlord_sign_ip')->nullable();

            // Tenant signature evidence
            $table->timestamp('tenant_signed_at')->nullable();
            $table->string('tenant_sign_ip')->nullable();
        });
    }

    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn([
                'document_body',
                'document_hash',
                'landlord_signed_at',
                'landlord_sign_ip',
                'tenant_signed_at',
                'tenant_sign_ip'
            ]);
        });
    }
};
