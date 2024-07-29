<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('organization_name', 20);
            $table->text('organization_description');
            $table->string('website', 100);
            $table->string('phone', 20);
            $table->string('sale_email', 100);
            $table->string('support_email', 100);
            $table->string('sms_api_id', 100)->nullable();
            $table->decimal('tax', 5);
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
        Schema::dropIfExists('settings');
    }
}
