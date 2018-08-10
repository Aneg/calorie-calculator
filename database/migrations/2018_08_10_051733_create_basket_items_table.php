<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasketItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basket_items', function (Blueprint $table) {
            $table->increments('id')->comment('Идентификатор позиции');
            $table->integer('product_id')->unsigned()->comment('Идентификатор продукта');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('basket_id')->unsigned()->comment('Идентификатор корзины');
            $table->decimal('weight')->unsigned()->comment('Вес продукта');
            $table->foreign('basket_id')->references('id')->on('baskets')->onDelete('cascade');
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
        Schema::dropIfExists('basket_items');
    }
}
