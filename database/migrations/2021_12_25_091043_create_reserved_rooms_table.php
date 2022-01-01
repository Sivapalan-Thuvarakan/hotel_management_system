<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservedRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserved_rooms', function (Blueprint $table) {
            $table->id();
            // $table->date('check_in_date');
            // $table->date('check_out_date');
            $table->string('status')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('room_id')->nullable()->unsigned();   // foreign
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->unsignedBigInteger('room_type_id')->nullable()->unsigned();   // foreign
            $table->foreign('room_type_id')->references('id')->on('room_types');
            $table->unsignedBigInteger('reservation_id')->nullable()->unsigned();   // foreign
            $table->foreign('reservation_id')->references('id')->on('room_reservations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reserved_rooms');
    }
}
