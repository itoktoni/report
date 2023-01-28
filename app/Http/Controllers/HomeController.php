<?php

namespace App\Http\Controllers;

use Alkhachatryan\LaravelWebConsole\LaravelWebConsole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Plugins\Query;
use Plugins\Template;
use App\Charts\dashboard;
use App\Dao\Enums\TicketStatus;
use App\Dao\Models\TicketSystem;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(auth()->check()){
            return redirect()->route('login');
        }
    }

    private function unzipBackup($file)
    {
        $zip = new ZipArchive;
        $res = $zip->open(
            Storage::disk('local')->path('OBSESIMAN/' . $file)
        );
        if ($res === TRUE) {
            $zip->extractTo(Storage::disk('local')->path('OBSESIMAN/test.sql'));
            $zip->close();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $lastFile = collect(Storage::disk('storage')->allFiles('OBSESIMAN'))->last();

        if(auth()->check() && auth()->user()->active == false){
            return redirect()->route('login');
        }

        return view('pages.home.home');
    }

    public function console()
    {
        return LaravelWebConsole::show();
    }

    public function doc(){
        return view('doc');
    }

    public function error402(){
        return view('errors.402');
    }
}
