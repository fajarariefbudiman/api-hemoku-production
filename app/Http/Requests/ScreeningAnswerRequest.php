<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ScreeningAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            '*.question_id' => 'required|exists:screening_questions,id',
            '*.answer' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            '*.question_id.required' => 'Pertanyaan tidak boleh kosong.',
            '*.question_id.exists' => 'Pertanyaan tidak valid.',
            '*.answer.required' => 'Jawaban wajib diisi.',
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
