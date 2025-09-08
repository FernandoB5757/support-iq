<?php

namespace App\Models\Enums;

enum TicketStatus: string
{
    case OPEN = 'open';

    case IN_PROGRESS = 'in_progress';

    case CLOSED = 'closed';

    public static function values(): array
    {
        return array_map(
            fn (self $enum) => $enum->value,
            self::cases()
        );
    }
}
