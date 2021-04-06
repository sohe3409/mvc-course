<?php

declare(strict_types=1);

namespace sohe\Dice;

/**
 * Class Dice.
 */
class GraphicalDice extends Dice
{
    /**
    * @var integer SIDES Number of sides of the Dice.
    */
    const SIDES = 6;

    /**
    * Constructor to initiate the dice with six number of sides.
    */
    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    public function graphical(): string
    {
        $res = "dice-" . $this->getLastRoll();
        return $res;
    }
}
