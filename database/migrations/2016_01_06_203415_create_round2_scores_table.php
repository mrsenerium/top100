<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRound2ScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('round2_scores', function (Blueprint $table) {
            $table->integer('candidate_id')->unsigned();
            $table->integer('judge_id')->unsigned();
            $table->boolean('application_read')->default(false);
            $table->integer('rank_position')->default(0);
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
        Schema::drop('round2_scores');
    }
}
