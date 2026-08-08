<?php
namespace App\Model;
class GameState{
    private Constraints $constraints;
    private int $attempts;
    private bool $isSolved = false;
    private GuessHistory $guessHistory;

    public function __construct()
    {
        $this->constraints = new Constraints();
        $this->attempts = 0;
        $this->guessHistory = new GuessHistory();
    }

    public function getConstraints(): Constraints
    {
        return $this->constraints;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function getGuessHistory(): GuessHistory
    {
        return $this->guessHistory;
    }
    
    public function incrementAttempts(): void
    {
        $this->attempts++;
    }

    public function isSolved(): bool
    {
        return $this->isSolved;
    }

    public function setSolved(): void
    {
        $this->isSolved = true;
    }
}
?>