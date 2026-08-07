<?php
namespace App\Model;
class Tile{
    private int $slot;
    private string $letter;
    private string $status;

    public function __construct(int $slot, string $letter, string $status)
    {
        $this->slot = $slot;
        $this->letter = strtolower($letter);
        $this->status = $status;
    }
    
    public function getSlot(): int
    {
        return $this->slot;
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