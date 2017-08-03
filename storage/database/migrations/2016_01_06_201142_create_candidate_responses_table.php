<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_responses', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('additional_majors')->default('');
            $table->string('academic_honors')->default('');
            $table->string('reflection', 2000)->default('');
            $table->boolean('submitted')->default(false);
            $table->timestamps();

            $table->foreign('id')->references('id')->on('candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_responses');
    }
}
