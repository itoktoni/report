<?php

namespace App\Dao\Entities;

trait KotorEntity
{
    public static function field_primary()
    {
        return 'kotor_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'kotor_nama_linen';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_rs()
    {
        return 'kotor_rs';
    }

    public function getFieldRsAttribute()
    {
        return $this->{$this->field_rs()};
    }

    public static function field_lokasi()
    {
        return 'kotor_lokasi';
    }

    public function getFieldLokasiAttribute()
    {
        return $this->{$this->field_lokasi()};
    }

    public static function field_tanggal_bersih()
    {
        return 'kotor_tanggal_bersih';
    }

    public function getFieldTanggalBersihAttribute()
    {
        return $this->{$this->field_tanggal_bersih()};
    }

    public static function field_tanggal_kotor()
    {
        return 'kotor_tanggal_kotor';
    }

    public function getFieldTanggalKotorAttribute()
    {
        return $this->{$this->field_tanggal_kotor()};
    }

    public static function field_upload()
    {
        return 'kotor_kode_upload';
    }

    public function getFieldUploadAttribute()
    {
        return $this->{$this->field_upload()};
    }

    public static function field_stock()
    {
        return 'kotor_stock';
    }

    public function getFieldKotorAttribute()
    {
        return $this->{$this->field_stock()};
    }
}
