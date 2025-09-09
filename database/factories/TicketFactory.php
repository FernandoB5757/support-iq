<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\TicketNote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->paragraph(),
            'body' => fake()->paragraph(5),
            'status' => TicketStatus::OPEN,
            'explanation' => fake()->paragraph(),
            'confidence' => fake()->paragraph(),
        ];
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TicketStatus::CLOSED,
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TicketStatus::IN_PROGRESS,
        ]);
    }

    /**
     * Indicate that the user is suspended.
     */
    public function notes(int $count = 1): Factory
    {
        return $this->afterCreating(function (Ticket $record) use ($count) {
            $record->notes()->saveMany(
                TicketNote::factory($count)->withOwner()->make()
            );
        });
    }

    public function category(): Factory
    {
        return $this->afterCreating(function (Ticket $record) {
            $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
            $record->category()->associate($category);
            $record->save();
        });
    }
}
