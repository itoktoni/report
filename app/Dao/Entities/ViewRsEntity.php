<?php

namespace App\Dao\Entities;

trait ViewRsEntity
{
    public static function field_primary()
    {
        return 'id_rs';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'nama_rs';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }
}
