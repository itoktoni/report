<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\TagEntity;
use App\Dao\Entities\ViewMutasiEntity;
use App\Dao\Entities\ViewRsEntity;
use App\Dao\Enums\UserType;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class ViewMutasi extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, ViewMutasiEntity, ActiveTrait, OptionTrait, QueryCacheable;

    protected $table = 'view_mutasi';
    protected $primaryKey = 'nama_linen';
    // protected $cacheFor = 10;

    protected $fillable = [
        'nama_rs',
        'nama_lokasi',
        'nama_linen',
        'nama_tangan_bersih',
        'nama_tangan_kotor',
        'bersih_stock',
        'kotor_stock',
        'selisih',
    ];

    public $sortable = [
        'nama_rs',
    ];

    protected $filters = [
        'filter',
        'nama_rs',
        'start_date',
        'end_date',
    ];

    public $timestamps = false;
    public $incrementing = false;

    public function fieldSearching(){
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('Tag Code'),
            DataBuilder::build($this->field_name())->name('Tag Name')->sort(),
        ];
    }
}
