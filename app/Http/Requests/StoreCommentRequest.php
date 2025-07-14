<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // atau tambahkan logic otorisasi jika diperlukan
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Form wajib diisi.',
            'content.max' => 'Komentar tidak boleh lebih dari 1000 karakter.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Terjadi kesalahan pada data yang Anda kirimkan. Mohon periksa kembali.',
            'errors' => $validator->errors()
        ], 422));
    }
}
