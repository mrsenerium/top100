<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->char('gender', 1);
            $table->decimal('gpa', 3, 2);
            $table->integer('class');
            $table->string('college');
            $table->string('major');
            $table->integer('total_hours');
            $table->boolean('nominated')->default(false);
            $table->boolean('disqualified')->default(false);
            $table->float('round1_score')->default(0);
            $table->boolean('top100')->default(false);
            $table->float('round2_score')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidates');
    }
}
