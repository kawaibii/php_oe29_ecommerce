<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:products,name',
            'original_price' => 'numeric|required',
            'current_price' => 'numeric|required',
            'category' => 'required',
            'brand' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'description' => 'required',
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->all()){
                $validator->errors()->add('show_modal', $this->input('define'));
                $validator->errors()->add('route', $this->route('product'));
            }
        });
    }
}