<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_states', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description', 2000);
            $table->string('help_text', 2000);
            $table->dateTime('end_date')->nullable();
        });

        //create states
        DB::table('application_states')->insert([
          [
            'name' => 'Closed',
            'description' => 'The application is closed.',
            'help_text' => 'The application is closed.'
          ],
          [
            'name' => 'Nominations and Applications',
            'description' => 'Accepting nominations for candidates and applications',
            'help_text' => 'Accepting nominations for candidates and applications'
          ],
          [
            'name' => 'Applications Only',
            'description' => 'Accepting applications from nominees',
            'help_text' => 'Accepting applications from nominees'
          ],
          [
            'name' => 'Applications Closed',
            'description' => 'No longer accepting applications',
            'help_text' => 'No longer accepting applications'
          ],
          [
            'name' => 'Round One Judging',
            'description' => 'Round 1 judging in progress',
            'help_text' => 'Round 1 judging in progress'
          ],
          [
            'name' => 'Round One Closed',
            'description' => 'Round 1 judging finished',
            'help_text' => 'Round 1 judging finished'
          ],
          [
            'name' => 'Round Two Open (Recommendations / Guest List)',
            'description' => 'Candidates may receive recommendations and create their guest list',
            'help_text' => 'Candidates may receive recommendations and create their guest list'
          ],
          [
            'name' => 'Round Two Judging',
            'description' => 'Round 2 judging in progress',
            'help_text' => 'Round 2 judging in progress'
          ],
          [
            'name' => 'Round Two Closed',
            'description' => 'Round 2 judging closed',
            'help_text' => 'Round 2 judging closed'
          ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('application_states');
    }
}
