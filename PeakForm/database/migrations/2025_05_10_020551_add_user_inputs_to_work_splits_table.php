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
        Schema::table('work_splits', function (Blueprint $table) {
            $table->string('goal')->nullable();
            $table->string('fitness_level')->nullable();
            $table->string('equipment')->nullable();
        });
    }

    public function down()
    {
        Schema::table('work_splits', function (Blueprint $table) {
            $table->dropColumn(['goal', 'fitness_level', 'equipment']);
        });
    }
};
