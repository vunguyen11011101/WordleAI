<?php

namespace App\Game;

use App\API\WordleClient;
use App\Model\GameState;
use App\Solver\Solver;
use App\Model\Tile;

class AutoPlayer
{
    private Solver $solver;
    private WordleClient $client;
    private ?string $targetWord;

    public function __construct(
        Solver $solver,
        WordleClient $client,
        ?string $targetWord
    ) {
        $this->solver = $solver;
        $this->client = $client;
        $this->targetWord = $targetWord;
    }

    public function playDaily(): GameState
    {
        $gameState = new GameState();

        while (
            !$gameState->isSolved()
            && $gameState->getAttempts() < 6
        ) {

            $guess = $this->solver->solve($gameState);

            if ($this->targetWord !== null) {
                $response = $this->client->guessWord(
                    $this->targetWord,
                    $guess
                );
            } else {
                $response = $this->client->guessDaily($guess);
            }

            $tiles = $this->createTiles($response);
            $gameState->getGuessHistory()->addGuess($tiles);
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

    private function createTiles(array $response): array
    {
        $tiles = [];

        foreach ($response as $item) {
            $tiles[] = new Tile(
                (string) $item['slot'],
                $item['guess'],
                $item['result']
            );
        }

        return $tiles;
    }
    private function updateConstraints(
        GameState $gameState,
        array $tiles
    ): void {
        $constraints = $gameState->getConstraints();

        foreach ($tiles as $tile) {

            $letter = strtolower($tile->getLetter());
            $position = (int) $tile->getSlot();

            switch ($tile->getStatus()) {

                case 'correct':

                    $constraints->addCorrectPosition(
                        $position,
                        $letter
                    );

                    $constraints->addRequiredLetter(
                        $letter
                    );

                    break;

                case 'present':

                    $constraints->addRequiredLetter(
                        $letter
                    );

                    $constraints->addWrongPosition(
                        $position,
                        $letter
                    );

                    break;

                case 'absent':

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

            if (!$tile->isCorrect()) {
                return false;
            }
        }

        return true;
    }
}