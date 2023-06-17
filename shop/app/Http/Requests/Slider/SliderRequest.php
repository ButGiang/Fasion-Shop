<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required',
            'thumb' => 'required'
        ];
    }

    public function messages():array {
        return [
            'name.required' => 'Vui lòng nhập tên cho slider',
            'thumb.required' => 'Vui lòng thêm hình ảnh cho slider'
        ];
    }
}
