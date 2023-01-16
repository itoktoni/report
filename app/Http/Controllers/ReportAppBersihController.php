<?php

namespace App\Http\Controllers;

use App\Dao\Models\AppBersih;
use App\Dao\Models\AppKotor;
use App\Dao\Models\Bersih;
use App\Dao\Models\Kotor;
use App\Dao\Models\Upload;
use App\Dao\Models\ViewMutasi;
use App\Dao\Models\ViewRs;
use App\Dao\Repositories\UploadRepository;
use App\Dao\Repositories\ViewBersihRepository;
use App\Dao\Repositories\ViewMutasiRepository;
use App\Http\Requests\BersihRequest;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\UploadRequest;
use App\Http\Services\CreateBersihService;
use App\Http\Services\CreateUploadService;
use App\Http\Services\UpdateService;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Support\Facades\Cache;
use Plugins\Response;
use Plugins\Template;

class ReportAppBersihController extends MinimalController
{
    public $bersih;
    public $kotor;
    public static $repository;

    public function __construct(ViewBersihRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    public function getCreate()
    {
        $rs = ViewRs::getOptions();
        return moduleView(modulePathForm(), [
            'rs' => $rs,
            'model' => false,
        ]);
    }

    // public function getPrint(){

    //     $code = request()->get('code');
    //     $this->bersih = Bersih::where(Bersih::field_upload(), $code)->cursor();
    //     $this->kotor = Kotor::where(Kotor::field_upload(), $code)->get();

    //     $location = $linen = [];
    //     if($this->bersih){

    //         $location = $this->bersih->mapToGroups(function ($item, $key) {
    //             return [$item['bersih_lokasi'] => $item];
    //         });

    //         $linen = $this->bersih->mapToGroups(function ($item, $key) {
    //             return [$item['bersih_nama_linen'] => $item];
    //         });

    //     }

    //     if($this->kotor){

    //         $linen_kotor = $this->kotor->mapToGroups(function ($item, $key) {
    //             return [$item['kotor_nama_linen'] => $item];
    //         });

    //     }

    //     return moduleView(Template::print(SharedData::get('template')), $this->share([
    //         'model' => $this->bersih->first(),
    //         'linen' => $linen,
    //         'linen_kotor' => $linen_kotor,
    //         'bersih' => $this->bersih,
    //         'kotor' => $this->kotor,
    //         'location' => $location
    //     ]));
    // }

    public function getPrint(){

        $this->data = self::$repository->getPrint()->get();

        $this->bersih = AppBersih::where(AppBersih::field_tanggal(),'>=', request()->get('start_date'))
        ->where(AppBersih::field_tanggal(),'<=', request()->get('end_date'))
        ->get();

        $this->kotor = AppKotor::where(AppKotor::field_tanggal_bersih(),'>=', request()->get('start_date'))
        ->where(AppKotor::field_tanggal_bersih(),'<=', request()->get('end_date'))
        ->get();


        $location = $linen = [];
        if($this->bersih){

            $location = $this->bersih->mapToGroups(function ($item, $key) {
                return [$item['bersih_lokasi'] => $item];
            })->sortKeys();;

            $linen = $this->bersih->mapToGroups(function ($item, $key) {
                return [$item['bersih_nama_linen'] => $item];
            })->sortKeys();;

        }

        if($this->kotor){

            $linen_kotor = $this->kotor->mapToGroups(function ($item, $key) {
                return [$item['kotor_nama_linen'] => $item];
            });

        }

        return moduleView(modulePathPrint(), $this->share([
            'model' => $this->bersih->first(),
            'linen' => $linen,
            'linen_kotor' => $linen_kotor,
            'bersih' => $this->bersih,
            'kotor' => $this->kotor,
            'location' => $location
        ]));
    }
}