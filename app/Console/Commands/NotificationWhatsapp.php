<?php

namespace App\Console\Commands;

use App\Dao\Enums\NotificationStatus;
use App\Dao\Models\Notification;
use Illuminate\Console\Command;
use Plugins\WhatsApp;

class NotificationWhatsapp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:whatsapp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'untuk mengirimkan whatsapp otomatis';

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
        $data_wa = Notification::where(Notification::field_status(), NotificationStatus::Create)->limit(env('WA_LIMIT', 1))->get();
        if ($data_wa) {
            foreach ($data_wa as $data) {
                $status = WhatsApp::send($data->field_phone, $data->field_description);
                $wa = json_decode($status);
                if (isset($wa->status) && $wa->status) {
                    $data->{Notification::field_status()} = NotificationStatus::Sent;
                    $data->{Notification::field_etd()} = date('Y-m-d H:i:s');
                    $data->save();
                } else {
                    $data->{Notification::field_status()} = NotificationStatus::Failed;
                    $data->{Notification::field_error()} = $wa->message ?? 'Unknow Error';
                    $data->{Notification::field_etd()} = date('Y-m-d H:i:s');
                    $data->save();
                }
                sleep(env('WA_DELAY', 5));
            }
        }
    }
}
