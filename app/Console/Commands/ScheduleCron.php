<?php

namespace App\Console\Commands;

use App\Mail\CreateScheduleEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ScheduleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:cron';

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
        //   CreateScheduleListener::class;
        $report_from = 'admin@demo.com' ?? false;
        $report_to = 'admin@demo.com' ?? false;

        if ($report_to) {
            Mail::to([$report_from, $report_to])->send(new CreateScheduleEmail(null));
            Log::info("Cron is working fine!");
        }

    }
}
