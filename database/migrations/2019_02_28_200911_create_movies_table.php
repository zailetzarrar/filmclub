<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('mid');
            $table->integer('cid');
            $table->integer('uid');
            $table->string('title');
            $table->string('director');
            $table->integer('year');
            $table->text('description')->nullable();
            $table->string('genres')->nullable();
            $table->string('poster')->nullable();
            $table->dateTime('time_limit');
            //status 0 means movie ends 1 means current movie and 2 means next movie for club
            $table->integer('status');
            $table->integer('rid')->unsigned()->nullable();
            $table->foreign('rid')->references('id')->on('club_rounds')->onDelete('cascade');
            $table->timestamps();
        });
    }

    //here status field show these
    // 0 means movie ended
    // 1 means currently ongoing movie
    // 2 means next movie for particular round

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
