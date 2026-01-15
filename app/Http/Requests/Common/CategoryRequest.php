<?php

namespace App\Http\Requests\Common;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if($this->option == 'category'){
            return [
                'name' => [
                    'required',
                    Rule::unique('sample_categories')->where(function ($query) {
                        return $query->where('laboratory_id', $this->laboratory_id)
                            ->where('agency_id', $this->agency_id);
                    }),
                ]
            ];
        }else if($this->option == 'type'){
            return [
                'name' => [
                    'required',
                    Rule::unique('sample_types')->where(function ($query) {
                        return $query->where('category_id', $this->category_id)
                            ->where('agency_id', $this->agency_id);
                    }),
                ]
            ];
        }else if($this->option == 'name'){
            return [
                'name' => [
                    'required',
                    Rule::unique('sample_names')->where(function ($query) {
                        return $query->where('type_id', $this->type_id)
                            ->where('agency_id', $this->agency_id);
                    }),
                ]
            ];
        }
    }
}
