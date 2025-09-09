<?php

namespace App\Service;

use App\Contracts\OpenAICreator;
use App\DTOs\AIClassifyResponse;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketNote;

class TicketClassifier
{
    public function __construct(
        protected OpenAICreator $openAICreator
    ) {}

    public function clasify(Ticket $ticket): void
    {
        $response = $this->openAICreator
            ->record($ticket)
            ->create();

        $category = $this->firstOrCreateCategory($response);

        if (is_null($ticket->category_id)) {
            $ticket->category_id = $category->id;
        }

        if (is_null($ticket->confidence)) {
            $ticket->confidence = $response->confidence;
        }

        $ticket->explanation = $ticket->explanation.' '.$response->explanation;

        $ticket->save();

        $ticket->notes()->save(
            $this->makeNote($response)
        );
    }

    protected function firstOrCreateCategory(
        AIClassifyResponse $data
    ): Category {
        return Category::firstOrCreate([
            'name' => $data->category,
        ]);
    }

    protected function makeNote(
        AIClassifyResponse $data
    ): TicketNote {
        return TicketNote::make([
            'owner' => 'System',
            'content' => 'Response for AI: '.$data->toString(),
        ]);
    }
}
