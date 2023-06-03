<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TicketsStoredProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetClosedTicketsPerDept`(
        IN `dept_name` VARCHAR(50) CHARSET utf8)
        NO SQL
        BEGIN

            SET @deptID := (SELECT id from department
            where name LIKE dept_name COLLATE utf8_unicode_ci);

            SELECT * FROM  tickets_detailed ttd
            WHERE ttd.closed = 1 AND ttd.statusID <> 2
            AND ttd.is_deleted = 0 AND ttd.dept_id = @deptID;
        END;");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetDeletedTickets`(
        IN `departmentID` INT)
        NO SQL
        BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.statusID = 5 AND ttd.is_deleted = 1 AND
                (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                );
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetDeletedTicketsPerDept`(
        IN `dept_name` VARCHAR(50) CHARSET utf8)
        NO SQL
        BEGIN

            SET @deptID := (SELECT id from department
            where name LIKE dept_name COLLATE utf8_unicode_ci);

            SELECT * FROM  tickets_detailed ttd
          	WHERE ttd.statusID = 5 AND ttd.is_deleted = 1
            AND ttd.dept_id = @deptID;
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetDueTodayTickets`(
        IN `departmentID` INT)
        NO SQL
        BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE
        		ttd.statusID = 1 AND ttd.isanswered = 0 AND ttd.is_deleted = 0 AND
                DATEDIFF(ttd.duedate, NOW()) = 0  AND (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                );
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetInboxTickets`(
        IN `departmentID` INT, IN `assignedTo` INT)
        NO SQL
        BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.is_deleted = 0 AND (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                    OR
                  CASE
                    WHEN assignedTo != '' THEN ttd.assignedTo = assignedTo ELSE TRUE END
                );
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetMyTickets`(
        IN `assignedTo` INT)
        NO SQL
        BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.statusID = 1 AND ttd.is_deleted = 0 AND ttd.closed <> 1 AND
                (
                  CASE
                    WHEN assignedTo != '' THEN ttd.assignedTo = assignedTo ELSE TRUE END
                );
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetOpenTicketsPerDept`(
        IN `dept_name` VARCHAR(50) CHARSET utf8)
        NO SQL
        BEGIN

            SET @deptID := (SELECT id from department
            where name LIKE dept_name COLLATE utf8_unicode_ci);

            SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.closed <> 1 AND ttd.is_deleted = 0
            AND ttd.dept_id = @deptID;
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetOverdueTickets`(
        IN `departmentID` INT)
        NO SQL
        BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE
        		ttd.statusID = 1 AND ttd.isanswered = 0 AND ttd.duedate < NOW() AND ttd.is_deleted = 0 AND (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END);
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetResolvedTicketsPerDept`(
        IN `dept_name` VARCHAR(50) CHARSET utf8)
        NO SQL
        BEGIN

            SET @deptID := (SELECT id from department
            where name LIKE dept_name COLLATE utf8_unicode_ci);

            SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.closed = 1 AND ttd.statusID = 2
            AND ttd.is_deleted = 0 AND ttd.dept_id = @deptID;
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetTickets`(
        IN `departmentID` INT, IN `assignedTo` INT)
        NO SQL
        BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE
        		ttd.is_deleted = 0 AND (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                    OR
                  CASE
                    WHEN assignedTo != '' THEN ttd.assignedTo = assignedTo ELSE TRUE END
                );
        END;");


        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetUnassignedTickets`(
        IN `departmentID` INT)
        NO SQL
        BEGIN
        	SELECT * FROM  tickets_detailed ttd
        	WHERE ttd.statusID = 1 AND (ttd.assignedTo IS NULL) AND ttd.is_deleted = 0 AND
                (
                  CASE
                    WHEN departmentID != '' THEN ttd.dept_id = departmentID ELSE TRUE END
                );
        END;");





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetClosedTicketsPerDept');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetDeletedTickets');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetDeletedTicketsPerDept');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetDueTodayTickets');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetInboxTickets');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetMyTickets');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetOpenTicketsPerDept');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetOverdueTickets');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetResolvedTicketsPerDept');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetTickets');
        DB::unprepared('DROP PROCEDURE IF EXISTS spGetUnassignedTickets');
    }
}
