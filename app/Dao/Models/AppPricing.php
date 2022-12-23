<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
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

class AppPricing extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, PricingEntity, ActiveTrait, ActiveTrait, OptionTrait;

    protected $table = 'app_pricing';
    protected $primaryKey = 'pricing_code';
    protected $keyType = 'string';

    protected $fillable = [
        'pricing_code',
        'pricing_nama',
        'pricing_harga',
        'pricing_berat',
        'pricing_rs',
    ];

    public $sortable = [
        'pricing_nama',
        'pricing_harga',
        'pricing_berat',
        'pricing_rs',
    ];

    protected $casts = [
        'pricing_harga' => 'integer',
        'pricing_berat' => 'double',
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
            DataBuilder::build($this->field_rs())->name('RS')->show(true)->sort(),
            DataBuilder::build($this->field_name())->name('Name')->show(true)->sort(),
            DataBuilder::build($this->field_berat())->name('Berat')->show(true)->sort(),
            DataBuilder::build($this->field_harga())->name('Harga')->show(true)->sort(),
        ];
    }
}
