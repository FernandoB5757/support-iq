<?php

namespace App\Actions\Tickets;

use App\DTOs\TicketUpdateRequestData;
use App\Models\Ticket;

class UpdateTicket
{
    public function update(TicketUpdateRequestData $data, Ticket $ticket): Ticket
    {
        $ticket->status = $data->status;

        if (! is_null($data->category_id)) {
            $ticket->category_id = $data->category_id;
        }

        $ticket->save();

        if ($data->note) {
            $note = $data->note->toModel();

            $ticket->notes()->save($note);
        }

        $ticket->load([
            'notes',
            'category',
        ]);

        return $ticket;
    }
}
