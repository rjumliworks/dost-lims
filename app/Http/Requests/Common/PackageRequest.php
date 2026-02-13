<?php

namespace App\Http\Requests\Common;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
          return [
                'name' => 'required',
                'sampletype_id' => 'required',
                'laboratory_id' => 'required',
                'lists' => ['required', 'array', 'min:1'],
                'lists.*' => ['required', 'integer'],
            ];
    }
}
