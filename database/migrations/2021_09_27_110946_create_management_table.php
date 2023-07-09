<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('rank', 10);
            $table->string('designation', 50);
            $table->string('department', 50);
            $table->longText('description')->nullable();
            $table->text('image')->nullable();
            $table->string('status', 1)->default(1);
            $table->string('save_by', 3)->nullable();
            $table->string('updated_by', 3)->nullable();
            $table->string('ip_address', 15)->nullable();
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
        Schema::dropIfExists('management');
    }
}
