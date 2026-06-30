<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
        // lấy giá trị tham số post từ URL hiện tại
        $id = $this->route('post');
        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:200',
            ],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('posts', 'slug')->ignore($id, 'id'),
                'regex:/^[a-z0-9_-]+$/',
            ],
            'content' => 'nullable|string|min:10',
            'status' => 'required|in:0,1',
            'user_id' => 'required|exists:users,id',
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
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số, dấu gạch ngang (-) và dấu gạch dưới (_).',
            'user_id.required' => ':attribute không được để trống.',
            'user_id.exists' => ':attribute không tồn tại.',
            'status.in' => ':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề bài viết',
            'slug' => 'Đường dẫn (Slug)',
            'content' => 'Nội dung bài viết',
            'status' => 'Trạng thái',
            'user_id' => 'Tác giả',
        ];
    }
}
