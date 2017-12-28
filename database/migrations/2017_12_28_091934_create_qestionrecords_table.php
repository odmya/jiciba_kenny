<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQestionrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qestionrecords', function (Blueprint $table) {
            $table->increments('id');
            $table->string('speech_unique')->index();
            $table->string('openid')->nullable();
            $table->integer('question_id');
            $table->integer('correct');
            $table->integer('student_answer');
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
        Schema::dropIfExists('qestionrecords');
    }
}
