<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovelContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novel_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('novel_chapter_id');
            $table->text('english');
            $table->text('chinese')->nullable();
            $table->string('slow_audio_path')->nullable();
            $table->string('audio_path')->nullable();
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
        Schema::dropIfExists('novel_contents');
    }
}
