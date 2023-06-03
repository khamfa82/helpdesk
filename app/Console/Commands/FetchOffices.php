<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchOffices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:fetchoffice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Office From Internal Border API';

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
        if( \App\ImmigrationOffice::fetch_immigration_offices() ){
            $this->info("Command Executed Successfully");
        }else{
            $this->alert("Error Occured No Change Was Effected.");
        }

        // $message = 'sample ';
        // $this->command->info($message);
        // $this->command->line($message . 'line');
        // $this->command->comment($message . 'comment');
        // $this->command->question($message . 'question');
        // $this->command->error($message . 'error');
        // $this->command->warn($message . 'warn');
        // $this->command->alert($message . 'alert');
    }
}
