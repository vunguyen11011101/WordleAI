<?php

namespace App\Data;

class WordRepository
{
    private const ANSWERS_FILE = __DIR__ . '/../../data/answers.txt';
    private const GUESSES_FILE = __DIR__ . '/../../data/guesses.txt';

    private ?array $answers = null;
    private ?array $guesses = null;

    public function getAnswers(): array
    {
        if ($this->answers === null) {
            $this->answers = $this->loadWords(self::ANSWERS_FILE);
        }

        return $this->answers;
    }

    public function getGuesses(): array
    {
        if ($this->guesses === null) {
            $this->guesses = $this->loadWords(self::GUESSES_FILE);
        }

        return $this->guesses;
    }

    public function getAllWords(): array
    {
        return array_values(
            array_unique(
                array_merge(
                    $this->getAnswers(),
                    $this->getGuesses()
                )
            )
        );
    }

    private function loadWords(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("Word list not found: {$filePath}");
        }

        $words = file(
            $filePath,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );

        if ($words === false) {
            throw new \RuntimeException("Unable to read file: {$filePath}");
        }

        return array_map(
            static fn(string $word) => strtolower(trim($word)),
            $words
        );
    }
}