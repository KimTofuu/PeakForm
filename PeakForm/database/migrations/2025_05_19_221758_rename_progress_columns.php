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
        Schema::table('progress', function (Blueprint $table) {
            $table->renameColumn('dateRecorded', 'date_recorded');
            $table->renameColumn('bodyFatPercentage', 'body_fat_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->renameColumn('date_recorded', 'dateRecorded');
            $table->renameColumn('body_fat_percentage', 'bodyFatPercentage');
        });
    }
};
