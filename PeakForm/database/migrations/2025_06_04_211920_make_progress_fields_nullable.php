<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->float('weight')->nullable()->change();
            $table->float('body_fat_percentage')->nullable()->change();
            $table->float('muscle_mass')->nullable()->change();
            $table->date('date_recorded')->nullable()->change();
            // Add other fields here if needed
        });
    }

    public function down()
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->float('weight')->nullable(false)->change();
            $table->float('body_fat_percentage')->nullable(false)->change();
            $table->float('muscle_mass')->nullable(false)->change();
            $table->date('date_recorded')->nullable(false)->change();
            // Revert other fields here if needed
        });
    }
};
