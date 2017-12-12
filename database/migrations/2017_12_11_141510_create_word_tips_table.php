<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('word_tips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('word_id')->unsigned()->index();
            $table->integer('user_id')->default(0)->nullable();
            $table->text('tip')->nullable();
            $table->integer('praise')->default(0)->nullable();
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
        Schema::dropIfExists('word_tips');
    }
}
