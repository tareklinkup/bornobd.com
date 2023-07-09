<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->nullable();;
            $table->string('name', 100);
            $table->string('phone', 11); 
            $table->string('email', 100)->nullable();
            $table->string('address')->nullable();
            $table->foreignId('country_id')->nullable()
                    ->constrained('countries')
                    ->onDelete('cascade');
            $table->foreignId('district_id')->nullable()
                    ->constrained('districts')
                    ->onDelete('cascade');
            $table->foreignId('upazila_id')->nullable()
                    ->constrained('upazilas')
                    ->onDelete('cascade');
            $table->foreignId('area_id')->nullable()
                    ->constrained('areas')
                    ->onDelete('cascade');
            $table->text('profile_picture')->nullable();
            $table->string('thum_picture')->nullable();
            $table->string('username', 20);
            $table->string('password', 100);
            $table->string('status', 1)->default('p');
            $table->integer('membership_discount')->nullable();
            $table->string('save_by', 20);
            $table->string('updated_by', 20);
            $table->softDeletes();
            $table->string('ip_address', 17);
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
        Schema::dropIfExists('customers');
    }
}
