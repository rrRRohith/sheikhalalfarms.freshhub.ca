<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('invoice_number', 15);
            $table->integer('order_id');
            $table->dateTime('due_date');
            $table->integer('customer_id');
            $table->boolean('status')->default(false);
            $table->enum('payment_method', ['cash', 'card', 'other'])->nullable();
            $table->string('reference_number', 25)->nullable();
            $table->string('transaction_id', 15)->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->decimal('sub_total')->nullable()->default(0);
            $table->decimal('tax')->nullable();
            $table->decimal('discount')->nullable()->default(0);
            $table->decimal('shipping')->nullable()->default(0);
            $table->decimal('grand_total')->default(0);
            $table->decimal('paid_total')->default(0);
            $table->text('remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
