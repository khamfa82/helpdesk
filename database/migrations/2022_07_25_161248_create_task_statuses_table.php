<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTaskStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        DB::table('task_statuses')->insert([
            ['name' => 'CR'],
            ['name' => 'refresh Training'],
            ['name' => 'To be Checked with Customer'],
            ['name' => 'Pending Immigration'],
            ['name' => '-'],
            ['name' => 'Ready for Deployment'],
            ['name' => 'In Progress'],
            ['name' => 'Requirements to be well elaborated by immigrations to be reviewed from 20th -to 23rd Dec'],
            ['name' => 'DUPLICATE'],
            ['name' => 'Tobe discussed from 20th Dec'],
            ['name' => 'DONE'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_statuses');
    }
}
