<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\TagEntity;
use App\Dao\Entities\ViewLinenEntity;
use App\Dao\Entities\ViewRsEntity;
use App\Dao\Enums\UserType;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class ViewLinen extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, ViewLinenEntity, ActiveTrait, OptionTrait;

    protected $table = 'view_linen';
    protected $primaryKey = 'nama_linen';

    protected $fillable = [
        'nama_linen',
        'nama_rs',
    ];

    public $sortable = [
        'nama_linen',
        'nama_rs',
    ];

    protected $filters = [
        'filter',
    ];

    public $timestamps = false;
    public $incrementing = false;

    public function fieldSearching(){
        return $this->field_name();
    }

    public function fieldDatatable(): array
    {
        return [
            DataBuilder::build($this->field_primary())->name('Nama Linen'),
            DataBuilder::build($this->field_name())->name('Nama RS')->sort(),
        ];
    }
}
