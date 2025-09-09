<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $ticket_id
 * @property ?string $owner
 * @property string $content
 *
 * #Relationships
 * @property Ticket $ticket
 */
class TicketNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner',
        'content',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public static function noteTicketCreated(): static
    {
        return TicketNote::make([
            'owner' => 'System',
            'content' => 'Ticket created at '.now()->toFormattedDateString(),
        ]);
    }
}
