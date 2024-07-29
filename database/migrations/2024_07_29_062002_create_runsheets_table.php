<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunsheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runsheets', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('driver_id');
            $table->date('delivery_date');
            $table->string('city', 25)->nullable();
            $table->integer('route')->nullable();
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
        Schema::dropIfExists('runsheets');
    }
}
