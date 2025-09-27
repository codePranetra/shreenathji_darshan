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
        Schema::create('darshan_timings', function (Blueprint $table) {
            $table->id();
            $table->datetime('time');
            $table->string('title');
            $table->enum ('type', ['morning', 'afternoon', 'evening'])->default('morning'); 
            $table->tinyInteger('is_active')->default(1); // 1 for active, 0 for inactive
            $table->tinyInteger('is_deleted')->default(0); // 1 for deleted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darshan_timings');
    }
};
