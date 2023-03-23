<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NextPick extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_pick', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cid');
            $table->integer('uid');
            $table->integer('mid')->nullable();
            //status 0 means not pickup yet 1 means picked by user
            $table->integer('status');
            //pass 0 means(there is no skip but if its 1 means there is a skip)
            $table->integer('pass')->default(0);
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
        Schema::dropIfExists('next_pick');
    }
}
