<?php

declare(strict_types=1);

namespace sohe\Dice;

/**
 * Class Dice.
 */
class Dice
{
    public ?int $faces = null;
    private ?int $roll = null;

    public function __construct(int $faces = 6)
    {
        $this->faces = $faces;
    }

    public function roll(): int
    {
        $this->roll = rand(1, $this->faces);

        return $this->roll;
    }

    public function getLastRoll(): int
    {
        return $this->roll;
    }
}
