<?php

namespace App\Http\Requests\BorrowRecords;

use App\Services\BookServices;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasRole('user');
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('ليس لديك صلاحية استعارة كتاب', 402);
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
            'borrowed_at' => ['required', 'date'],
        ];
    }

    public function attributes()
    {
        return [
            'book_id' => 'الكتاب',
            'borrowed_at' => 'تاريخ الاستعارة'
        ];
    }

    public function messages()
    {
        return [
            'required' => ":attribute مطلوب إدخاله",
            'exists' => ":attribute غير موجود",
            'integer' => ":attribute يجب أن يكون عدد صحيح",
            'date' => ":attribute يجب أن يكون تاريخ"
        ];
    }

    public function passedValidation()
    {
        (new BookServices())->availableBook($this);
        $this->merge([
            'user_id' => auth()->user()->id,
            'returned_at' => Carbon::make($this->borrowed_at)->addDays(14)
        ]);
    }
}
