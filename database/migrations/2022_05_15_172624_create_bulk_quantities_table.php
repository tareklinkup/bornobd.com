<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_quantities', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('customer_name', 50);
            $table->string('customer_mobile', 20);
            $table->string('customer_email', 50);
            $table->text('customer_message');
            $table->softDeletes();
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
        Schema::dropIfExists('bulk_quantities');
    }
}
