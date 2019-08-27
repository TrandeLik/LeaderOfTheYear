<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('id')->unsigned();
            $table->string('category');
            $table->string('type');
            $table->string('name');
            $table->string('subject');
            $table->string('stage');
            $table->string('result');
            $table->string('date');
            $table->float('score');
            $table->string('confirmation');
            $table->string('status');
            
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('achievements');
    }
}
