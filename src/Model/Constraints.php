<?php
namespace App\Model;
class Constraints
{
    private array $correctPositions = [];
    private array $requiredLetters = [];
    private array $wrongPositions = [];
    private array $excludedLetters = [];

    public function getCorrectPositions(): array
    {
        return $this->correctPositions;
    }

    public function getRequiredLetters(): array
    {
        return $this->requiredLetters;
    }

    public function getWrongPositions(): array
    {
        return $this->wrongPositions;
    }

    public function getExcludedLetters(): array
    {
        return $this->excludedLetters;
    }

    public function addCorrectPosition(int $position, string $letter): void
    {
        $this->correctPositions[$position] = $letter;
    }

    public function addRequiredLetter(string $letter): void
    {
        $letter = strtolower($letter);
        if (!in_array($letter, $this->requiredLetters)) {
            $this->requiredLetters[] = $letter;
        }
    }

    public function addExcludedLetter(string $letter): void
    {
        $letter = strtolower($letter);
        if (!in_array($letter, $this->excludedLetters)) {
            $this->excludedLetters[] = $letter;
        }
    }

    public function addWrongPosition(int $position, string $letter): void
    {
        if (!isset($this->wrongPositions[$position])) {
            $this->wrongPositions[$position] = [];
        }

        if (!in_array($letter, $this->wrongPositions[$position], true)) {
            $this->wrongPositions[$position][] = $letter;
        }
    }
}