<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return $rule=[
            'section_name'=>'required|max:100|unique:sections,section_name',
            'description'=>'required',
        ];
    }
    public function messages(){
        return [
            'section_name.required'=>'اسم العرض مطلوب',
            'section_name.unique'=>'اسم العرض موجود',
            'description.required'=>' المواصفات مطلوبة'
        ];
    }
}
