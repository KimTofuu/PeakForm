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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mealPlans_id')->references('id')->on('mealPlans')->onDelete('cascade')->onUpdate('cascade');
            $table->string('mealName', 100);
            $table->decimal('protein',5 ,2);
            $table->decimal('carbs',5 ,2);
            $table->decimal('calories',5 ,2);
            $table->decimal('fat',5 ,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
