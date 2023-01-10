<?php

namespace App\Dao\Entities;

use App\Dao\Enums\RoleLevel;

trait AppRsEntity
{
    public static function field_primary()
    {
        return 'rs_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'rs_nama';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_harga()
    {
        return 'rs_harga';
    }

    public function getFieldHargaAttribute()
    {
        return $this->{$this->field_harga()};
    }
}
