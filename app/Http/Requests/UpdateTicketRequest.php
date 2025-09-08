<?php

namespace App\Http\Requests;

use App\Models\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
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
            'status' => [
                'required',
                Rule::enum(TicketStatus::class),
            ],

            'category_id' => [
                'nullable', 'exists:categories,id',
            ],

            'category_id' => [
                'nullable', 'exists:categories,id',
            ],

            'note' => 'array|nullable',

            'note.content' => 'nullable|string|max:255',

            'note.owner' => 'nullable|string|max:255',
        ];
    }
}
