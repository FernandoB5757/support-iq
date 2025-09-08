<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::factory(2)
            ->notes()
            ->category()
            ->create();

        Ticket::factory(5)
            ->notes()
            ->category()
            ->inProgress()
            ->create();

        Ticket::factory(3)
            ->notes()
            ->category()
            ->closed()
            ->create();
    }
}
