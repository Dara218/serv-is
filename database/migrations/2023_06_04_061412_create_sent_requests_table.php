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
        Schema::create('sent_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('request_to')->constrained('users')->cascadeOnDelete();
            $table->integer('type');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_requests');
    }
};
