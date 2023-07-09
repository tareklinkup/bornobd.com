<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('username', 50)->unique();
            $table->string('email', 30);
            $table->timestamp('email_verified_at')->nullable();
            $table->text('image');
            $table->text('thum_image')->nullable();
            $table->string('role', 3);
            $table->string('password', 100)->hash();
            $table->string('status', 1)->default(1);
            $table->string('save_by', 3)->nullable();
            $table->string('updated_by', 3)->nullable();
            $table->string('ip_address', 15)->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        $user = new User();
        $user->name = "MD Sazzat Hossain";
        $user->username = "admin";
        $user->email = "admin@gmail.com";
        $user->image = "images/avatar.png";
        $user->role = 1;
        $user->password = Hash::make(1);
        $user->save();
        $user = new User();
        $user->name = "Md. shamim Miah";
        $user->username = "admin2";
        $user->email = "admin2@gmail.com";
        $user->image = "images/avatar.png";
        $user->role = 1;
        $user->password = Hash::make(1);
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
