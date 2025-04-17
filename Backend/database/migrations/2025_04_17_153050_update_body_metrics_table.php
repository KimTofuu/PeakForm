<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->date('dateRecorded')->change();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('progress', function (Blueprint $table) {
            $table->timestamp('dateRecorded')->useCurrent()->change();
            $table->dropTimestamps();
        });
    }
};
