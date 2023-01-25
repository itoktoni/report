<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\AppUploadEntity;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;
use Rennokki\QueryCache\Traits\QueryCacheable;
use Wildside\Userstamps\Userstamps;

class AppUpload extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, AppUploadEntity, ActiveTrait, PowerJoins, Userstamps, QueryCacheable, OptionTrait;

    protected $table = 'app_upload';
    protected $primaryKey = 'upload_id';
    protected $cacheFor = 10; // https://blog.renoki.org/cache-eloquent-queries-in-laravel-8

    protected $fillable = [
        'upload_id',
        'upload_created_at',
        'upload_created_by',
        'upload_updated_at',
        'upload_updated_by',
        'upload_tanggal',
        'upload_kode',
        'upload_rs',
    ];

    public $sortable = [
        'upload_kode',
        'upload_rs',
        'upload_date',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = true;
    public $incrementing = true;

    protected $casts = [
        'upload_created_by' => 'integer',
    ];

    const CREATED_AT = 'upload_created_at';
    const UPDATED_AT = 'upload_updated_at';
    const DELETED_AT = 'upload_deleted_at';

    const CREATED_BY = 'upload_created_by';
    const UPDATED_BY = 'upload_updated_by';
    const DELETED_BY = 'upload_deleted_by';

    public function fieldSearching(){
        return $this->field_code();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('ID'),
            DataBuilder::build($this->field_name())->name('Kode Upload'),
            DataBuilder::build($this->field_rs())->name('Rumah Sakit'),
            DataBuilder::build($this->field_tanggal())->name('Tanggal'),
            DataBuilder::build(User::field_name())->name('Diupload Oleh'),
        ];
    }

    public function has_bersih()
    {
        return $this->hasMany(appberAppBersih::class, AppBersih::field_upload(), self::field_primary());
    }

    public function has_kotor()
    {
        return $this->hasMany(AppKotor::class, AppKotor::field_upload(), self::field_primary());
    }

    public function has_user()
    {
        return $this->hasOne(User::class, User::field_primary(), self::field_user());
    }

    public static function boot()
    {
        parent::deleting(function ($model) {
            AppBersih::where(AppBersih::field_name(), $model->field_name)->delete();
            AppKotor::where(AppKotor::field_name(), $model->field_name)->delete();
        });

        parent::boot();
    }
}
