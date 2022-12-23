<?php

namespace App\Dao\Entities;

use App\Dao\Models\User;

trait AppUploadEntity
{
    public static function field_primary()
    {
        return 'upload_id';
    }

    public function getFieldPrimaryAttribute()
    {
        return $this->{$this->field_primary()};
    }

    public static function field_name()
    {
        return 'upload_kode';
    }

    public function getFieldNameAttribute()
    {
        return $this->{$this->field_name()};
    }

    public static function field_rs()
    {
        return 'upload_rs';
    }

    public function getFieldRsAttribute()
    {
        return $this->{$this->field_rs()};
    }

    public static function field_tanggal()
    {
        return 'upload_tanggal';
    }

    public function getFieldTanggalAttribute()
    {
        return $this->{$this->field_tanggal()};
    }

    public static function field_user()
    {
        return 'upload_created_by';
    }

    public function getFieldUserAttribute()
    {
        return $this->{User::field_name()};
    }
}
