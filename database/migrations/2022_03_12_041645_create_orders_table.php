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
            $table->id();
            $table->foreignId('customer_id')
                    ->constrained('customers')
                    ->onDelete('cascade');
            $table->string('invoice_no', 30);
            $table->string('customer_name', 100);
            $table->string('customer_mobile', 15);
            $table->string('customer_email', 50)->nullable();
            $table->text('billing_address');
            $table->string('shipping_name', 100);
            $table->string('shipping_phone', 13);
            $table->string('shipping_email', 50)->nullable();
            $table->text('shipping_address')->nullable();
            $table->decimal('vat_amount', 18, 2)->default(0);
            $table->decimal('shipping_cost', 18, 2);
            $table->decimal('discount_amount', 18, 2)->default(0);
            $table->decimal('service_charge', 18, 2)->default(0);
            $table->decimal('total_amount', 18, 2)->default(0);
            $table->decimal('total_trailoring_charge', 18, 2)->default(0);
            $table->decimal('total_wrapping_charge', 18, 2)->default(0);
            $table->text('note')->nullable();
            $table->string('updated_by', 3)->nullable();
            $table->string('status')->default('p');
            $table->foreignId('area_id')
                ->constrained('delivery_charges')
                ->onDelete('cascade');
            $table->foreignId('shop_id')
                ->constrained('storeLocations')
                ->onDelete('cascade');
            $table->foreignId('courier_id')
                ->constrained('Tracking')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
            $table->string('ip_address', 30);
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
