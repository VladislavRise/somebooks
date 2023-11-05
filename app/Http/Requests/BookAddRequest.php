<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  auth()->check() ? true : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:50'],
            'description' => ['required', 'string', 'max:1000'],
            'genre' => ['required', 'array'],
            'type' => ['required', 'string', 'max:20'],
            'publish_date' => ['required', 'date']
        ];

        // Проверяем на уникальность если это добавление, а не обновление
        if (!$this->route('id')) {
            $rules['name'][] = 'unique:books';
        }

        return $rules;
    }
}
