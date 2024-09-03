<?php

namespace App\Http\Requests\Rate;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'rating' => ['numeric', 'between:1,5'],
            'review' => ['string']
        ];
    }

    public function attributes()
    {
        return [
            'rating' => "التقيم",
            'review' => "المراجعة"
        ];
    }

    public function messages()
    {
        return [
            'string' => ":attribute يجب أن تكون سلسلة نصية",
            'between' => ":attribute يجب أن تكون بين القيمتين 1 و 5",
            'numeric' => ":attribute يجب أن تكون رقم"
        ];
    }
}
