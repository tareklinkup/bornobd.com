<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWrappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wrappings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->float('price', 10, 2)->nullable();
            $table->text('details')->nullable();
            $table->text('image')->nullable();
            $table->string('status', 1)->default('a');
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
        Schema::dropIfExists('wrappings');
    }
}
