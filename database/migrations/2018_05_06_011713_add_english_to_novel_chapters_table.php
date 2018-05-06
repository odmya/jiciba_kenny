<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnglishToNovelChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('novel_chapters', function (Blueprint $table) {
          $table->text('english')->nullable()->after('description');
          $table->text('chinese')->nullable()->after('english');
          $table->string('audio_path')->nullable()->after('chinese');

            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('novel_chapters', function (Blueprint $table) {
            //
        });
    }
}
