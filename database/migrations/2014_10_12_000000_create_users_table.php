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
            $table->string('fullname');
            $table->string('username')->unique();
            $table->string('email_address')->unique();
            $table->bigInteger('contact_no')->unique();
            $table->string('password');
            $table->string('current_balance')->default(0);
            // $table->string('address');
            $table->string('region');
            $table->string('profile_picture')->nullable();
            $table->integer('user_type');
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
