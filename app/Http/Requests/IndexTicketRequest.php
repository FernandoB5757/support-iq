<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|max:255',
            'column_to_order' => [
                'nullable',
                Rule::in([
                    'status',
                    'subject',
                    'created_at',
                    'updated_at',
                ]),
            ],
            'order_by' => [
                'nullable',
                Rule::in([
                    'asc',
                    'desc',
                ]),
            ],
            'paginate' => [
                'nullable',
                Rule::in([10, 15, 25, 35]),
            ],
        ];
    }
}
