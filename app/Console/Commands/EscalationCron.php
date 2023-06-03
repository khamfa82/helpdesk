<?php

namespace App\Console\Commands;

use App\Http\Controllers\Agent\helpdesk\TicketController;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class EscalationCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'escalation:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Escalate tickets by due dates ...");
        try {
            Log::info("Escalation by due date have been successfully run on: " . date('Y-m-d H:i:s'));
            $escalate = TicketController::escalateTicketsByDueDate();
            $this->info("Policy: " . $escalate['policy']);
            $this->info("Status:");
            $this->info("------------------------------");
            for ($level = 1; $level <= 3; $level++) {
                $this->info("Escalated Level " . $level . ": " . $escalate['updated'][$level - 1]);
            }
            $this->info("Escalation complete.");
            $this->info("");
        } catch(Exception $e) {
            Log::error("Error occured while escalating tickets by due date on: " . date('Y-m-d H:i:s'));
            $this->error("Error occured while escalating tickets!");
        }
        
        // Separator
        $this->info("");
        
        $this->info("Escalate tickets by SLAs ...");
        try {
            Log::info("Escalation by SLA have been successfully run on: " . date('Y-m-d H:i:s'));
            $escalate = TicketController::escalateTicketsBySLA();
            $this->info("Policy: " . $escalate['policy']);
            $this->info("Status:");
            $this->info("------------------------------");
            for ($level = 1; $level <= 3; $level++) {
                $this->info("Escalated Level " . $level . ": " . $escalate['updated'][$level - 1]);
            }
            $this->info("Escalation complete.");
        } catch(Exception $e) {
            Log::error("Error occured while escalating tickets by SLA on: " . date('Y-m-d H:i:s'));
            $this->error("Error occured while escalating tickets!");
        }
    }
}
