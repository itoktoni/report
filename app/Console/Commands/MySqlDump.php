<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Support\Facades\Storage;

class MySqlDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

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
        $name = date('Y-m-d-His').'_backup_database';

        try {

            $dumpSettingsDefault = [
                'compress' => 'Gzip',
            ];

            $dump = new IMysqldump\Mysqldump('mysql:host='.env('DB_HOST_SERVER').';dbname='.env('DB_DATABASE_SERVER').'', env('DB_USERNAME_SERVER'), env('DB_PASSWORD_SERVER'), $dumpSettingsDefault);
            $dump->start(__DIR__.'../../../../'.env('BACKUP_PATH').$name.'.gzip');

            $this->info('Backup Finish '.$name.'.gzip');

        } catch (\Exception $e) {
            $errror = 'mysqldump-php error: ' . $e->getMessage();
            $this->error($errror);
        }
    }
}