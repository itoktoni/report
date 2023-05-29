<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ObsesimanDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:obsesiman';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the mysqldump utility using info from .env';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Backup Start');
        Log::info('Log Start');
        $name = date('Y-m-d-His').'_backup_obsesiman.gzip';

        try {

            $dumpSettingsDefault = [
                'compress' => 'Gzip',
                'single-transaction' => true,
                'exclude-tables' => [
                    'telescope_entries',
                    'telescope_entries_tags',
                    'telescope_monitoring',
                    // 'view_balance',
                    // 'view_balance_detail',
                    // 'view_history_linen',
                    // 'view_kotor_bersih',
                    // 'view_linen',
                    // 'view_min_max',
                    // 'view_opname',
                    // 'view_opname_register',
                    // 'view_pemakaian_linen',
                    // 'view_stock',
                    // 'view_stock_linen',
                ],
            ];

            $dump = new IMysqldump\Mysqldump('mysql:host='.env('DB_HOST_SERVER').';dbname='.env('DB_DATABASE_SERVER').'', env('DB_USERNAME_SERVER'), env('DB_PASSWORD_SERVER'), $dumpSettingsDefault);
            $dump->start(storage_path('app/'.$name));

            $this->info('Backup Databaes '.$name);

            $contents = File::get(storage_path('app/'.$name));
            // $local = Storage::disk('backup')->put('Obsesiman/'.$name, $contents);
            $alphara = Storage::disk('alphara')->put('Lts/'.$name, $contents);

            if($alphara){
                $this->info('Backup Finish '.$name);
            }

            unlink(storage_path('app/'.$name));

        } catch (\Exception $e) {
            $errror = 'mysqldump-php error: ' . $e->getMessage();
            $this->error($errror);
        }
    }
}