<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRound1ScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('round1_scores', function (Blueprint $table) {
            $table->integer('candidate_id')->unsigned();
            $table->integer('judge_id')->unsigned();
            $table->integer('academics_score')->nullable();
            $table->integer('reflection_score')->nullable();
            $table->integer('activities_score')->nullable();
            $table->integer('services_score')->nullable();
            $table->timestamps();

            $table->primary(['candidate_id', 'judge_id']);
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
            $table->foreign('judge_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('round1_scores');
    }
}
