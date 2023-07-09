<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => 'required|max:100',
            'category_id' => 'required',
            'price' => 'required|max:18',
            'image' => 'image|mimes:jpg,png,gif,bmp|max:500',
            'ip_address' => 'max:15',
            'otherImage' => 'max:500',
            'model' => 'max:130',
        ];
    }
}
