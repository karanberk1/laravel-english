<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class QuestionControlRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'questionid' => 'required|numeric',
            'answer' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'questionid.required' => 'soru id gereklidir',
            'questionid.numeric' => 'soru id numeric bir karakter olmalı',
            'answer.required' => 'cevap gereklidir'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            "success" => false,
            "message" => $validator->errors(),

        ], 403));
    }
}
