<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 *
 * #Relationships
 * @property \Illuminate\Database\Eloquent\Collection<int,Ticket> $tickets
 */
class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        $defineSlug = function (Category $record) {
            $record->slug = Str::slug($record->name);
        };

        static::creating($defineSlug);
        static::updating($defineSlug);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
