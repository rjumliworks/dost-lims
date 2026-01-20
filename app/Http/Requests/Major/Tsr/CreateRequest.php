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
        return [
            'customer'      => 'sometimes|array',
            'conforme'      => 'sometimes|array',
            'conforme_id'   => 'sometimes|integer',
            'purpose_id'    => 'sometimes|integer',
            'laboratory_id' => 'sometimes|integer',
            'discount_id'   => 'sometimes|integer',
            'due_at'        => 'sometimes|date',
            'is_government' => 'required_if:industry,Government|boolean',
            'is_referral'   => 'sometimes|boolean',
            'agency_id' => Rule::requiredIf($this->is_referral),
            'province_code' => Rule::requiredIf(
                $this->is_referral && $this->agency_id == $this->my_agency
            ),
            'is_onsite' => Rule::requiredIf($this->laboratory_id == 3),
        ];
    }

    public function tsrData(): array
    {
        return [
            'status_id'   => 1,
            'customer_id' => data_get($this->customer, 'value'),
            'conforme_id' => data_get($this->conforme, 'value') ?? $this->conforme_id,
            'facility_id' => $this->facility_id,
            'is_onsite'   => $this->boolean('is_onsite'),
            'created_at'  => $this->created_at
                ? Carbon::parse($this->created_at)->setTime(8, 0)
                : now(),
        ];
    }

    public function isFreePayment(): bool
    {
        return in_array($this->discount_id, [5, 6, 7, 10, 11, 12]);
    }

    public function referralData(): array
    {
        $isPsto = !empty($this->province_code)
            && $this->agency_id == $this->my_agency;

        return [
            'is_psto'       => $isPsto,
            'province_code' => $isPsto ? $this->province_code : null,
            'agency_id'     => $isPsto ? null : $this->agency_id,
        ];
    }
}
