<?php

namespace App\Actions\Tickets;

use App\DTOs\TicketIndexRequestData;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GetListTickets
{
    public function get(TicketIndexRequestData $data): AnonymousResourceCollection
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

        return TicketResource::collection($query->paginate($data->paginate));
    }
}
