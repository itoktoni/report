<?php

namespace App\Dao\Entities;

trait BersihEntity
{
    public static function field_primary()
    {
        return 'bersih_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'bersih_nama_linen';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_rs()
    {
        return 'bersih_rs';
    }

    public function getFieldRsAttribute()
    {
        return $this->{$this->field_rs()};
    }

    public static function field_lokasi()
    {
        return 'bersih_lokasi';
    }

    public function getFieldLokasiAttribute()
    {
        return $this->{$this->field_lokasi()};
    }

    public static function field_transaksi()
    {
        return 'bersih_transaksi';
    }

    public function getFieldTransaksiAttribute()
    {
        return $this->{$this->field_transaksi()};
    }

    public static function field_tanggal()
    {
        return 'bersih_tanggal';
    }

    public function getFieldTanggalAttribute()
    {
        return $this->{$this->field_tanggal()};
    }

    public static function field_jenis_linen()
    {
        return 'bersih_jenis_linen';
    }

    public function getFieldJenisLinenAttribute()
    {
        return $this->{$this->field_jenis_linen()};
    }

    public static function field_kode_linen()
    {
        return 'bersih_kode_linen';
    }

    public function getFieldKodeLinenAttribute()
    {
        return $this->{$this->field_kode_linen()};
    }

    public static function field_rfid()
    {
        return 'bersih_kode_rfid';
    }

    public function getFieldRfidAttribute()
    {
        return $this->{$this->field_rfid()};
    }

    public static function field_upload()
    {
        return 'bersih_kode_upload';
    }

    public function getFieldUploadAttribute()
    {
        return $this->{$this->field_upload()};
    }
}
