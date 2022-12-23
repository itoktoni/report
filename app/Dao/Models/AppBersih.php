<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\BersihEntity;
use App\Dao\Entities\SystemPermisionEntity;
use App\Dao\Enums\BooleanType;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\CacheQueryBuilder;
use App\Dao\Traits\DataTableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Plugins\Core;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class AppBersih extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, BersihEntity, ActiveTrait, ActiveTrait, QueryCacheable;

    protected $table = 'app_bersih';
    protected $primaryKey = 'bersih_id';
    protected $cacheFor = 100; // https://blog.renoki.org/cache-eloquent-queries-in-laravel-8

    protected $fillable = [
        'bersih_id',
        'bersih_rs',
        'bersih_lokasi',
        'bersih_transaksi',
        'bersih_tanggal',
        'bersih_jenis_linen',
        'bersih_kode_linen',
        'bersih_nama_linen',
        'bersih_kode_rfid',
        'bersih_kode_upload',
    ];

    public $sortable = [
        'bersih_tanggal',
        'bersih_transaksi',
        'bersih_rs',
        'bersih_lokasi',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = true;

    public function fieldSearching(){
        return $this->field_code();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('ID')->show(false),
            DataBuilder::build($this->field_name())->name('Role'),
        ];
    }
}
