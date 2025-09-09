<?php

namespace App\DTOs;

use App\Models\TicketNote;
use Illuminate\Support\Arr;

readonly class TicketNoteData
{
    public function __construct(
        public ?string $owner,
        public string $content,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            owner: Arr::get($data, 'owner'),
            content: Arr::get($data, 'content')
        );
    }

    public function toModel(): TicketNote
    {
        return TicketNote::make([
            'owner' => $this->owner,
            'content' => $this->content,
        ]);
    }
}
