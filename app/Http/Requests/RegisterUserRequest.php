<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Terjadi kesalahan pada data yang Anda kirimkan. Mohon periksa kembali.',
            'errors' => $validator->errors()
        ], 422));
    }

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
            'fullname' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'birth_date' => 'required|date',
            'password' => 'required|string|min:8|confirmed',

            'email' => [
                'nullable',
                'email',
                Rule::requiredIf(function () {
                    return !$this->filled('phone_number');
                }),
                'unique:users,email',
            ],

            'phone_number' => [
                'nullable',
                Rule::requiredIf(function () {
                    return !$this->filled('email');
                }),
                'regex:/^(\+62|62|08)\s?[0-9]{8,12}$/',
            ],
        ];
    }


    public function messages()
    {
        return [
            'fullname.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi jika nomor HP tidak diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'phone_number.required' => 'Nomor HP wajib diisi jika email tidak diisi.',
            'phone_number.regex' => 'Format nomor HP harus nomor Indonesia yang valid (misalnya +62812xxxxxxx atau 62812xxxxxxx).',
        ];
    }
}
