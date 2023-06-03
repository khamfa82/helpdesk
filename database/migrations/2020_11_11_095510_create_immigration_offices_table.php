<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImmigrationOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('immigration_offices', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('Key')->unique();
            $table->bigInteger('TableID')->unsigned();
            $table->string('Office')->nullable();
            $table->string('OfficeType');
            $table->string('Abbrev')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('hide')->default(0);
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
        Schema::dropIfExists('immigration_offices');
    }
}
