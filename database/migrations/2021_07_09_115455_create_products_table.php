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
            $table->string('name');
            $table->string('alter_name')->nullable();
            $table->string('brand')->nullable();
            $table->text('desc');
            $table->integer('quantity')->nullable();
            $table->string('size')->nullable();
            $table->string('image')->nullable();

            $table->string('discount_id')->nullable();
            $table->integer('price_discount')->nullable();
            $table->integer('price');

            $table->integer('inventory_id')->nullable();
            $table->integer('category_id');
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
        Schema::dropIfExists('products');
    }
}
