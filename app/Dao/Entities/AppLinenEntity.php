<?php

namespace App\Dao\Entities;

use App\Dao\Enums\RoleLevel;

trait AppLinenEntity
{
    public static function field_primary()
    {
        return 'linen_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'linen_nama';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_berat()
    {
        return 'linen_berat';
    }

    public function getFieldBeratAttribute()
    {
        return $this->{$this->field_berat()};
    }
}
