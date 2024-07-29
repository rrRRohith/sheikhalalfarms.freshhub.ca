<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 20);
            $table->string('address', 150)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('postalcode', 7)->nullable();
            $table->string('province', 2)->nullable();
            $table->string('phone', 15)->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('warehouses');
    }
}
