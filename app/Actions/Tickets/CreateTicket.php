<?php

namespace App\Actions\Tickets;

use App\DTOs\TicketStoreRequestData;
use App\Models\Ticket;
use App\Models\TicketNote;
use OpenAI\Laravel\Facades\OpenAI;

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

        // TODO: add job to assign

        OpenAI::responses()->create([
            'model' => 'gpt-5',
            'input' => 'Hello!',
        ]);

        return $ticket;
    }
}
