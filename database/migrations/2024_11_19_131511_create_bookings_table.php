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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending', 'active', 'canceled'])->default('pending'); // bisa tambah 'expired'
            // ini smua disimpan di bookingdetails
            // $table->timestamp('expired_at')->nullable(); ini jg bs klo mau itu yg advanced requirement
            // $table->integer('ticket_code');
            // $table->string('name'); // ini nnti bs buat org lain atau kt sndiri
            // $table->string('email');
            // $table->enum('gender', ['male', 'female']);
            // $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
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
