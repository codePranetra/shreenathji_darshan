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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');
        $table->string('phone_number');
        $table->string('time');
        $table->date('date');
        $table->integer('members');
        $table->decimal('amount', 10, 2);
        $table->unsignedBigInteger('darshan_id');
        $table->unsignedBigInteger('package_id');
        $table->boolean('is_verified')->default(0);
        $table->boolean('is_active')->default(1);
        $table->boolean('is_deleted')->default(0);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
