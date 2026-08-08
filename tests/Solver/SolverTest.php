<?php

namespace Tests\Solver;

use App\Model\Constraints;
use App\Model\GameState;
use App\Solver\Solver;
use App\Solver\WordFilter;
use App\Solver\WordRepository;
use PHPUnit\Framework\TestCase;

class SolverTest extends TestCase
{
    public function testSolverReturnsValidCandidate(): void
    {
        $repository = $this->createMock(
            WordRepository::class
        );

        $repository
            ->method('getAnswers')
            ->willReturn([
                'apple',
                'angle',
                'grape'
            ]);


        $filter = new WordFilter();

        $solver = new Solver(
            $repository,
            $filter
        );


        $gameState = new GameState();

        $gameState
            ->getConstraints()
            ->addCorrectPosition(
                0,
                'a'
            );


        $guess = $solver->solve(
            $gameState
        );


        $this->assertContains(
            $guess,
            [
                'apple',
                'angle'
            ]
        );
    }
}