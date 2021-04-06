<?php

declare(strict_types=1);

namespace sohe\Dice;

use sohe\Dice\Dice;
use sohe\Dice\DiceHand;
use sohe\Dice\GraphicalDice;

use function Mos\Functions\renderView;
use function Mos\Functions\sendResponse;

/**
 * Class Game.
 */
class Game
{
    public function playGame(): void
    {
        $data = [
            "header" => "Game 21",
            "message" => "welcome to the game! choose to play with one or two dices.",
        ];

        if (!isset($_SESSION["dices"])) {
              $_SESSION["dices"] = 0;
        }
        $_SESSION["dices"] ?? 0;

        $graphic = new GraphicalDice();
        $rolls = 6;
        $data["res"]  = [];
        $data["class"]  = [];
        for ($i = 0; $i < $rolls; $i++) {
            $data["res"][$i] = $graphic->roll();
            $data["class"][$i] = $graphic->graphical();
        }

        $body = renderView("layout/dice.php", $data);
        sendResponse($body);
    }

    public function startGame(): void
    {
        $data = [
            "header" => "Game 21",
            "message" => "Roll your dices and score as close to 21 as possible.",
        ];

        $hand = new DiceHand((int)$_SESSION['dices']);
        $hand->roll();
        $data['sum'] = $hand->sum;

        $body = renderView("layout/diceGame.php", $data);
        sendResponse($body);
    }

    public function roll(): int
    {
        $die = new Dice();
        $compScore = 0;

        while ($compScore < 21) {
            $die->roll();
            $compScore += $die->getLastRoll();
        }

        return $compScore;
    }

    public function compare($score): void
    {
        $data = [
            "header" => "Game 21",
            "message" => ""
        ];


        $compScore = $this->roll();
        $data['compScore'] = $compScore;
        $new = 0;

        if ($score > 21) {
            $new = $score - 21;
        }
        if ($score < 21) {
            $new = 21 - $score;
        }

        if ($compScore === 21 or ($compScore - 21) < $new) {
            $data['message'] = "The Computer won!";
            $_SESSION["computer"] += 1;
        } else {
            $data['message'] = "Congratulations, you won!";
            $_SESSION["user"] += 1;
        }

        $data['sum'] = ("Computer score: "  . $compScore);

        $body = renderView("layout/diceGame.php", $data);
        sendResponse($body);
    }
}
