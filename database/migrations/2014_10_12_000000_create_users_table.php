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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('first_name');
            $table->string('avatar_url')->nullable();
            $table->date('birthday')->nullable();
            $table->string('hobbies')->nullable();
            $table->integer('level_id')->nullable();
            $table->string('bio')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
