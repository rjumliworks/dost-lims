<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class RequestActionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $table = $this->type === 'due_date' ? 'tsr_amendments' : 'tsr_sample_amendments';

        if($this->option == 'approve'){
            return [
                'id' => 'required|exists:'.$table.',id',
            ];
        }else if($this->option == 'reject'){
            return [
                'id' => 'required|exists:'.$table.',id',
                'remarks' => 'required',
            ];
        }else{
            return [];
        }
    }

    public function messages()
    {
        return [
            'remarks.required' => 'Please state the reason for rejecting this request.',
        ];
    }
}
