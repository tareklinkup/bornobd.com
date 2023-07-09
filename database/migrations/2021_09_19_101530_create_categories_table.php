<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 130);
            $table->text('details')->nullable();
            $table->text('image')->nullable();
            $table->text('thumbimage')->nullable();
            $table->text('smallimage')->nullable();
            $table->string('status',1)->default('a');
            $table->string('is_homepage',10)->nullable();
            $table->string('save_by', 3)->nullable();
            $table->string('updated_by', 3)->nullable();
            $table->string('ip_address', 15)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        $category = new Category();
        $category->name = 'canon';
        $category->slug = 'Canon';
        $category->save();
        $category = new Category();
        $category->name = 'Nikon';
        $category->slug = 'nikon';
        $category->save();
        $category = new Category();
        $category->name = 'HP';
        $category->slug = 'hp';
        $category->save();
        $category = new Category();
        $category->name = 'Walton';
        $category->slug = 'walton';
        $category->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
