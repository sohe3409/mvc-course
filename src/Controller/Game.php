<?php

declare(strict_types=1);

namespace Mos\Controller;

use sohe\Dice\Dice;
use sohe\Dice\DiceHand;
use sohe\Dice\GraphicalDice;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;
use function Mos\Functions\destroySession;

/**
 * Class Game.
 */
class Game
{
    public function playGame(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Game 21",
            "message" => "welcome to the game! choose to play with one or two dices.",
        ];

        if (!isset($_SESSION["dices"])) {
              $_SESSION["dices"] = 0;
        }
        $_SESSION["dices"] ?? 0;

        $body = renderView("layout/dice.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function startGame(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
          "header" => "Game 21",
          "message" => "Roll your dices and score as close to 21 as possible.",
          "sum" => ""
        ];

        $action = $_POST["action"];

        if ($action === "start") {
            $_SESSION['dices'] = $_POST["dices"];
            $hand = new DiceHand((int)$_SESSION['dices']);
            $hand->roll();
            $data['sum'] = $hand->sum;
        } else if ($action === "Roll again") {
            $hand = new DiceHand((int)$_SESSION['dices']);
            $hand->roll();
            $data['sum'] = $hand->sum;
        } else if ($action === "New round") {
            $_SESSION["compScore"] = 0;
            $_SESSION["score"] = 0;
            $hand = new DiceHand((int)$_SESSION['dices']);
            $hand->roll();
            $data['sum'] = $hand->sum;
        } else if ($action === "Stop") {
            $score = $_POST["score"];
            $compScore = $this->roll();
            $data['compScore'] = $compScore;
            $new = 0;

            if ($score > 21) {
                $new = $score - 21;
            }
            if ($score < 21) {
                $new = 21 - $score;
            }

            if (($score != 21 and $compScore == 21) or (($compScore - 21) < $new)) {
                $data['message'] = "The Computer won!";
                $_SESSION["computer"] += 1;
            } else {
                $data['message'] = "Congratulations, you won!";
                $_SESSION["user"] += 1;
            }

            $data['sum'] = ("Computer score: "  . $compScore);
        } else if ($action === "Start over") {
            destroySession();
            $body = renderView("layout/dice.php", $data);

            return $psr17Factory
                ->createResponse(200)
                ->withBody($psr17Factory->createStream($body));
        }

        $body = renderView("layout/diceGame.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
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
}
