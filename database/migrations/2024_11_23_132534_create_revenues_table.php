<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10, 2); // Store revenue amount
            // cm booking id soalnya di booking id udh ada event id
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revenues');
    }
};
