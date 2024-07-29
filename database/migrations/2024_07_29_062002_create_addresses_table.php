<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('type', ['billing', 'delivery'])->default('billing');
            $table->string('address', 150)->nullable();
            $table->string('postalcode', 7)->nullable();
            $table->string('city', 40)->nullable();
            $table->char('province', 2)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 90)->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
