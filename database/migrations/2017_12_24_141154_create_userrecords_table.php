<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userrecords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('speech_unique')->index();
            $table->string('openid')->nullable();
            $table->integer('section_id');
            $table->integer('chapter_id');
            $table->integer('course_id');
            $table->integer('push')->default(0);
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
        Schema::dropIfExists('userrecords');
    }
}
