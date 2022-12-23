<?php

namespace App\Dao\Models;

use App\Dao\Builder\DataBuilder;
use App\Dao\Entities\TagEntity;
use App\Dao\Entities\ViewRsEntity;
use App\Dao\Enums\UserType;
use App\Dao\Traits\ActiveTrait;
use App\Dao\Traits\DataTableTrait;
use App\Dao\Traits\OptionTrait;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Mehradsadeghi\FilterQueryString\FilterQueryString as FilterQueryString;
use Touhidurabir\ModelSanitize\Sanitizable as Sanitizable;

class ViewRs extends Model
{
    use Sortable, FilterQueryString, Sanitizable, DataTableTrait, ViewRsEntity, ActiveTrait, OptionTrait;

    protected $table = 'view_rs';
    protected $primaryKey = 'id_rs';

    protected $fillable = [
        'id_rs',
        'nama_rs',
    ];

    public $sortable = [
        'id_rs',
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
            DataBuilder::build($this->field_primary())->name('Tag Code'),
            DataBuilder::build($this->field_name())->name('Tag Name')->sort(),
        ];
    }
}
