<?php

declare(strict_types=1);

namespace Mos\Controller;

use sohe\Dice\Dice;
use sohe\Dice\DiceHand;
use sohe\Dice\GraphicalDice;
use sohe\Dice\DiceHistogram;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\{
    destroySession,
    renderView,
    url
};

/**
 * Controller showing how to work with forms.
 */
class Yatzy
{
    public function view(): ResponseInterface
    {
        $data = [
            "header" => "Yatzy",
            "message" => "Press button to start game!",
            "action" => url("/yatzy/play")
        ];

        $body = renderView("layout/yatzy.php", $data);
        $_SESSION["status"] = "play";
        $_SESSION["rolls"] = 3;
        $_SESSION["choices"] = [
            "1" => "one", "2" => "two",
            "3" => "three", "4" => "four",
            "5" => "five", "6" => "six"];

        $_SESSION["score1"] = 0;
        $_SESSION["score2"] = 0;
        $_SESSION["score3"] = 0;
        $_SESSION["score4"] = 0;
        $_SESSION["score5"] = 0;
        $_SESSION["score6"] = 0;
        $_SESSION["score"] = 0;
        $_SESSION["bonus"] = 0;
        if (!isset($_SESSION["one"])) {
              $_SESSION["one"] = 0;
        }
        if (!isset($_SESSION["two"])) {
              $_SESSION["two"] = 0;
        }
        if (!isset($_SESSION["three"])) {
              $_SESSION["three"] = 0;
        }
        if (!isset($_SESSION["four"])) {
              $_SESSION["four"] = 0;
        }
        if (!isset($_SESSION["five"])) {
              $_SESSION["five"] = 0;
        }

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }



    public function process(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Yatzy",
            "message" => "",
            "action" => url("/yatzy/play")
        ];


        $action = $_POST["action"] ?? null;
        if ($action === "Start!") {
            $hand = new DiceHand();
            $hand->roll();
            $hand->getLast();

        } else if ($action === "Roll again") {
            $num = [];
            foreach ($_POST as $key => $value) {
                array_push($num, $key);
            }
            $hand = new DiceHand(count($_POST) - 1);
            $hand->roll();
            $hand->getLast($num);
        } else if ($action === "Continue") {
            $hand = new DiceHand();
            $hand->score($_SESSION["result"], $_POST["choice"]);
            if ($_SESSION["status"] === "play") {
                $_SESSION["rolls"] = 3;
                $hand->roll();
                $hand->getLast();
            }
        } else if ($action === "Start over") {
            destroySession();

            return $psr17Factory
                ->createResponse(301)
                ->withHeader("Location", url("/yatzy/view"));
        };

        $_SESSION["result"] = [
                  $_SESSION["one"],
                  $_SESSION["two"],
                  $_SESSION["three"],
                  $_SESSION["four"],
                  $_SESSION["five"]];

          $histo = new DiceHistogram();
          $histo->setHistogramSerie($_SESSION["result"]);

          $data["message"] = $histo->printHistogram();;

          $body = renderView("layout/yatzyGame.php", $data);
          return $psr17Factory
              ->createResponse(200)
              ->withBody($psr17Factory->createStream($body));
    }


}
