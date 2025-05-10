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
        $table->string('intensity')->nullable();
        $table->string('setup')->nullable();
        $table->integer('days')->nullable();
    });
}

public function down()
{
    Schema::table('work_splits', function (Blueprint $table) {
        $table->dropColumn(['intensity', 'setup', 'days']);
    });
}

};
