<?php

namespace App\Http\Controllers;

use App\Actions\Tickets\CreateTicket;
use App\Actions\Tickets\GetListTickets;
use App\Actions\Tickets\UpdateTicket;
use App\DTOs\TicketIndexRequestData;
use App\DTOs\TicketStoreRequestData;
use App\DTOs\TicketUpdateRequestData;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Jobs\ClassifyTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make([
            'search' => $request->query('serch'),
            'column_to_order' => $request->query('column_to_order'),
            'order_by' => $request->query('order_by'),
            'paginate' => $request->query('paginate'),
        ],
            [
                'search' => 'nullable|max:255',
                'column_to_order' => [
                    'nullable',
                    Rule::in([
                        'status',
                        'subject',
                        'created_at',
                        'updated_at',
                    ]),
                ],
                'order_by' => [
                    'nullable',
                    Rule::in([
                        'asc',
                        'desc',
                    ]),
                ],
                'paginate' => [
                    'nullable',
                    Rule::in([10, 15, 25, 35]),
                ],
            ]);

        $validator->validate();

        return (new GetListTickets)->get(
            TicketIndexRequestData::fromRequest($validator->getData())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $data = TicketStoreRequestData::fromRequest($request->validated());

        return new TicketResource(
            (new CreateTicket)->create($data)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket->load([
            'category',
            'notes',
        ]);

        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        return (new UpdateTicket)->update(
            TicketUpdateRequestData::fromRequest(
                $request->validated()
            ),
            $ticket
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function classify(Ticket $ticket)
    {
        ClassifyTicket::dispatch($ticket);

        return response()
            ->json([
                'message' => 'Classification process started in the background',
                'status' => 200,
            ]);
    }
}
