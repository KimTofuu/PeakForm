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
        Schema::create('workoutDay', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('work_splits_id')->constrained('work_split')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('work_splits_id')->references('id')->on('work_splits')->onDelete('cascade')->onUpdate('cascade');
            $table->string('dayName', 100);
            $table->string('targetMuscleGroup', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workoutDay');
    }
};
