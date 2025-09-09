<?php

namespace App\Jobs;

use App\Contracts\OpenAICreator;
use App\Models\Ticket;
use App\Service\TicketClassifier;
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

        $clasifier = new TicketClassifier(
            $openAICreator
        );

        $clasifier->clasify($this->ticket);
    }
}
