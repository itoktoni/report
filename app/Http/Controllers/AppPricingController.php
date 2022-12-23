<?php

namespace App\Http\Controllers;

use App\Dao\Enums\UserLevel;
use App\Dao\Models\AppPricing;
use App\Dao\Models\Pricing;
use App\Dao\Models\SystemGroup;
use App\Dao\Models\ViewLinen;
use App\Dao\Models\ViewRs;
use App\Dao\Repositories\PricingRepository;
use App\Http\Requests\PricingRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Services\CreateService;
use App\Http\Services\SingleService;
use App\Http\Services\UpdateRoleService;
use App\Http\Services\UpdateService;
use Coderello\SharedData\Facades\SharedData;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Plugins\Response;
use Plugins\Template;

class AppPricingController extends MasterController
{
    public function __construct(PricingRepository $repository, SingleService $service)
    {
        self::$repository = self::$repository ?? $repository;
        self::$service = self::$service ?? $service;
    }

    protected function beforeForm(){

        $linen = ViewLinen::getOptions();
        $rs = ViewRs::getOptions();

        self::$share = [
            'rs' => $rs,
            'linen' => $linen,
        ];
    }

    public function postCreate(PricingRequest $request, CreateService $service)
    {
        $data = $service->save(self::$repository, $request);
        return Response::redirectBack($data);
    }

    public function postUpdate($code, RoleRequest $request, UpdateRoleService $service)
    {
        $data = $service->update(self::$repository, $request, $code);
        return Response::redirectBack($data);
    }

    public function getUpdate($code)
    {
        $this->beforeForm();
        $this->beforeUpdate($code);

        $data = $this->get($code, ['has_group']);
        $selected = $data->has_group->pluck('system_group_code') ?? [];

        return moduleView(modulePathForm(), $this->share([
            'model' => $data,
            'selected' => $selected,
        ]));
    }

    public function xgetLinenByRs(Request $request)
    {
        $linen = ViewLinen::where(ViewLinen::field_rs(), $request->{AppPricing::field_rs()})->get();
        return moduleView(modulePathForm('linen'), $this->share([
            'linen' => $linen,
        ]));
    }

}
