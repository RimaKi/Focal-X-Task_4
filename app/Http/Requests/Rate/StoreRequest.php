<?php

namespace App\Http\Requests\Rate;

use App\Models\Borrow_record;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'rating' => ['required', 'numeric', 'between:1,5'],
            'review' => ['string']
        ];
    }

    public function attributes()
    {
        return [
            'book_id' => "الكتاب",
            'rating' => "التقيم",
            'review' => "المراجعة"
        ];
    }

    public function messages()
    {
        return [
            'required' => ":attribute مطلوب إدخاله",
            'exists' => ":attribute غير موجود",
            'string' => ":attribute يجب أن تكون سلسلة نصية",
            'integer' => ":attribute يجب أن يكون عدد صحيح",
            'between' => ":attribute يجب أن تكون بين القيمتين 1 و 5",
            'numeric' => ":attribute يجب أن تكون رقم"
        ];
    }
    public function passedValidation()
    {
        $data = auth()->user()->Borrow_records()->where('book_id', $this->book_id)->first();
        if ($data == null) {
            throw new AuthorizationException('لا يمكنك تقيم هذا الكتاب لأنك لم تقم باستعارته من قبل', 402);
        }

        $this->merge([
            'user_id' => auth()->user()->id,
        ]);
    }
}
