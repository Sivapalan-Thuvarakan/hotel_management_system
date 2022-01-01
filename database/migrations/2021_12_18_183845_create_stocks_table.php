<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('product_name');
            $table->string('brand');
            $table->double('purchase_price');
            $table->integer('quantity');
            $table->text('description');
            $table->string('type');
            $table->boolean('is_product');


            $table->unsignedBigInteger('department_id')->nullable()->unsigned();   // foreign-department_id
            $table->foreign('department_id')->references('id')->on('departments');

            $table->unsignedBigInteger('user_id')->nullable()->unsigned();   // foreign-user_id
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('supplier_id')->nullable()->unsigned();   // foreign-supplier_id
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
