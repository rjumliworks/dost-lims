<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class CashieringRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if($this->option == 'orseries'){
            return [
                'name' => 'required|string|unique:finance_orseries,name,'.$this->id,
                'start' => 'required|integer',
                'next' => 'required|integer',
                'end' => 'required|integer',
            ];
        }else{
            return [];
        }
    }
}
