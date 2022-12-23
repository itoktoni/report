<?php

namespace App\Dao\Entities;

trait ViewMutasiEntity
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

    public function getFieldRsAttribute()
    {
        return $this->{$this->field_rs()};
    }

    public static function field_lokasi()
    {
        return 'nama_lokasi';
    }

    public function getFieldLokasiAttribute()
    {
        return $this->{$this->field_lokasi()};
    }

    public static function field_tanggal()
    {
        return 'tanggal';
    }

    public function getFieldTanggalAttribute()
    {
        return $this->{$this->field_tanggal()};
    }

    public static function field_stock_bersih()
    {
        return 'stock_bersih';
    }

    public function getFieldStockBersihAttribute()
    {
        return $this->{$this->field_stock_bersih()};
    }

    public static function field_stock_kotor()
    {
        return 'stock_kotor';
    }

    public function getFieldStockKotorAttribute()
    {
        return $this->{$this->field_stock_kotor()};
    }

    public static function field_selisih()
    {
        return 'selisih';
    }

    public function getFieldSelisihAttribute()
    {
        return $this->{$this->field_selisih()};
    }

    public static function field_reported_at()
    {
        return 'tanggal';
    }

    public function getFieldReportedAtAttribute()
    {
        return $this->{$this->field_reported_at()};
    }
}
