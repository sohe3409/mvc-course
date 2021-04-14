<?php

declare(strict_types=1);

namespace sohe\Dice;

/**
 * Class DiceHand.
 */
class DiceHand
{
    public $dices;
    private $amount;
    public $sum = 0;

    public function __construct(int $amount = 5)
    {
        $this->amount = $amount - 1;
        for ($i = 0; $i <= $this->amount; $i++) {
            $this->dices[$i] = new DiceHistogram();
        }
    }

    public function roll(): void
    {
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

    public function getLast(array $num = ["one", "two", "three", "four", "five"]): void
    {
        for ($i = 0; $i <= $this->amount; $i++) {
            $_SESSION[$num[$i]] = $this->dices[$i]->getLastRoll();
        }
    }

    public function score(array $num, string $choice): void
    {
        $count = 0;
        foreach ($num as $v) {
            if ($v === (int)$choice) {
                $count += 1;
            };
        }
        $res = (int)$count * (int)$choice;

        $_SESSION["score"] += $res;
        $_SESSION["score" . $choice] = $res;

        unset($_SESSION["choices"][$choice]);

        if (count($_SESSION["choices"]) === 0) {
            if ($_SESSION["score"] >= 63) {
                $_SESSION["bonus"] = 50;
                $_SESSION["score"] += 50;
            } else {
                $_SESSION["bonus"] = 0;
            }
            $_SESSION["status"] = "done";
        }
    }
}
