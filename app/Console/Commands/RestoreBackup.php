<?php
namespace App\Console\Commands;

use ZipArchive;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class RestoreBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the last backup from s3';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Startup
        $this->info('Restoring backup from s3');

        // Get Last backup file
        $lastFile = collect(Storage::disk('storage')->allFiles())->last();
        $this->info('Last backup found: ' . $lastFile);

        // Download File
        $this->info('Downloading ZIP file...');

        Storage::disk('local')->writeStream('backups/' . $lastFile, Storage::disk($this->getBackupDisk())->readStream($lastFile));
        $this->info('Zip File downloaded');

        // Unzip
        $this->info('Unzipping file...');
        $success = $this->unzipBackup($lastFile);

        if ($success) {
            $this->info('Unzipping successful !');
            $this->startDump();
        } else {
            $this->error('Zip file not found');
        }
    }

    private function getBackupDisk()
    {
        return config('backup.backup.destination.disks')[0];
    }

    private function getBackupName()
    {
        return config('backup.backup.name');
    }

    private function unzipBackup($file)
    {
        $zip = new ZipArchive;
        $res = $zip->open(
            Storage::disk('local')->path('backups/' . $file)
        );
        if ($res === TRUE) {
            $zip->extractTo(Storage::disk('local')->path('backups/'.$this->getBackupName()));
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    private function startDump()
    {
        // Wipe Database
        $this->info('Wipe DB...');
        Artisan::call('db:wipe');
        $this->info('Database wiped');

        // Import SQL file
        $this->info('Dumping SQL dump...');
        $sqlFile = Storage::disk('local')->path('backups/'.$this->getBackupName().'/db-dumps/mysql-'.config('database.connections.mysql.database').'.sql');

        // Files is sometimes too big to be imported with PHP, so we run a mysql command instead
        if (config('database.mysql.password')) {
            exec("mysql -u ".config('database.connections.mysql.username')." -p".config('database.connections.mysql.password')." ".config('database.connections.mysql.database')." < " . $sqlFile);
        } else {
            exec("mysql -u ".config('database.connections.mysql.username')." ".config('database.connections.mysql.database')." < " . $sqlFile);
        }

        $this->info('Done !');
    }
}