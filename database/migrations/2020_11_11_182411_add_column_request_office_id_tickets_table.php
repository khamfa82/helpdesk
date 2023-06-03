<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRequestOfficeIdTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('immigration_office_id')->nullable();
            $table->foreign('immigration_office_id', 'fk_immigration_office_id_tickets1_idx')->references('key')->on('immigration_offices')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_thread', function (Blueprint $table) {
            $table->dropForeign('fk_immigration_office_id_tickets1_idx');
            $table->dropColumn(['immigration_office_id']);
        });
    }
}
