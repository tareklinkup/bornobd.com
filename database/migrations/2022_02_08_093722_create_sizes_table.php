<?php

use App\Models\Size;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $size = new Size();
        $size->name = 'S';
        $size->save();
        $size = new Size();
        $size->name = 'M';
        $size->save();
        $size = new Size();
        $size->name = 'L';
        $size->save();
        $size = new Size();
        $size->name = 'XL';
        $size->save();
        $size = new Size();
        $size->name = '2XL';
        $size->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sizes');
    }
}
