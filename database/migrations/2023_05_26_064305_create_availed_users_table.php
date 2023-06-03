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
        Schema::create('availed_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('availed_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('availed_to')->constrained('users')->cascadeOnDelete();
            $table->boolean('is_accepted')->default(false);
            $table->foreignId('notification_id')->constrained('notifications')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availed_users');
    }
};
