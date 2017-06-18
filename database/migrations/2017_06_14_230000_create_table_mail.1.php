<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mails', function (Blueprint $table) {
            $table->increments('mail_id');
            $table->integer('sender_id');
            $table->string('title')->nullable();
            $table->text('content');
            $table->boolean('hasAttachment');
            $table->date('send_date')->nullable();
            $table->integer('status');
            $table->integer('type');
            
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
        Schema::dropIfExists('mails');
    }
}
