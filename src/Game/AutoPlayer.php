<?php

namespace App\Game;

use App\Api\WordleClient;
use App\Model\GameState;
use App\Solver\Solver;
use App\Model\Tile;

class AutoPlayer
{
    private Solver $solver;
    private WordleClient $client;

    public function __construct(
        Solver $solver,
        WordleClient $client
    ) {
        $this->solver = $solver;
        $this->client = $client;
    }

    public function playDaily(): GameState
    {
        $gameState = new GameState();

        while (
            !$gameState->isSolved()
            && $gameState->getAttempts() < 6
        ) {

            $guess = $this->solver->solve($gameState);

            $tiles = $this->client->guessDaily($guess);

            $this->updateConstraints(
                $gameState,
                $tiles
            );

            $gameState->incrementAttempts();

            if ($this->isSolved($tiles)) {
                $gameState->setSolved();
            }
        }

        return $gameState;
    }

    private function updateConstraints(
        GameState $gameState,
        array $tiles
    ): void {

        $constraints = $gameState->getConstraints();

        foreach ($tiles as $tile) {

            $letter = strtolower($tile->getLetter());
            $position = $tile->getPosition();

            switch ($tile->getState()) {

                case Tile::CORRECT:

                    $constraints->addCorrectPosition(
                        $position,
                        $letter
                    );

                    $constraints->addRequiredLetter(
                        $letter
                    );

                    break;

                case Tile::PRESENT:

                    $constraints->addRequiredLetter(
                        $letter
                    );

                    $constraints->addWrongPosition(
                        $position,
                        $letter
                    );

                    break;

                case Tile::ABSENT:

                    $constraints->addExcludedLetter(
                        $letter
                    );

                    break;
            }

        }

    }

    private function isSolved(array $tiles): bool
    {
        foreach ($tiles as $tile) {

            if ($tile->getState() !== Tile::CORRECT) {
                return false;
            }

        }

        return true;
    }
}