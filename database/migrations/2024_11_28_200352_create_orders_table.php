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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('asset_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('reference')->unique();
            $table->enum('type', ['buy', 'sell'])->nullable();
            $table->enum('asset', ['crypto', 'card'])->nullable();
            $table->decimal('asset_value', 15, 2)->nullable();
            $table->decimal('dollar_price', 15, 2)->nullable();
            $table->decimal('naira_price', 15, 2)->nullable();
            $table->enum('transaction_status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->string('file_url')->nullable();
            $table->foreignId('wallet_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('chat')->nullable();
            $table->string('order_step')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('fulfilled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
