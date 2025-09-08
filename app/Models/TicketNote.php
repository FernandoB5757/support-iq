<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $ticket_id
 * @property ?string $subject
 * @property string $content
 *
 * #Relationships
 * @property Ticket $ticket
 */
class TicketNote extends Model
{
    use HasFactory;

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
