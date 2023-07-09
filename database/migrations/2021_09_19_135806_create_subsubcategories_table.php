<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubsubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsubcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
              ->constrained('categories')
              ->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable() 
              ->constrained('sub_categories')
              ->onDelete('cascade');  
            $table->string('name', 100);
            $table->string('slug', 130);
            $table->string('status', 1)->default('a');
            $table->string('save_by', 10);
            $table->string('updated_by', 3)->nullable();
            $table->string('ip_address', 15);
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
        Schema::dropIfExists('subsubcategories');
    }
}
