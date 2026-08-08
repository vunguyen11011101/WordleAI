<?php

namespace App\Solver;

use App\Solver\WordRepository;
use App\Model\GameState;
use RuntimeException;

class Solver
{
    private WordRepository $repository;
    private WordFilter $filter;

    public function __construct(
        WordRepository $repository,
        WordFilter $filter
    ) {
        $this->repository = $repository;
        $this->filter = $filter;
    }

    /**
     * @throws RuntimeException
     */
    public function solve(GameState $gameState): string
    {
        $constraints = $gameState->getConstraints();

        $words = $this->repository->getAnswers();

        $candidates = $this->filter->filter($words, $constraints);

        if (empty($candidates)) {
            throw new RuntimeException(
                "No candidate words satisfy the current constraints."
            );
        }

        return $candidates[0];
    }
}