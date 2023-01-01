<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'book_name'     => 'required|string',
            'isbn'  => 'required|string',
            'pages'     => 'required|string',
            'date_published'    => 'required|date',
            'publisher'     => 'required|string',
            'pdf'           => 'required|mimetypes:application/pdf|max:100000'
            // 'author'     => 'required|array',
            // 'lastname'  => 'required|array',
            // 'qualification'     => 'required|array',
        ];
    }
}