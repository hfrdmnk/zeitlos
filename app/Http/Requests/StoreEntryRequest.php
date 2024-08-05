<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreEntryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:today', 'unique:entries,date,NULL,id,user_id,' . Auth::id()],
            'story' => ['nullable', 'string', 'max:65535'],
            'mood' => ['nullable', 'integer', 'min:1', 'max:5'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (empty($this->mood) && empty($this->story)) {
                $validator->errors()->add('entry', 'At least one of mood or story must be provided.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'date.before_or_equal' => 'The date must be today or in the past.',
            'date.unique' => 'An entry for this date already exists.',
        ];
    }
}
