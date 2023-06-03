<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTaskModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        DB::table('task_modules')->insert([
            ['name' => 'epassport'],
            ['name' => 'evisa'],
            ['name' => 'epermit'],
            ['name' => 'epass'],
            ['name' => 'usermgt'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_modules');
    }
}
