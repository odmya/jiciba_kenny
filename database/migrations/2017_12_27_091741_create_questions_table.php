<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->text('description_zh')->nullable();
            $table->text('description_en')->nullable();
            $table->text('question_zh')->nullable();
            $table->text('question_en')->nullable();
            $table->string('image_url')->nullable();
            $table->string('phrase_list')->nullable();
            $table->integer('correct_answer')->nullable();
            $table->string('audio_path')->nullable();
            $table->boolean('parent_id')->default(false);
            $table->integer('sort')->default(0);
            $table->boolean('enable')->default(false);
            $table->integer('type')->default(0);
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
        Schema::dropIfExists('questions');
    }
}
