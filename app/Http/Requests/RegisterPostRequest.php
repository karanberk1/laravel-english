<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterPostRequest extends FormRequest
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
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'passwordConfirm' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'email alanı yanlızca email türünden değer alır',
            'username.required' => 'username alanı boş bırakılamaz',
            'email.required' => 'email alanı boş bırakılamaz',
            'password.required' => 'password alanı boş bırakılamaz',
            'passwordConfirm.required' => 'passwordConfirm alanı boş bırakılamaz',
            'password.min' => 'password alanı en az 8 karakter olmalı',
            'passwordConfirm.min' => 'passwordConfirm alanı en az 8 karakter olmalı'
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
