<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code',18);
            $table->string('name',100);
            $table->string('slug',130);
            $table->string('model', 130);
            $table->string('price', 8);
            $table->text('simillar_porduct')->nullable();
            $table->decimal('similar_discount')->nullable();
            $table->text('size_id')->nullable();
            $table->text('color_id')->nullable();
            $table->foreignId('category_id')
                    ->constrained('categories')
                    ->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable() 
                    ->constrained('sub_categories')
                    ->onDelete('cascade');  
            $table->foreignId('subsubcategory_id')->nullable() 
                    ->constrained('subsubcategories')
                    ->onDelete('cascade');  
            $table->foreignId('another_category_id')->nullable() 
                    ->constrained('another_categories')
                    ->onDelete('cascade');  
            $table->foreignId('brand_id')->nullable() 
                    ->constrained('brands')
                    ->onDelete('cascade'); 
            $table->decimal('discount', 18,2)->nullable();
            $table->text('short_details')->nullable();
            $table->longText('description')->nullable();
            $table->string('main_image')->nullable();
            $table->string('thumb_image')->nullable();
            $table->string('small_image')->nullable();
            $table->string('is_feature',1)->nullable();
            $table->string('is_collection_title_1',1)->nullable();
            $table->string('is_collection_title_2',1)->nullable();
            $table->string('is_deal',1)->nullable();
            $table->string('is_tailoring',1)->nullable();
            $table->decimal('tailoring_charge',)->nullable();
            $table->string('is_trending',1)->nullable();
            $table->string('new_arrival',1)->nullable();
            $table->date('deal_start')->nullable();
            $table->date('deal_end')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('quantity')->default(1);
            $table->string('save_by', 3);
            $table->string('update_by', 3)->nullable();
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
        Schema::dropIfExists('products');
    }
}
