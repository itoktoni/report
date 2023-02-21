<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OutstandingPending extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'outstanding:pending';

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

        try {

           $outstanding = DB::connection('server')
           ->table('linen_outstanding')
           ->where('linen_outstanding_updated_at', Carbon::now()->subMinutes(1440)->toDateString())
        //    ->whereDate('linen_outstanding_updated_at', date('Y-m-d'))
           ->where('linen_outstanding_status', '!=', 6) //pending
           ->where('linen_outstanding_status', '!=', 7) //hilang
           ->get();

            $rfid = $outstanding->pluck('linen_outstanding_rfid');
            $this->info($rfid);

            $map = $rfid->map(function($item){
                $data = [
                    'item_linen_detail_rfid' => $item,
                    'item_linen_detail_status' => 6,
                    'item_linen_detail_description' => 'Pending',
                    'item_linen_detail_created_at' => date('Y-m-d H:i:s'),
                    'item_linen_detail_updated_at' => date('Y-m-d H:i:s'),
                    'item_linen_detail_updated_by' => '1',
                    'item_linen_detail_created_by' => '1',
                ];
                return $data;
            });

            DB::connection('server')->table('item_linen_detail')->insert($map->unique()->toArray());
            DB::connection('server')->table('linen_outstanding')->whereIn('linen_outstanding_rfid', $rfid->toArray())
            ->update([
                'linen_outstanding_status' => 6, //pending
                'linen_outstanding_pending_at' => date('Y-m-d H:i:s'),
            ]);
            DB::connection('server')->table('item_linen')->whereIn('item_linen_rfid', $rfid->toArray())->update([
                'item_linen_latest' => 6, //pending
            ]);

            $this->info('data berhasil');

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->error($e->getMessage());
        }
    }
}