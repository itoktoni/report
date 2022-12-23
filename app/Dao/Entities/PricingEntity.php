<?php

namespace App\Dao\Entities;

use App\Dao\Enums\RoleLevel;

trait PricingEntity
{
    public static function field_primary()
    {
        return 'pricing_code';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'pricing_nama';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_harga()
    {
        return 'pricing_harga';
    }

    public function getFieldHargaAttribute()
    {
        return $this->{$this->field_harga()};
    }

    public static function field_berat()
    {
        return 'pricing_berat';
    }

    public function getFieldBeratAttribute()
    {
        return $this->{$this->field_berat()};
    }

    public static function field_rs()
    {
        return 'pricing_rs';
    }

    public function getFieldRsAttribute()
    {
        return $this->{$this->field_rs()};
    }
}
