<?php

namespace App\Http\Controllers;

use App\Dao\Repositories\AppLinenRepository;
use App\Http\Requests\GeneralRequest;
use App\Http\Requests\LinenRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateRoleService;
use App\Http\Services\UpdateService;
use Illuminate\Http\Request;
use Plugins\Response;

class AppLinenController extends MasterController
{
    public function __construct(AppLinenRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    public function postCreate(GeneralRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, GeneralRequest $request, UpdateService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getUpdate($code)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);

        $data = $this->get($code);

        return moduleView(modulePathForm(), $this->share([
            'model' => $data,
        ]));
    }
}
