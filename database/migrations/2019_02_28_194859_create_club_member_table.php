<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('club_member', function (Blueprint $table) {
          $table->integer('cid')->unsigned();
          $table->foreign('cid')->references('cid')->on('club')->onDelete('cascade');
          $table->integer('uid')->unsigned();
          $table->foreign('uid')->references('uid')->on('users')->onDelete('cascade');
          $table->string('admin')->default(0);
          $table->integer('position');
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
        Schema::dropIfExists('club_member');
    }
}
