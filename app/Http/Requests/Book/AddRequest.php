<?php

namespace App\Http\Requests\Book;

use App\Rules\NotNullRule;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // If the middleware (auth:api) is not present, it can be found here auth()->check()
        return auth()->user()->hasRole('admin');
    }

    public function failedAuthorization()
    {
        throw new AuthorizationException('ليس لديك صلاحية إضافة كتاب',402);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:books,title', new NotNullRule()],
            'author_id' => ['required', 'integer', 'exists:users,id'],
            'description' => ['required', 'string'],
            'published_at' => ['required', 'date']
        ];
    }


    public function attributes()
    {
        return [
            'title' => 'عنوان الكتاب',
            'author_id' => 'المؤلف',
            'description' => 'وصف الكتاب',
            'published_at' => 'تاريخ النشر'
        ];
    }

    public function messages()
    {
        return [
            'required' => ":attribute مطلوب إدخاله",
            'unique' => ":attribute موجود مسبقاً",
            'exists'=>":attribute غير موجود",
            'string' => ":attribute يجب أن تكون سلسلة نصية",
            'integer' => ":attribute يجب أن يكون عدد صحيح",
            'date' => ":attribute يجب أن يكون تاريخ"
        ];
    }
}