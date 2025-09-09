<?php

namespace App\DTOs;

readonly class AIClassifyResponse
{
    public function __construct(
        public string $category,
        public string $explanation,
        public float $confidence
    ) {}

    public static function fromAIResponse(object $data): static
    {
        return new static(
            category : $data->category,
            explanation : $data->explanation,
            confidence : $data->confidence
        );
    }
}
