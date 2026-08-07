<?php

namespace App\Solver;

use App\Model\Constraints;

class WordFilter
{
    /**
     * @param array $words
     * @param Constraints $constraints
     * @return array
     */
    public function filter(array $words, Constraints $constraints): array
    {
        $filtered = [];

        foreach ($words as $word) {
            if ($this->matches($word, $constraints)) {
                $filtered[] = $word;
            }
        }

        return $filtered;
    }

    private function matches(string $word, Constraints $constraints): bool
    {
        return
            $this->checkCorrectPositions($word, $constraints) &&
            $this->checkRequiredLetters($word, $constraints) &&
            $this->checkWrongPositions($word, $constraints) &&
            $this->checkExcludedLetters($word, $constraints);
    }

    private function checkCorrectPositions(string $word, Constraints $constraints): bool
    {
        foreach ($constraints->getCorrectPositions() as $position => $letter) {
            if ($word[$position] !== $letter) {
                return false;
            }
        }

        return true;
    }

    private function checkRequiredLetters(string $word, Constraints $constraints): bool
    {
        foreach ($constraints->getRequiredLetters() as $letter) {
            if (!str_contains($word, $letter)) {
                return false;
            }
        }

        return true;
    }

    private function checkWrongPositions(string $word, Constraints $constraints): bool
    {
        foreach ($constraints->getWrongPositions() as $position => $letters) {

            foreach ($letters as $letter) {

                if ($word[$position] === $letter) {
                    return false;
                }

            }

        }

        return true;
    }

    private function checkExcludedLetters(string $word, Constraints $constraints): bool
    {
        foreach ($constraints->getExcludedLetters() as $letter) {

            if (str_contains($word, $letter)) {
                return false;
            }

        }

        return true;
    }
}