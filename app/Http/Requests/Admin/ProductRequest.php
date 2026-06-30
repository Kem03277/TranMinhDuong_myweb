<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // lấy giá trị tham số product từ URL hiện tại
        $id = $this->route('product');
        return [
            'productname' => [
                'required',
                'string',
                'min:5',
                'max:150',
                Rule::unique('products', 'productname')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:200',
                Rule::unique('products', 'slug')->ignore($id, 'id'),
                'regex:/^[a-z0-9_-]+$/',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'lte:9999999',
            ],
            'pricediscount' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],
            'status' => 'required|in:0,1',
            'cateid' => 'required|exists:categories,cateid',
            'brandid' => 'nullable|exists:brands,id',
            'description' => 'nullable|regex:/^[^@!$^]*$/',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'numeric' => ':attribute phải là số.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số, dấu gạch ngang (-) và dấu gạch dưới (_).',
            'price.min' => ':attribute phải lớn hơn hoặc bằng 0.',
            'price.max' => ':attribute phải nhỏ hơn 10.000.000.',
            'pricediscount.numeric' => ':attribute phải là số.',
            'pricediscount.min' => ':attribute phải lớn hơn hoặc bằng 0.',
            'pricediscount.lte' => ':attribute không được lớn hơn giá bán.',
            'status.in' => ':attribute không hợp lệ.',
            'cateid.required' => ':attribute không được để trống.',
            'cateid.exists' => ':attribute không tồn tại.',
            'brandid.exists' => ':attribute không tồn tại.',
            'description.regex' => ':attribute không được chứa các ký tự đặc biệt (@, !, $, ^).',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Đường dẫn (Slug)',
            'price' => 'Giá bán',
            'pricediscount' => 'Giá giảm',
            'status' => 'Trạng thái',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'description' => 'Mô tả sản phẩm',
        ];
    }
}
