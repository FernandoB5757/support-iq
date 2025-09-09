<?php

namespace App\DTOs;

use App\Models\Enums\TicketStatus;
use Illuminate\Support\Arr;

readonly class TicketUpdateRequestData
{
    public function __construct(
        public TicketStatus $status,
        public ?int $category_id,
        public ?TicketNoteData $note
    ) {}

    public static function fromRequest(array $data): static
    {
        return new static(
            status : TicketStatus::from(Arr::get($data, 'status')),
            category_id : Arr::get($data, 'category_id'),
            note : is_string(Arr::get($data, 'note.content')) ? TicketNoteData::fromArray(
                Arr::get($data, 'note', [])
            ) : null
        );
    }
}
