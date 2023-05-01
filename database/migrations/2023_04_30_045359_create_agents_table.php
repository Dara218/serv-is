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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('username')->unique();
            $table->string('email_address')->unique();
            $table->bigInteger('contact_no')->unique();
            $table->string('password');
            $table->string('address');
            $table->string('region');
            $table->string('profile_picture')->nullable();
            $table->string('photo_id');
            $table->string('nbi_clearance');
            $table->string('police_clearance');
            $table->string('birth_certificate');
            $table->string('cert_of_employment');
            $table->string('other_valid_id');
            $table->integer('user_type')->default(2);
            $table->boolean('is_active')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
