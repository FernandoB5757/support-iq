<?php

namespace App\Actions\Tickets;

use App\DTOs\TicketIndexRequestData;
use App\Http\Resources\TicketCollection;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;

class GetListTickets
{
    public function get(TicketIndexRequestData $data): TicketCollection
    {
        $query = Ticket::query();

        if ($data->search) {
            $query->where(
                function (Builder $subQuery) use ($data) {
                    $subQuery->where('subject', 'like', "%{$data->search}%")
                        ->orWhere('body', 'like', "%{$data->search}%");
                });
        }

        if ($data->columnToOrder && $data->orderBy) {
            $query->orderBy($data->columnToOrder, $data->orderBy);
        } else {
            $query->latest();
        }

        return new TicketCollection(
            $query->paginate($data->paginate)
        );
    }
}
