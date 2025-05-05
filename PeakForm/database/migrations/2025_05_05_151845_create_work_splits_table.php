<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkSplitsTable extends Migration
{
    public function up()
    {
        Schema::table('work_splits', function (Blueprint $table) {
            $table->text('day1')->nullable();
            $table->text('day2')->nullable();
            $table->text('day3')->nullable();
            $table->text('day4')->nullable();
            $table->text('day5')->nullable();
            $table->text('day6')->nullable();
            $table->text('day7')->nullable();
        });
    }

    public function down()
    {
        Schema::table('work_splits', function (Blueprint $table) {
            $table->dropColumn(['day1', 'day2', 'day3', 'day4', 'day5', 'day6', 'day7']);
        });
    }
}
