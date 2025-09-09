<?php

namespace App\Contracts;

interface Prompteable
{
    public function getPrompt(): string;
}
