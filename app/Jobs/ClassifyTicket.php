<?php

namespace App\Jobs;

use App\Contracts\OpenAICreator;
use App\DTOs\AIClassifyResponse;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketNote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ClassifyTicket implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Ticket $ticket
    ) {}

    /**
     * Execute the job.
     */
    public function handle(
        OpenAICreator $openAICreator
    ): void {
        $response = $openAICreator
            ->record($this->ticket)
            ->create();

        $category = $this->firstOrCreateCategory($response);

        if (is_null($this->ticket->category_id)) {
            $this->ticket->category_id = $category->id;
        }

        if (is_null($this->ticket->confidence)) {
            $this->ticket->confidence = $response->confidence;
        }

        $this->ticket->explanation = $this->ticket->explanation.' '.$response->explanation;

        $this->ticket->save();

        $this->ticket->notes()->save(
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
