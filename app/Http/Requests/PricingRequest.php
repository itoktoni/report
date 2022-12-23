<?php

namespace App\Http\Requests;

use App\Dao\Models\Pricing;
use App\Dao\Traits\ValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PricingRequest extends FormRequest
{
    use ValidationTrait;

    public function prepareForValidation()
    {
        $merge = [
            Pricing::field_primary() => $this->{Pricing::field_rs()}.'-'.$this->{Pricing::field_name()},
        ];

        $this->merge($merge);
    }

    public function validation(): array
    {
        return [
            Pricing::field_primary() => 'required|unique:pricing,pricing_code',
            Pricing::field_name() => 'required',
            Pricing::field_rs() => 'required',
            Pricing::field_harga() => 'required|integer',
            Pricing::field_berat() => 'required|numeric',
        ];
    }
}
