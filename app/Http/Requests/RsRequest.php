<?php

namespace App\Http\Requests;

use App\Dao\Models\AppRs;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RsRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $merge = [
            AppRs::field_name() => Str::upper($this->{AppRs::field_name()}),
        ];

        $this->merge($merge);
    }

    public function validation(): array
    {
        return [
            AppRs::field_name() => 'required|unique:app_rs,rs_nama',
            AppRs::field_harga() => 'required|integer',
        ];
    }
}
