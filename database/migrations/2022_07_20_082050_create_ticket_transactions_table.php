<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->unsigned();
            $table->foreign('ticket_id', 'ticket_id_foreign')->references('id')->on('tickets')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('initiated_by')->unsigned();
            $table->foreign('initiated_by', 'initiated_by_foreign')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('assigned_to')->unsigned();
            $table->foreign('assigned_to', 'assigned_to_foreign')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('transaction_by')->unsigned();
            $table->foreign('transaction_by', 'transaction_by_foreign')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('transaction_status')->unsigned()->default(1)->nullable()->comment('statuses are 1 = open, 2 = resolved and 3 = closed');
            $table->foreign('transaction_status', 'transaction_status_foreign')->references('id')->on('ticket_status')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_transactions');
    }
}
