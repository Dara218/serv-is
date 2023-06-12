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
        Schema::create('availed_pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('availed_to_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('availed_by_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('pricing_plan_type')->constrained('pricing_plans')->cascadeOnDelete();
            $table->boolean('is_expired')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('availed_pricing_plans');
    }
};
