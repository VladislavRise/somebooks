<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {   
        // Проверяем на уникальность если это добавление. а не обновление
        if (!$this->route('id')) {
            $rules = [
                'name' => ['required', 'string', 'max:20'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:30', Rule::unique(User::class)->ignore($this->user()->id)]
            ];
        }

        $rules[] = [
            'nickname' => ['string', 'max:20'],
            'full_name' => ['string', 'max:30'],
            'date_birth' => ['date'],
            'biography' => ['string', 'max:1000']
        ];

        return $rules;
    }
}
