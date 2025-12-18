<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required| email:filter| unique:users,email',
            'password' => 'required|string|confirmed|min:8'
        ];
    }
     public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.min' => 'Tên phải có ít nhất :min ký tự.',
            
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email phải đúng định dạng.',
            'email.unique' => 'Email này đã được đăng ký, vui lòng chọn email khác.', // <-- Thông báo quan trọng
            
            'password.required' => 'Mật khẩu không được để trống.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.'
        ];
    }
}
