<?php

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
        if (!Schema::hasTable('users')){
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nick')->nullable();
                $table->string('avatar')->nullable();
                $table->string('gender')->nullable();
                $table->string('country')->nullable();
                $table->string('province')->nullable();
                $table->string('city')->nullable();
                $table->string('weixin_openid')->unique()->nullable();
                $table->string('weixin_unionid')->unique()->nullable();
                $table->string('weapp_openid')->nullable()->unique();
                $table->string('weixin_session_key')->nullable();
                $table->timestamps();
                $table->rememberToken();
            });
        }
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
