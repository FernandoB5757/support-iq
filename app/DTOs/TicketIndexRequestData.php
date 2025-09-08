<?php

namespace App\DTOs;

use Illuminate\Support\Arr;

readonly class TicketIndexRequestData
{
    public function __construct(
        public ?string $search = null,
        public ?string $columnToOrder = null,
        public ?string $orderBy = null,
        public int $paginate = 10
    ) {}

    public static function fromRequest(array $data): static
    {
        return new static(
            search: Arr::get($data, 'search'),
            columnToOrder: Arr::get($data, 'column_to_order'),
            orderBy: Arr::get($data, 'order_by', 'desc'),
            paginate: Arr::get($data, 'paginate', 10)
        );
    }
}
