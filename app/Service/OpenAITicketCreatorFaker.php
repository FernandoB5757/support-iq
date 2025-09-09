<?php

namespace App\Service;

use App\Contracts\OpenAICreator;
use App\Contracts\Prompteable;
use App\DTOs\AIClassifyResponse;
use App\Models\Category;
use Random\Randomizer;

class OpenAITicketCreatorFaker implements OpenAICreator
{
    public function record(Prompteable $record): static
    {
        return $this;
    }

    public function create(): AIClassifyResponse
    {
        return new AIClassifyResponse(
            category: Category::inRandomOrder()->first()->name ?? 'Technical Issue',
            explanation: 'The subject mentions "middleware", indicating a potential technical problem related to software infrastructure',
            confidence: (new Randomizer)->getFloat(0, 1)
        );
    }
}
