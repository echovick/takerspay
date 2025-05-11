<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->string('bank_id')->nullable();
            $table->string('bank_slug')->nullable();
            $table->string('currency')->nullable();
            $table->dateTime('assigned_at')->nullable();
            $table->string('customer_id')->nullable();
            $table->json('account_creation_response_object')->nullable();
            $table->decimal('balance', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn('bank_id');
            $table->dropColumn('bank_slug');
            $table->dropColumn('currency');
            $table->dropColumn('assigned_at');
            $table->dropColumn('customer_id');
            $table->dropColumn('account_creation_response_object');
            $table->dropColumn('balance');
        });
    }
};
