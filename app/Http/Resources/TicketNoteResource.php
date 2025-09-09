<?php

namespace App\Http\Resources;

use App\Models\TicketNote;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketNoteResource extends JsonResource
{
    /**
     * The resource instance.
     *
     * @var TicketNote
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
