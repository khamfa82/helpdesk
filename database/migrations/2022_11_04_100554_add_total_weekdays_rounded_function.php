<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTotalWeekdaysRoundedFunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::unprepared('
        //     CREATE FUNCTION TOTAL_WEEKDAYS_ROUNDED(date1 DATE, date2 DATE)
        //     RETURNS INT
        //     RETURN ROUND(DATEDIFF(date2, date1), 2) + 1
        //         - ROUND(DATEDIFF(ADDDATE(date2, INTERVAL 1 - DAYOFWEEK(date2) DAY),
        //                         ADDDATE(date1, INTERVAL 1 - DAYOFWEEK(date1) DAY)), 2) / 7 * 2
        //         - (DAYOFWEEK(IF(date1 < date2, date1, date2)) = 1)
        //         - (DAYOFWEEK(IF(date1 > date2, date1, date2)) = 7);
        // ');

        DB::unprepared('
            CREATE FUNCTION TOTAL_WEEKDAYS_ROUNDED(date1 DATETIME, date2 DATETIME)
            RETURNS FLOAT
            RETURN timestampdiff(second, date2, date1) / (24 * 60 * 60);
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('
            DROP FUNCTION IF EXISTS TOTAL_WEEKDAYS_ROUNDED
        ');
    }
}
