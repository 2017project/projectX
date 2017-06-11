<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFriendshipDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friendship_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('friend_id');
            $table->date('request_date');
            $table->date('accept_date')->nullable();
            $table->integer('friendship_level');
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
        Schema::dropIfExists('friendship_details');
    }
}
