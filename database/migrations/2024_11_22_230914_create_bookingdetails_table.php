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
        Schema::create('bookingdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_code');
            $table->string('name'); // ini nnti bs buat org lain atau kt sndiri
            // email aj gk perlu notelp soalnya kan bsji dihubungi lewat email
            $table->string('email');
            $table->enum('gender', ['male', 'female']);
            $table->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookingdetails');
    }
};
