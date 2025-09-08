<?php

namespace App\Actions\Tickets;

use App\DTOs\TicketStoreRequestData;
use App\Models\Ticket;

class CreateTicket
{
    public function create(TicketStoreRequestData $data): Ticket
    {
        $ticket = $data->toModel();

        $ticket->save();

        // TODO: add job to assign

        return $ticket;
    }
}
