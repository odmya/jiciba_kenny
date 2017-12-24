<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('speech_unique')->index();
            $table->string('openid')->nullable();
            $table->integer('phrase_id');
            $table->integer('section_id');
            $table->integer('chapter_id');
            $table->integer('course_id');
            $table->string('media_serverid')->nullable();
            $table->string('media_path')->nullable();
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
        Schema::dropIfExists('records');
    }
}
