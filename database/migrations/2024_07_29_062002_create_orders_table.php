<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('po_number', 100);
            $table->integer('user_id');
            $table->string('email', 30)->nullable();
            $table->dateTime('order_date');
            $table->dateTime('due_date')->nullable();
            $table->string('shipping_id', 10)->nullable();
            $table->dateTime('shipping_date')->nullable();
            $table->string('tracking_code', 25)->nullable();
            $table->integer('billing_id')->nullable();
            $table->integer('delivery_id')->nullable();
            $table->text('billing_address')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('message')->nullable();
            $table->text('notes')->nullable();
            $table->integer('terms')->nullable();
            $table->string('discount', 10)->nullable()->comment('if type is %,then %value.');
            $table->string('discount_type', 11)->nullable()->default('amount')->comment('Type of discount.Amount or percentage');
            $table->decimal('discount_amount', 6)->nullable()->comment('Amount value');
            $table->string('shipping', 11)->nullable();
            $table->decimal('tax', 5)->nullable()->default(0);
            $table->integer('sales_rep')->nullable();
            $table->float('grand_total', 10, 0)->nullable();
            $table->integer('total_quantity');
            $table->decimal('paid_amount', 6)->default(0);
            $table->integer('status')->default(1)->comment('-1=Cancelled,0=Backorder,1=New Order,2=Accepted,3=Processing,4=Ready,5=Dispatching,6=Delivered');
            $table->text('remarks')->nullable();
            $table->integer('driver_id')->nullable();
            $table->boolean('assign_driver')->default(false);
            $table->string('backorder_status', 10)->nullable();
            $table->integer('runsheet_id')->nullable();
            $table->boolean('paid_status')->default(false);
            $table->boolean('saved')->default(false);
            $table->dateTime('printed_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
