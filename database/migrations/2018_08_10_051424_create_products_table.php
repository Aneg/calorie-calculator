<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id')->comment('Идентификатор продукта');
            $table->string('name')->comment('Название продукта');
            $table->string('hash',9)->comment('Хэш продукта');
            $table->decimal('protein',4,1)->comment('Соджержание белка');
            $table->decimal('fat',4,1)->comment('Содержание жира');
            $table->decimal('carbohydrate',4,1)->comment('
            Содержание углевода');
            $table->integer('calories')->comment('Калорийность');
            $table->integer('user_id')->unsigned()->nullable()->comment('Идентификатор пользователя');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
