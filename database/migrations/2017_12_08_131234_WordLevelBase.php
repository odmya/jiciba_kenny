<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WordLevelBase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('level_base_word', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('word_id')->unsigned()->index();
          $table->integer('level_base_id')->unsigned()->index();

          $table->foreign('level_base_id')->references('id')->on('level_bases')->onDelete('cascade');
          $table->foreign('word_id')->references('id')->on('words')->onDelete('cascade');

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
        Schema::dropIfExists('level_base_word');
    }
}
