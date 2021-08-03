<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bookmarks', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('photo_id');
        });

//        Schema::table('user_bookmarks', function($table) {
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('photo_id')->references ('id')->on('photos')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bookmarks');
    }
}
