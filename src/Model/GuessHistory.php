<?php

namespace App\Model;

class GuessHistory
{
    private array $guesses = [];

    public function addGuess(array $tiles): void
    {
        $this->guesses[] = $tiles;
    }

    public function getGuesses(): array
    {
        return $this->guesses;
    }

    public function getGuessCount(): int
    {
        return count($this->guesses);
    }
}