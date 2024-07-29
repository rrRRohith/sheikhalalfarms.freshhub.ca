<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('sender_id');
            $table->string('sender_email', 100);
            $table->integer('recipient_id');
            $table->string('recipient_email', 100);
            $table->string('subject', 100);
            $table->text('body_html');
            $table->text('body_text');
            $table->string('folder', 100)->nullable();
            $table->dateTime('read_at')->nullable();
            $table->boolean('status_sender')->nullable()->default(false);
            $table->boolean('status_recipient')->nullable()->default(false);
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
        Schema::dropIfExists('messages');
    }
}
