<?php

namespace App\Dao\Entities;

trait ViewLinenEntity
{
    public static function field_primary()
    {
        return 'nama_linen';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'nama_linen';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_rs()
    {
        return 'nama_rs';
    }

    public function getFieldNameRsAttribute()
    {
        return $this->{$this->field_rs()};
    }
}
