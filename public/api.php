<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\API\WordleClient;
use App\Solver\WordRepository;
use App\Solver\WordFilter;
use App\Solver\Solver;
use App\Game\AutoPlayer;

header('Content-Type: application/json');

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);

        echo json_encode([
            'success' => false,
            'error' => 'Method Not Allowed'
        ]);

        exit;
    }

    $input = json_decode(
        file_get_contents('php://input'),
        true
    );

    $mode = $input['mode'] ?? 'daily';


    // =========================
    // Kiểm tra mode
    // =========================

    if (!in_array($mode, ['daily', 'test'], true)) {

        throw new RuntimeException(
            'Invalid game mode.'
        );
    }


    // =========================
    // Nếu là test mode
    // =========================

    $targetWord = null;

    if ($mode === 'test') {

        $targetWord = strtolower(
            trim($input['target'] ?? '')
        );

        if ($targetWord === '') {

            throw new RuntimeException(
                'Target word is required in test mode.'
            );
        }

        if (strlen($targetWord) !== 5) {

            throw new RuntimeException(
                'Target word must contain exactly 5 letters.'
            );
        }
    }

    $wordRepository = new WordRepository();
    $wordFilter = new WordFilter();

    $solver = new Solver(
        $wordRepository,
        $wordFilter
    );

    $wordleClient = new WordleClient();

    $autoPlayer = new AutoPlayer(
        $solver,
        $wordleClient,
        $targetWord
    );

    $gameState = $autoPlayer->playDaily();

    $guesses = [];

    foreach ($gameState->getGuessHistory()->getGuesses() as $tiles) {

        $guess = [];

        foreach ($tiles as $tile) {

            $guess[] = [
                'slot' => $tile->getSlot(),
                'letter' => $tile->getLetter(),
                'status' => $tile->getStatus()
            ];
        }

        $guesses[] = $guess;
    }

    echo json_encode([
        'success' => true,

        'solved' => $gameState->isSolved(),

        'attempts' => $gameState->getAttempts(),

        'guesses' => $guesses,

        'constraints' => [
            'correctPositions' =>
                $gameState
                    ->getConstraints()
                    ->getCorrectPositions(),

            'requiredLetters' =>
                $gameState
                    ->getConstraints()
                    ->getRequiredLetters(),

            'wrongPositions' =>
                $gameState
                    ->getConstraints()
                    ->getWrongPositions(),

            'excludedLetters' =>
                $gameState
                    ->getConstraints()
                    ->getExcludedLetters()
        ]
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}