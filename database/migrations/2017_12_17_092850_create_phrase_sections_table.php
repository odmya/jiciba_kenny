<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhraseSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phrase_sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('phrase_id')->unsigned()->index();
            $table->integer('section_id')->unsigned()->index();
            $table->integer('sort')->unsigned()->default(0);

            $table->foreign('phrase_id')->references('id')->on('phrases')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');

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
        Schema::dropIfExists('phrase_sections');
    }
}
