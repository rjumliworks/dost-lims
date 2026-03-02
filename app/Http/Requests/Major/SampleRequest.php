<?php

namespace App\Http\Requests\Major;

use Illuminate\Foundation\Http\FormRequest;

class SampleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if($this->option == 'edit'){
            return [
                'sampletype_id' => 'sometimes|required',
                'samplename_id' => 'sometimes|required',
                'name' => 'nullable',
                'customer_description' => 'sometimes|required',
                'description' => 'nullable',
                'tsr_id' => 'sometimes|required',
            ];
        }else if($this->option == 'copy'){
            return [
                'include_testservices' => 'required',
                 'count' => 'required|integer|min:1',
            ];
        }else{
            return [];
        }
    }
}
