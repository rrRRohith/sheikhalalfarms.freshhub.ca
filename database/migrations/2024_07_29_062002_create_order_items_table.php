<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id');
            $table->integer('product_id');
            $table->string('product_name', 90)->nullable();
            $table->string('product_sku', 40)->nullable();
            $table->string('product_description', 250)->nullable();
            $table->integer('quantity')->default(0);
            $table->float('rate', 10, 0)->default(0);
            $table->enum('price_by', ['quantity', 'weight'])->default('weight');
            $table->float('total', 10, 0)->default(0);
            $table->float('weight', 10, 0)->default(0);
            $table->integer('backqty')->nullable();
            $table->decimal('backamount', 7)->nullable();
            $table->decimal('tax', 5)->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->float('original_rate', 10, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
