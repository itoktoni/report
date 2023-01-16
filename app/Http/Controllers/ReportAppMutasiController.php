<?php

namespace App\Http\Controllers;

use App\Dao\Models\ViewMutasi;
use App\Dao\Models\ViewRs;
use App\Dao\Repositories\ViewMutasiRepository;
use Coderello\SharedData\Facades\SharedData;
use Plugins\Template;

class ReportAppMutasiController extends MinimalController
{
    public $data;

    public function __construct(ViewMutasiRepository $repository)
    {
        self::$repository = self::$repository ?? $repository;
    }

    protected function beforeForm(){

        $rs = ViewRs::getOptions();

        self::$share = [
            'rs' => $rs,
        ];
    }

    public function getPrint(){
        set_time_limit(0);
        $this->data = self::$repository->getPrint()->get();

        $date = $linen = [];
        if($this->data){

            $date = $this->data->unique(ViewMutasi::field_tanggal())->pluck(ViewMutasi::field_tanggal());
            $linen = $this->data->mapToGroups(function ($item, $key) {
                return [$item[ViewMutasi::field_name()] => $item];
            });

        }

        return moduleView(modulePathPrint(), $this->share([
            'model' => $this->data->first(),
            'data' => $this->data,
            'linen' => $linen->sortKeys(),
            'date' => $date
        ]));
    }
}