<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_team_id')->unsigned()->index();
            $table->integer('to_team_id')->unsigned()->index();
            $table->string('remarks')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('hide')->default(0);
            $table->timestamps();

            $table->foreign('from_team_id')->references('id')->on('teams');
            $table->foreign('to_team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('team_assignments', function (Blueprint $table) {
            $table->dropForeign('from_team_id');
            $table->dropForeign('to_team_id');
        });

        Schema::dropIfExists('team_assignments');
    }
}
