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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email_address')->unique();
            $table->integer('contact_no')->unique();
            $table->string('password');
            $table->string('current_balance');
            $table->string('address');
            $table->string('country');
            $table->string('profile_picture')->nullable();
            $table->string('id_picture')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('rewards')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
