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
        Schema::table('user_meta_data', function (Blueprint $table) {
            $table->string('middle_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('status')->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_meta_data', function (Blueprint $table) {
            $table->dropColumn('middle_name');
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropColumn('date_of_birth');
            $table->dropColumn('gender');
            $table->dropColumn('profile_picture');
            $table->dropColumn('status');
        });
    }
};
