<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('status')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('room_type_id')->nullable()->unsigned();   // foreign
            $table->foreign('room_type_id')->references('id')->on('room_types');
            $table->unsignedBigInteger('department_id')->nullable()->unsigned();   // foreign
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
