<?php

namespace App\Http\Requests;

use App\Dao\Models\AppPricing;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PricingRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $merge = [
            AppPricing::field_primary() => $this->{AppPricing::field_rs()}.'-'.$this->{AppPricing::field_name()},
        ];

        $this->merge($merge);
    }

    public function validation(): array
    {
        return [
            AppPricing::field_primary() => 'required|unique:pricing,pricing_code',
            AppPricing::field_name() => 'required',
            AppPricing::field_rs() => 'required',
            AppPricing::field_harga() => 'required|integer',
            AppPricing::field_berat() => 'required|numeric',
        ];
    }
}
