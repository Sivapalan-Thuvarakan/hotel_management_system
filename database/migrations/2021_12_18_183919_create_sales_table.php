<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->double('sold_price');
            $table->integer('quantity');
            $table->timestamps();

            $table->unsignedBigInteger('department_id')->nullable()->unsigned();   // foreign-department_id
            $table->foreign('department_id')->references('id')->on('departments');

            $table->unsignedBigInteger('user_id')->nullable()->unsigned();   // foreign-user_id
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('customer_id')->nullable()->unsigned();   // foreign-customer_id
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
        Schema::dropIfExists('sales');
    }
}
