<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname', 50);
            $table->string('lastname', 50)->nullable();
            $table->string('username', 50)->unique();
            $table->string('password', 100);
            $table->string('email', 100)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('address', 150)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('postalcode', 7)->nullable();
            $table->string('province', 2)->nullable();
            $table->string('country', 2)->nullable()->default('CA');
            $table->string('profile_picture', 100)->nullable();
            $table->enum('type', ['admin', 'customer', 'staff'])->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('token_id', 100)->nullable();
            $table->integer('payment_term')->nullable();
            $table->integer('payment_method')->nullable();
            $table->integer('customer_type')->nullable();
            $table->text('description')->nullable();
            $table->string('business_name', 30)->nullable();
            $table->integer('sales_rep')->nullable();
            $table->integer('driver_id')->nullable()->default(0);
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
        Schema::dropIfExists('users');
    }
}
