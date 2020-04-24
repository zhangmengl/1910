<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandPost extends FormRequest
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
            'brand_name' => 'required|unique:brand|max:20',
            'brand_url' => 'required',
            'brand_desc' => 'required',
        ];
    }
    public function messages(){
        return [
        'brand_name.required' => '品牌名称必填！',
        'brand_name.unique' => '品牌名称已存在！',
        'brand_name.max' => '品牌长度不超过20位！',
        'brand_url.required' => '品牌网址必填！',
        'brand_desc.required' => '品牌描述必填！',
        ];
        }
}
