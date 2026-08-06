<?php
namespace App\Model;
class Tile{
    private string $letter;
    private string $status;

    public function __construct(string $letter, string $status)
    {
        $this->letter = $letter;
        $this->status = $status;
    }

    public function getLetter(): string
    {
        return $this->letter;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isCorrect(): bool
    {
        return $this->status === 'correct';
    }

    public function isPresent(): bool
    {
        return $this->status === 'present';
    }

    public function isAbsent(): bool
    {
        return $this->status === 'absent';
    }   
}
?>