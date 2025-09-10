<?php

use App\Models\Enums\TicketStatus;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can list tickets', function () {
    Ticket::factory(3)
        ->create();

    $response = $this->getJson('/api/tickets');

    $response->assertOk()
        ->assertJsonCount(3, 'data');
});

test('can paginate tickets', function () {
    Ticket::factory(20)
        ->create();

    $response = $this->getJson('/api/tickets?paginate=15');

    $response->assertOk()
        ->assertJsonCount(15, 'data')
        ->assertJson(fn (AssertableJson $json) => $json->has('data')
            ->has('links')
            ->has('meta')
        );
});

test('can validate parameters', function () {
    Ticket::factory(10)
        ->create();

    $response = $this->getJson('/api/tickets?column_to_order=id');

    $response->assertStatus(422)
        ->assertJson(fn (AssertableJson $json) => $json->has('message')
            ->has('errors')
        );
});

test('can order by status', function () {

    Ticket::factory(5)
        ->create();

    Ticket::factory(5)
        ->closed()
        ->create();

    Ticket::factory(5)
        ->inProgress()
        ->create();

    /** @var Ticket $ticket */
    // $ticket = Ticket::query()->orderBy('status', 'asc')->select('id',)->first();

    $response = $this->getJson('/api/tickets?column_to_order=status&order_by=asc&paginate=25');

    $response->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data.0', fn (AssertableJson $json) => $json->where('status', TicketStatus::CLOSED->value)
                ->etc()
            )
            ->etc()
        );
});
