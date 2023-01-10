<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\AppLinenEntity;
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

class AppLinen extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, AppLinenEntity, ActiveTrait, ActiveTrait, OptionTrait;

    protected $table = 'app_linen';
    protected $primaryKey = 'linen_id';

    protected $fillable = [
        'linen_id',
        'linen_nama',
        'linen_berat',
    ];

    public $sortable = [
        'linen_nama',
        'linen_berat',
    ];

    protected $casts = [
        'linen_berat' => 'double',
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
            DataBuilder::build($this->field_berat())->name('Berat')->show(true)->sort(),
        ];
    }
}
