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
            $table->integer('id', true);
            $table->string('name', 50);
            $table->string('sku', 100);
            $table->text('description');
            $table->integer('category_id');
            $table->float('weight', 10, 0)->default(0);
            $table->float('price', 10, 0)->default(0);
            $table->string('picture', 200)->nullable();
            $table->integer('qty')->default(0);
            $table->integer('unit')->nullable();
            $table->string('unittype', 20);
            $table->enum('price_by', ['quantity', 'weight'])->default('quantity');
            $table->boolean('status')->nullable()->default(true);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
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
