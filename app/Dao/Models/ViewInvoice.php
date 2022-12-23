<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\TagEntity;
use App\Dao\Entities\ViewInvoiceEntity;
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

class ViewInvoice extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, ViewInvoiceEntity, ActiveTrait, OptionTrait, QueryCacheable;

    protected $table = 'view_invoice';
    protected $primaryKey = 'inv_nama_linen';
    // protected $cacheFor = 10;

    public $sortable = [
        'inv_nama_rs',
        'inv_nama_linen',
        'inv_tanggal',
    ];

    protected $filters = [
        'filter',
        'start_date',
        'end_date',
        'inv_nama_rs',
        'inv_nama_linen',
        'inv_tanggal',
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
