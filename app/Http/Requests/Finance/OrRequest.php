<?php

namespace App\Http\Requests\Finance;

use App\Rules\NotZeroPeso;
use App\Rules\NotLessThan;
use Illuminate\Foundation\Http\FormRequest;

class OrRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {   
        // 'details_number' => 'sometimes|required_if:orseries,!=,null|unique:finance_receipts,number,NULL,'.$this->id.',orseries_id,'.$this->orseries_id,
        if($this->option == 'receipt'){
            return [
                'deposit_id' => 'required|integer',
                'orseries' => 'required',
                'details_number' => 'sometimes|nullable',
                'details_date_at' => 'sometimes|required',
                'details_bank' => 'sometimes|required',
                'details_amount' => ['sometimes','required', new NotZeroPeso, new NotLessThan($this->total)],
            ];
        }else{
            return [
                'deposit_id' => 'required|integer',
                'collection_id' => 'required|integer',
                'orseries_id' => 'required|integer',
                'payment_id' => 'required|integer',
                'customer_id' => 'required|integer',
                'items' => 'required|array|min:1',
                'items.*.name' => 'required',
                'items.*.amount' => ['required',new NotZeroPeso],
            ];
        }
    }
}
