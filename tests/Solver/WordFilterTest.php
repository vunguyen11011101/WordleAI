<?php

namespace Tests\Solver;

use App\Model\Constraints;
use App\Solver\WordFilter;
use PHPUnit\Framework\TestCase;

class WordFilterTest extends TestCase
{
    private WordFilter $filter;

    protected function setUp(): void
    {
        $this->filter = new WordFilter();
    }


    public function testCorrectPosition(): void
    {
        $constraints = new Constraints();

        $constraints->addCorrectPosition(0, 'a');

        $words = [
            'apple',
            'angle',
            'grape',
            'brave'
        ];

        $result = $this->filter->filter(
            $words,
            $constraints
        );

        $this->assertContains('apple', $result);
        $this->assertContains('angle', $result);

        $this->assertNotContains('grape', $result);
        $this->assertNotContains('brave', $result);
    }


    public function testExcludedLetter(): void
    {
        $constraints = new Constraints();

        $constraints->addExcludedLetter('z');

        $words = [
            'apple',
            'zebra',
            'grape',
            'blaze'
        ];

        $result = $this->filter->filter(
            $words,
            $constraints
        );

        $this->assertNotContains('zebra', $result);
        $this->assertNotContains('blaze', $result);
    }


    public function testRequiredLetter(): void
    {
        $constraints = new Constraints();

        $constraints->addRequiredLetter('p');

        $words = [
            'apple',
            'angle',
            'grape',
            'table'
        ];

        $result = $this->filter->filter(
            $words,
            $constraints
        );

        $this->assertContains('apple', $result);
        $this->assertContains('grape', $result);

        $this->assertNotContains('angle', $result);
        $this->assertNotContains('table', $result);
    }


    public function testWrongPosition(): void
    {
        $constraints = new Constraints();

        $constraints->addRequiredLetter('a');

        $constraints->addWrongPosition(
            0,
            'a'
        );

        $words = [
            'apple',
            'table',
            'grape',
            'angle'
        ];

        $result = $this->filter->filter(
            $words,
            $constraints
        );

        $this->assertNotContains(
            'apple',
            $result
        );

        $this->assertContains(
            'table',
            $result
        );
    }

    public function testRepeatedLetters(): void
    {
        $filter = new WordFilter();

        $constraints = new Constraints();

        $constraints->setLetterCount('p', 2);

        $words = [
            'apple', 
            'ample', 
            'apply', 
            'apron', 
        ];

        $result = $filter->filter(
            $words,
            $constraints
        );

        $this->assertCount(2, $result);

        $this->assertContains('apple', $result);
        $this->assertContains('apply', $result);

        $this->assertNotContains('ample', $result);
        $this->assertNotContains('apron', $result);
    }
    public function testRepeatedLetterPresentAndAbsent(): void
{
    $filter = new WordFilter();

    $constraints = new Constraints();

    // Có ít nhất 1 chữ p
    $constraints->setLetterCount('p', 1);

    // Không được loại p chỉ vì một p trong guess là absent
    $words = [
        'apple',
        'ample',
        'alone',
    ];

    $result = $filter->filter(
        $words,
        $constraints
    );

    $this->assertContains('apple', $result);
    $this->assertContains('ample', $result);

    $this->assertNotContains('alone', $result);
}    
}