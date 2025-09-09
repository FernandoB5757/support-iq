<?php

namespace App\Contracts;

use App\DTOs\AIClassifyResponse;

interface OpenAICreator
{
    public function record(Prompteable $record): static;

    public function create(): AIClassifyResponse;
}
