<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamp('date_time');
            $table->string('location');
            $table->string('image_path');
            $table->string('organizer_name');
            // atribut tambahan untuk tiket
            // $table->integer('ticket_price');
            // $table->integer('quota');
            // ini constrained lgsg dia tandai klo foreign keynya itu dari table user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
