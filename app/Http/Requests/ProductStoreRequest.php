<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'brand_id' => 'required',
            'price' => 'required|max:10|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'required|image|mimes:jpg,png,gif,bmp|max:500',
            'otherImage' => 'max:500',
            'purchage' => 'required|min:1|max:10',
            'features' => 'required',
            'model' => 'required|max:130',
        ];
    }
}
