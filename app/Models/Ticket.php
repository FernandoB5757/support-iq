<?php

namespace App\Models;

use App\Contracts\Prompteable;
use App\Models\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read string $id
 * @property string $subject
 * @property int $category_id
 * @property string $body
 * @property TicketStatus $status
 * @property string $confidence
 * @property string $explanation
 *
 * #Relationships
 * @property Category $category
 * @property \Illuminate\Database\Eloquent\Collection<int,TicketNote> $notes
 */
class Ticket extends Model implements Prompteable
{
    use HasFactory,HasUlids,SoftDeletes;

    protected $fillable = [
        'subject',
        'body',
        'status',
        'explanation',
        'confidence',
    ];

    protected $attributes = [
        'status' => TicketStatus::OPEN->value,
        'confidence' => '',
        'explanation' => '',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => TicketStatus::class,
        ];
    }

    public function notes(): HasMany
    {
        return $this->hasMany(TicketNote::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getPrompt(): string
    {
        return 'Subject '.$this->subject.', Body: '.$this->body;
    }
}
