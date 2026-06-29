<?php

namespace App\Http\Requests\Major\Quotation;

use Hashids\Hashids;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch($this->option){
            case 'Cancel':
                return [
                    'reason' => 'required'
                ];
            break;
            case 'referral':
                return [
                    'agency_id' => 'required',
                     'province_code' => [
                        Rule::requiredIf(function () {
                            return $this->agency_id == $this->my_agency;
                        }),
                    ],
                ];
            break;
            default: 
                return [];
        }
    }

     public function withValidator($validator)
    {
        if ($this->option === 'Update' || $this->option === 'referral') {
            return;
        }

        if($this->option == 'save'){
            $validator->after(function ($validator) {
                $hashids = new Hashids('krad', 10);
                $id = $hashids->decode($this->reference)[0] ?? null;

                if (!$id) {
                    $validator->errors()->add('code', 'Invalid code provided.');
                    return;
                }
                $this->merge(['id' => $id]);
            });
        }
    }
}
