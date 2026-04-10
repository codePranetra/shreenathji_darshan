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
        Schema::table('darshan_timings', function (Blueprint $table) {
            $table->renameColumn('time', 'start_time'); 
        });

        Schema::table('darshan_timings', function (Blueprint $table) {
            $table->time('start_time')->nullable()->change();
            $table->time('end_time')->after('start_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('darshan_timings', function (Blueprint $table) {
            //
        });
    }
};
