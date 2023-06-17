<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest {
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
            'name.required' => 'Vui lòng nhập tên cho sản phẩm',
            'thumb.required' => 'Vui lòng thêm hình ảnh cho sản phẩm'
        ];
    }
}
