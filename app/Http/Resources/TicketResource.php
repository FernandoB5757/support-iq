<?php

namespace App\Http\Resources;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var Ticket
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->resource->makeHidden('deleted_at');

        if ($request->is('tickets.index')) {
            return parent::toArray($request);
        }

        return array_merge(
            parent::toArray($request),
            [
                'category' => new CategoryResource($this->whenLoaded('category')),
                'notes' => TicketNoteResource::collection($this->whenLoaded('notes')),
            ]
        );
    }
}
