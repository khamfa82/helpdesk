<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TicketViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      DB::statement("CREATE  OR REPLACE VIEW  `tickets_detailed` AS
      SELECT
          `tic`.`id` AS `id`,
          `tic`.`ticket_number` AS `ticket_number`,
          `tic`.`duedate` AS `duedate`,
          `tic`.`dept_id` AS `dept_id`,
          `tic`.`assigned_to` AS `assignedTo`,
          `tic`.`status` AS `statusID`,
          `tic`.`isanswered` AS `isanswered`,
          `tic`.`isoverdue` AS `isoverdue`,
          `tic`.`is_deleted` AS `is_deleted`,
          `tic`.`is_transferred` AS `is_transferred`,
          `tic`.`follow_up` AS `follow_up`,
          `tic`.`closed` AS `closed`,
          `tic`.`reopened` AS `reopened`,
          `ttr`.`title` AS `ticket_subject`,
      		`ttr`.`id` AS `thread_id`,
      		-- `fnFullNameAndEmail`(`usr`.`first_name`, `usr`.`last_name`, `usr`.`user_name`, `usr`.`email`) AS `owner`,
            CONCAT(`usr`.`first_name`, ' ', `usr`.`last_name`, ' <',`usr`.`email`, '> ') AS `owner`,
      		-- `fnFullNameAndEmail`(`usrr`.`first_name`, `usrr`.`last_name`, `usrr`.`user_name`, `usrr`.`email`) AS `assigned_to`,
            CONCAT(`usrr`.`first_name`, ' ', `usrr`.`last_name`, ' <',`usrr`.`email`, '> ') AS `assigned_to`,
            -- CONCAT(`usrr`.`first_name`,'.','com'),
      		`tics`.`name` as `status`,
      		-- `fnLastActivityOfTicket`(`tic`.`id`) AS `last_activity`,
            `ttr`.`created_at` AS `last_activity`,

      		`ticp`.`priority_color` AS `priority_color`,
          `ticp`.`priority` AS `priority`
      FROM
          `tickets` AS `tic`
          INNER JOIN `users` AS `usr` ON (`tic`.`user_id` = `usr`.`id`)
          INNER JOIN `ticket_thread` AS `ttr` ON (`tic`.`id` = `ttr`.`ticket_id` AND `ttr`.`poster` = 'client')
          INNER JOIN `ticket_status` AS `tics` ON (`tic`.`status` = `tics`.`id`)
          INNER JOIN `ticket_priority` AS `ticp` ON (`tic`.`priority_id` = `ticp`.`priority_id`)
          LEFT JOIN `users` AS `usrr` ON (`tic`.`assigned_to` = `usrr`.`id`)
      ORDER BY `tic`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `answered_tickets` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`closed` <> 1 AND `ttd`.`isanswered` = 1 AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");


      DB::statement("CREATE  OR REPLACE VIEW  `assigned_tickets` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE ((`ttd`.`assignedTo` IS NOT NULL) AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `closed_tickets` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`closed` = 1 AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `closed_tickets_per_department` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`closed` = 1 AND `ttd`.`statusID` <> 2 AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `deleted_tickets` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`is_deleted` = 1)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `follow_up_tickets` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`statusID` = 1 AND `ttd`.`follow_up` = 1 AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `open_tickets_per_department` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`closed` <> 1 AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `reopened_tickets` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`reopened` = 1 AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `resolved_tickets_per_department` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`closed` = 1 AND `ttd`.`statusID` = 2 AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `unanswered_tickets` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE (`ttd`.`closed` <> 1 AND `ttd`.`isanswered` = 0 AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");

      DB::statement("CREATE  OR REPLACE VIEW  `unassigned_tickets` AS
      SELECT
          *
      FROM `tickets_detailed` AS `ttd`
      WHERE ((`ttd`.`assignedTo` IS NULL) AND `ttd`.`is_deleted` = 0)
      ORDER BY `ttd`.`id` DESC
      ");


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW tickets_detailed");
        DB::statement("DROP VIEW answered_tickets");
        DB::statement("DROP VIEW assigned_tickets");
        DB::statement("DROP VIEW closed_tickets");
        DB::statement("DROP VIEW closed_tickets_per_department");
        DB::statement("DROP VIEW deleted_tickets");
        DB::statement("DROP VIEW follow_up_tickets");
        DB::statement("DROP VIEW open_tickets_per_department");
        DB::statement("DROP VIEW resolved_tickets_per_department");
        DB::statement("DROP VIEW unanswered_tickets");
        DB::statement("DROP VIEW unassigned_tickets");
    }
}
