<?php

namespace Tests\Model;

use App\Model\Constraints;
use PHPUnit\Framework\TestCase;

class ConstraintsTest extends TestCase
{
    public function testAddCorrectPosition(): void
    {
        $constraints = new Constraints();

        $constraints->addCorrectPosition(0, 'a');

        $this->assertSame(
            'a',
            $constraints->getCorrectPositions()[0]
        );
    }


    public function testAddRequiredLetter(): void
    {
        $constraints = new Constraints();

        $constraints->addRequiredLetter('a');

        $this->assertContains(
            'a',
            $constraints->getRequiredLetters()
        );
    }


    public function testAddExcludedLetter(): void
    {
        $constraints = new Constraints();

        $constraints->addExcludedLetter('z');

        $this->assertContains(
            'z',
            $constraints->getExcludedLetters()
        );
    }


    public function testAddWrongPosition(): void
    {
        $constraints = new Constraints();

        $constraints->addWrongPosition(2, 'a');

        $wrongPositions =
            $constraints->getWrongPositions();

        $this->assertContains(
            'a',
            $wrongPositions[2]
        );
    }
}