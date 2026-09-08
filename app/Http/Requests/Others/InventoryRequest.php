<?php

namespace App\Http\Requests\Others;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if($this->option == 'supplier'){
            return [
                'name' => 'required|string',
                'email' => 'required|email|max:150',
                'contact_no' => 'required|numeric|digits:11',
                'address' => 'required|string|max:200',
                'region_code' => 'required',
                'province_code' => 'required',
                'municipality_code' => 'required',
                'barangay_code' => 'nullable',
            ];
        }else if($this->option == 'item'){
            return [
                'name' => 'sometimes|required|string|unique:inventory_items,name,NULL,'.$this->id.',laboratory_id,'.$this->laboratory_id,
                'category_id' => 'sometimes|required',
                'laboratory_type' => 'sometimes|required',
                'reorder' => [
                    function ($attribute, $value, $fail) {
                        if ((is_null($this->reorder) || is_null($this->unit_id))) {
                            $fail('Both size and unit fields are required.');
                        }
                    },
                ],
            ];
        }else if($this->option == 'stock'){
            return [
                'item_id' => 'required',
                'brand' => 'required',
                'number' => 'required',
                'quantity' => 'required|integer',
                'price' => 'required',
                'supplier_id' => 'required',
                'expired_at' => 'nullable',
                'cas_number' => 'required_if:laboratory_id,1',
                'bought_at' => 'required',
                'unit' => [
                    function ($attribute, $value, $fail) {
                        if ((is_null($this->unit) || is_null($this->unit_id))) {
                            $fail('Both size and unit fields are required.');
                        }
                    },
                ],
            ];
        }else if($this->option == 'checkout'){
            return [
                'items' => 'required|array|min:1',
                'items.*.id' => 'required|integer|exists:inventory_stocks,id',
                'items.*.quantity' => 'required|integer|min:1',
            ];
        }
        return [];
    }
}
