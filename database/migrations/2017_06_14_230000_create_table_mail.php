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
            $table->increments('id');
            $table->integer('sender_id');
            $table->string('title')->nullable();
            $table->text('content');
            $table->integer('attach_id')->nullable();
            $table->timestamp('sent_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('status')->nullable();
            $table->integer('type')->nullable();
            $table->integer('thread_id');
            
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
