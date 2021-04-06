<?php

declare(strict_types=1);

namespace sohe\Dice;

/**
 * Class DiceHand.
 */
class DiceHand
{
    private array $dices;
    private int $amount;
    public int $sum = 0;

    public function __construct(int $amount = 1)
    {
        $this->amount = $amount - 1;
        for ($i = 0; $i <= $this->amount; $i++) {
            $this->dices[$i] = new Dice();
        }
    }

    public function roll(): void
    {
        $len = count($this->dices);

        $this->sum = 0;
        for ($i = 0; $i <= $this->amount; $i++) {
            $this->sum += $this->dices[$i]->roll();
        }
    }

    public function getLastRoll(): string
    {
        $res = "";
        for ($i = 0; $i <= $this->amount; $i++) {
            $res .= $this->dices[$i]->getLastRoll() . ", ";
        }

        return $res . " = " . $this->sum;
    }
}
