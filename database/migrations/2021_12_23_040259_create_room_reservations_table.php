<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->decimal('total_payable',9,2);
            $table->string('status')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('department_id')->nullable()->unsigned();   // foreign
            $table->foreign('department_id')->references('id')->on('departments');
            $table->unsignedBigInteger('customer_id')->nullable()->unsigned();   // foreign
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_reservations');
    }
}
