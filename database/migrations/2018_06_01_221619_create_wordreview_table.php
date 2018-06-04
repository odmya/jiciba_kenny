<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordreviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wordreview', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('word_id');
            $table->tinyInteger('status')->nullable();
            $table->integer('remember_time')->nullable();
            $table->string('next_time')->nullable();
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
        Schema::dropIfExists('wordreview');
    }
}
