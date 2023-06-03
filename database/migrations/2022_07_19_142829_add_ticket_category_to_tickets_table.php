<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketCategoryToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('ticket_category_id')->unsigned()->nullable()->default(3);
            $table->foreign('ticket_category_id', 'ticket_category_id_foreign')->references('id')->on('ticket_categories')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('ticket_category_id_foreign');
            $table->dropColumn('ticket_category_id');
        });
    }
}
