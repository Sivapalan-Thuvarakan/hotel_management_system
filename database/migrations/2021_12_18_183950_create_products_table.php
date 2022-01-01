<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('product_name');
            $table->double('selling_price');
            $table->integer('discount');
            $table->timestamps();

            $table->unsignedBigInteger('stock_id')->nullable()->unsigned();   // foreign-stock_id
            $table->foreign('stock_id')->references('id')->on('stocks');

            $table->unsignedBigInteger('department_id')->nullable()->unsigned();   // foreign-department_id
            $table->foreign('department_id')->references('id')->on('departments');

            $table->unsignedBigInteger('user_id')->nullable()->unsigned();   // foreign-user_id
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('sale_id')->nullable()->unsigned();   // foreign-product_id
            $table->foreign('sale_id')->references('id')->on('sales');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
