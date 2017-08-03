<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponseOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_organizations', function (Blueprint $table) {
            $table->integer('candidate_id')->unsigned();
            $table->integer('organization_id');
            $table->string('name')->default('');
            $table->string('description')->default('');
            $table->string('position_held')->default('');
            $table->double('involvement_length')->default(0);
            $table->string('involvement_duration')->default('');
            $table->string('organization_type')->default('');
            $table->timestamps();

            $table->primary(['candidate_id', 'organization_id']);
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_organizations');
    }
}
