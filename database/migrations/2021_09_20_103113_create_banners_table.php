<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('offer_name', 100)->nullable();
            $table->text('short_details')->nullable();
            $table->string('offer_link', 120)->nullable();
            $table->text('image');
            $table->string('status', 1)->default('a');
            $table->string('save_by', 3);
            $table->string('updated_by', 3);
            $table->string('ip_address', 15);
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
        Schema::dropIfExists('banners');
    }
}
