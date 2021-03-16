<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikeMutterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('like_mutter', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('like_user_id');
            $table->unsignedBigInteger('like_mutter_id');
            $table->timestamps();

            $table->foreign('like_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('like_mutter_id')->references('id')->on('mutters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like_mutter');
    }
}
