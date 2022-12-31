<?php

namespace App\Http\Controllers;

use App\Dao\Models\AppUpload;
use App\Dao\Models\AppBersih;
use App\Dao\Models\AppKotor;
use App\Dao\Repositories\AppUploadRepository;
use App\Http\Requests\AppUploadRequest;
use App\Http\Requests\GeneralRequest;
use App\Http\Services\CreateAppUploadService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateService;
use Coderello\SharedData\Facades\SharedData;
use Illuminate\Http\Request;
use Plugins\Response;
use Plugins\Template;

class AppUploadController extends MasterController
{
    public $bersih;
    public $kotor;

    public function __construct(AppUploadRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    public function getCreate()
    {
        $this->beforeForm();
        $this->beforeCreate();
        return moduleView(modulePathForm(), $this->share());
    }

    public function postCreate(AppUploadRequest $request, CreateAppUploadService $service)
    {
        $data = $service->save(self::$repository, $request);
        if(isset($data['status']) && $data['status']){
            return Response::redirectTo(moduleRoute('getPrint', ['code' => $request->get(AppUpload::field_name())]));
        }

        return Response::redirectBack();
    }

    public function postUpdate($code, GeneralRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getPrint(){

        $code = request()->get('code');
        $this->bersih = AppBersih::where(AppBersih::field_upload(), $code)->cursor();
        $this->kotor = AppKotor::where(AppKotor::field_upload(), $code)->get();

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