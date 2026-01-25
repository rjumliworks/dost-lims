<?php

namespace App\Http\Requests\Major\Tsr;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_referral'   => filter_var($this->is_referral, FILTER_VALIDATE_BOOLEAN),
            'is_onsite'     => filter_var($this->is_onsite, FILTER_VALIDATE_BOOLEAN),
            'is_government' => filter_var($this->is_government, FILTER_VALIDATE_BOOLEAN),
        ]);
    }
    
    public function rules(): array
    {
        if($this->option == 'tsr'){
            return [
                'customer'      => 'sometimes|array',
                'conforme'      => 'sometimes|array',
                'conforme_id'   => 'sometimes|integer',
                'purpose_id'    => 'sometimes|integer',
                'laboratory_id' => 'sometimes|integer',
                'discount_id'   => 'sometimes|integer',
                'is_referral'   => 'sometimes|boolean',
                'agency_id' => Rule::requiredIf($this->is_referral),
                'province_code' => Rule::requiredIf(
                    $this->is_referral && $this->agency_id == $this->my_agency
                ),
                'is_onsite' => Rule::requiredIf($this->laboratory_id == 3),
            ];
        }else if($this->option == 'validation'){
            return [
                'customer'      => 'sometimes|array',
                'conforme'      => 'sometimes|array',
                'conforme_id'   => 'sometimes|integer',
                'purpose_id'    => 'sometimes|integer',
                'laboratory_id' => 'sometimes|integer',
                'discount_id'   => 'sometimes|integer',
            ];
        }
    }

    public function tsrData(): array
    {
        return [
            'status_id'   => 1,
            'customer_id' => data_get($this->customer, 'value'),
            'conforme_id' => data_get($this->conforme, 'value') ?? $this->conforme_id,
            'laboratory_id' => $this->laboratory_id,
            'discount_id' => $this->discount_id,
            'purpose_id' => $this->purpose_id,
            'is_onsite'   => $this->boolean('is_onsite'),
            'created_at'  => $this->created_at
                ? Carbon::parse($this->created_at)->setTime(8, 0)
                : now(),
        ];
    }

    public function isFreePayment(): array
    {
        return [
            'is_free' => in_array($this->discount_id, [5, 6, 7, 10, 11, 12]),
            'discount_id' => $this->discount_id
        ];
    }

    public function referralData(): array
    {
        $isPsto = !empty($this->province_code) && $this->agency_id == $this->my_agency;
        return [
            'is_psto'       => $isPsto,
            'province_code' => $isPsto ? $this->province_code : null,
            'agency_id'     => $this->agency_id,
        ];
    }
}
