<?php

namespace App\Dao\Repositories;

use App\Dao\Interfaces\CrudInterface;
use App\Dao\Models\ViewMutasi;
use App\Dao\Models\ViewMutasiServer;

class ViewBersihRepository extends MasterRepository implements CrudInterface
{
    public function __construct()
    {
        $this->model = empty($this->model) ? new ViewMutasi() : $this->model;
    }

    public function getPrint(){
        return $this->model->query()->filter()->orderBy(ViewMutasi::field_tanggal());
    }
}
