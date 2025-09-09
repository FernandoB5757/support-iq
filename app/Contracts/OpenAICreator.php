<?php

namespace App\Contracts;

interface OpenAICreator
{
    public function record(Prompteable $record): static;

    public function create();
}
