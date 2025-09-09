<?php

namespace App\Actions\Tickets;

use App\DTOs\TicketStoreRequestData;
use App\Jobs\ClassifyTicket;
use App\Models\Ticket;
use App\Models\TicketNote;

class CreateTicket
{
    public function create(TicketStoreRequestData $data): Ticket
    {
        $ticket = $data->toModel();

        $ticket->save();

        $ticket->notes()->save(
            TicketNote::noteTicketCreated()
        );

        $ticket->load([
            'notes',
            'category',
        ]);

        ClassifyTicket::dispatch($ticket);

        return $ticket;
    }
}
