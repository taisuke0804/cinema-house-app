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
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('screen_id')->comment('上映ID');
            $table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade');
            $table->string('seat_number')->comment('座席番号(A01 ~ B10)');
            $table->unsignedBigInteger('user_id')->nullable()->comment('予約者ID');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('guest_name')->nullable()->comment('招待者名');
            $table->boolean('guest_is')->nullable()->comment('招待者フラグ');
            $table->unique(['screen_id', 'seat_number'], 'unique_seat_screen');
            $table->unique(['screen_id', 'user_id'], 'unique_seat_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
