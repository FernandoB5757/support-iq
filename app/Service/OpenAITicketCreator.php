<?php

namespace App\Service;

use App\Contracts\OpenAICreator;
use App\Contracts\Prompteable;
use App\DTOs\AIClassifyResponse;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAITicketCreator implements OpenAICreator
{
    protected string $model = 'gpt-4o-mini-2024-07-18';

    protected string $userContent;

    protected Prompteable $record;

    public function record(Prompteable $record): static
    {
        $this->record = $record;

        return $this;
    }

    public function create(): AIClassifyResponse
    {
        $response = OpenAI::responses()->create(
            $this->buildParameters()
        );

        return AIClassifyResponse::fromAIResponse(
            json_decode($response->outputText)
        );
    }

    protected function buildParameters(): array
    {
        return [
            'model' => $this->model,
            'input' => $this->input(),
            'text' => [
                'format' => $this->format(),
            ],
        ];
    }

    protected function input(): array
    {
        return [
            [
                'role' => 'system',
                'content' => "You are a ticket classification assistant. You must return a JSON object matching the schema named 'tickets:bulk-classify' with keys: category, explanation, and confidence (number between 0 and 1). Do not return any other properties. Be concise and only output JSON.",
            ],
            [
                'role' => 'user',
                'content' => 'Classify this ticket '.$this->record->getPrompt(),
            ],
        ];
    }

    protected function format(): array
    {
        return [
            'type' => 'json_schema',
            'name' => 'tickets_bulk_classify',
            'description' => 'Returns JSON containing the category, explanation, and confidence for a ticket classification',
            'strict' => true,
            'schema' => $this->schema(),
        ];
    }

    protected function schema(): array
    {
        return [
            'type' => 'object',
            'properties' => [
                'category' => [
                    'type' => 'string',
                    'description' => 'The predicted category for the ticket.',
                ],
                'explanation' => [
                    'type' => 'string',
                    'description' => 'Explanation for why this category was chosen.',
                ],
                'confidence' => [
                    'type' => 'number',
                    'description' => 'Confidence score between 0 and 1.',
                    'minimum' => 0,
                    'maximum' => 1,
                ],
            ],
            'required' => [
                'category',
                'explanation',
                'confidence',
            ],
            'additionalProperties' => false,
        ];
    }

    public function dd(): void
    {
        dd($this->buildParameters());
    }

    public function dump(): static
    {
        dump($this->buildParameters());

        return $this;
    }
}
