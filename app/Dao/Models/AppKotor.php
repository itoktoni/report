<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\BersihEntity;
use App\Dao\Entities\KotorEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Rennokki\QueryCache\Traits\QueryCacheable;

class AppKotor extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, KotorEntity, ActiveTrait, ActiveTrait, QueryCacheable;

    protected $table = 'app_kotor';
    protected $primaryKey = 'kotor_id';
    protected $cacheFor = 100; // https://blog.renoki.org/cache-eloquent-queries-in-laravel-8

    protected $fillable = [
        'kotor_id',
        'kotor_rs',
        'kotor_lokasi',
        'kotor_nama_linen',
        'kotor_kode_upload',
        'kotor_tanggal_kotor',
        'kotor_tanggal_bersih',
        'kotor_stock',
    ];

    public $sortable = [
        'kotor_rs',
        'kotor_lokasi',
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
