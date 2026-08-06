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
                'category_id' => 'sometimes|required',
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
        }else if($this->option == 'create'){
            return [
                'category_id' => 'sometimes|required',
                'sampletype_id' => 'sometimes|required',
                'samplename_id' => 'sometimes|required',
                'name' => 'nullable',
                'customer_description' => 'sometimes|required',
                'description' => 'nullable',
                'tsr_id' => 'sometimes|required',
            ];
        }else if($this->option == 'amendment'){
            return [
                'id' => 'required|exists:tsr_samples,id',
                'description' => 'required',
                'customer_description' => 'required',
                'remarks' => 'required',
            ];
        }else{
            return [];
        }
    }

    public function messages()
    {
        if($this->option == 'create'){
            return [
                'category_id.required' => 'Please select a category',
                'sampletype_id.required' => 'Please select a sample type',
                'samplename_id.required' => 'Please select a sample name',
                'customer_description.required' => 'Please enter the customer description',
                'tsr_id.required' => 'Please select a Technical Service Request (TSR)',
            ];
        }else if($this->option == 'edit'){
            return [
                'category_id.required' => 'Please select a category',
                'sampletype_id.required' => 'Please select a sample type',
                'samplename_id.required' => 'Please select a sample name',
                'customer_description.required' => 'Please enter the customer description',
                'tsr_id.required' => 'Please select a Technical Service Request (TSR)',
            ];
        }else if($this->option == 'amendment'){
            return [
                'description.required' => 'Please enter the proposed description',
                'customer_description.required' => 'Please enter the proposed customer description',
                'remarks.required' => 'Please state the reason for this update request',
            ];
        }else{
            return [];
        }
    }
}
