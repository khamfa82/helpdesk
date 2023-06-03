<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TicketStoredFunctions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // DB::unprepared("CREATE DEFINER=`root`@`localhost` FUNCTION `fnFullName`(
      //   `firstName` VARCHAR(100),
      //   `lastName` VARCHAR(100),
      //   `username` VARCHAR(100)
      // ) RETURNS varchar(100) CHARSET utf8
      // DETERMINISTIC
      // BEGIN
      // DECLARE `name` VARCHAR(100);

      // IF(`username` != '' and `username` is not null) THEN
  		// SET `name` = `username`;
      // END IF;

    	// IF(`firstName` != '' and `firstName` is not null) THEN
    	// 	IF(`lastName` != '' and `lastName` is not null)  THEN
    	// 	    SET `name` =  concat(`firstName`, ' ',`lastName`);
    	// 	ELSE
    	// 		SET `name` = `firstName`;
    	// 	END IF;
    	// END IF;

    	// RETURN (`name`);

      // END;
      // ");


      // DB::unprepared("CREATE DEFINER=`root`@`localhost` FUNCTION `fnFullNameAndEmail`(
    	// firstName varchar(50),
    	// lastName varchar(50),
    	// username varchar(50),
    	// email varchar(100)
      // )
      // RETURNS varchar(100) CHARSET utf8
      // DETERMINISTIC
      // BEGIN
      //   DECLARE name varchar(50);
      //   DECLARE value varchar(100);

      //   SET name = fnFullName(firstName, lastName, username);

      //   IF(name != '' and name is not null) THEN
    	// 	SET value = CONCAT (name, ' <', email, '>');
      //   END IF;

    	//   RETURN (value);
      // END;
      // ");

      // DB::unprepared("CREATE DEFINER=`root`@`localhost` FUNCTION `fnLastActivityOfTicket`(
      // `ticketID` BIGINT
      // )
      // RETURNS datetime
      // DETERMINISTIC
      // BEGIN
      //     DECLARE last_activity DATETIME;

      //     SET last_activity = null;

      //     SELECT created_at INTO last_activity from ticket_thread
      //     WHERE ticket_id = ticketID
      //     ORDER BY id DESC
      //     LIMIT 1;


      //     IF(last_activity is null) THEN
      //        SELECT created_at INTO last_activity from tickets
      //        WHERE id = ticketID;
      //     END IF;

      // 	RETURN(last_activity);

      // END;
      // ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS fnFullName');
        DB::unprepared('DROP FUNCTION IF EXISTS fnFullNameAndEmail');
        DB::unprepared('DROP FUNCTION IF EXISTS fnLastActivityOfTicket');
    }
}
