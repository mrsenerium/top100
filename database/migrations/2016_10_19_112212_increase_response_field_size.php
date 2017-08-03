<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseResponseFieldSize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidate_organizations', function ($table) {
            $table->string('description', 1000)->change();
        });
        Schema::table('candidate_responses', function ($table) {
            $table->string('reflection', 4000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidate_organizations', function ($table) {
            $table->string('description', 255)->change();
        });
        Schema::table('candidate_responses', function ($table) {
            $table->string('reflection', 2000)->change();
        });
    }
}
