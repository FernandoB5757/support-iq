<?php

namespace App\DTOs;

use App\Models\Ticket;
use Illuminate\Support\Arr;

readonly class TicketStoreRequestData
{
    public function __construct(
        public string $subject,
        public string $body,
        public string $explanation,
        public ?float $confidence = null,
        public ?int $category_id = null
    ) {}

    public static function fromRequest(array $data): static
    {
        return new static(
            subject: Arr::get($data, 'subject'),
            body: Arr::get($data, 'body'),
            explanation : Arr::get($data, 'explanation', ''),
            confidence : Arr::get($data, 'confidence'),
            category_id: Arr::get($data, 'category_id')
        );
    }

    public function toModel(): Ticket
    {
        return Ticket::make([
            'subject' => $this->subject,
            'category_id' => $this->category_id,
            'body' => $this->body,
            'explanation' => $this->explanation,
            'confidence' => $this->confidence,
        ]);
    }
}
