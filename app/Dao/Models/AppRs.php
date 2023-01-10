<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\AppRsEntity;
use App\Dao\Entities\PricingEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Console\Presets\Bootstrap;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Illuminate\Support\Str;

class AppRs extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, AppRsEntity, ActiveTrait, ActiveTrait, OptionTrait;

    protected $table = 'app_rs';
    protected $primaryKey = 'rs_id';

    protected $fillable = [
        'rs_id',
        'rs_nama',
        'rs_harga',
    ];

    public $sortable = [
        'rs_nama',
        'rs_harga',
    ];

    protected $casts = [
        'rs_harga' => 'integer',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function fieldSearching()
    {
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('Code')->show(false)->sort(),
            DataBuilder::build($this->field_name())->name('Name')->show(true)->sort(),
            DataBuilder::build($this->field_harga())->name('Harga')->show(true)->sort(),
        ];
    }
}
