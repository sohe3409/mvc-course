<?php

declare(strict_types=1);

namespace sohe\Dice;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Form.
 */
class ClassDiceTest extends TestCase
{
    public function start()
    {
        $_SESSION = array('key' => 'value');
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
        $_SESSION["result"] = [
            $_SESSION["one"],
            $_SESSION["two"],
            $_SESSION["three"],
            $_SESSION["four"],
            $_SESSION["five"]];
    }

    public function testDiceRoll()
    {
        $dice = new Dice();
        $res = $dice->roll();
        $this->assertTrue($res > 0 && $res < 7);
    }

    public function testDiceGetLastRoll()
    {
        $dice = new Dice();
        $res1 = $dice->roll();
        $res2 = $dice->getLastRoll();
        $this->assertTrue($res1 === $res2);
    }

    public function testDiceGraphical()
    {
        $dice = new GraphicalDice();
        $res1 = $dice->roll();
        $res2 = $dice->getLastRoll();
        $res3 = $dice->graphical();
        $res4 = "dice-" . (string)$dice->getLastRoll();
        $this->assertTrue($res1 === $res2);
        $this->assertTrue($res3 === $res4);
    }

    public function testHandRoll()
    {
        $hand = new DiceHand();
        $hand->roll();

        for ($i = 0; $i <= 4; $i++) {
            $this->assertTrue($hand->dices[$i]->getLastRoll() > 0
            && $hand->dices[$i]->getLastRoll() < 7);
        }
    }

    public function testHandGetLastRoll()
    {
        $hand = new DiceHand(2);
        $hand->roll();
        $res1 = $hand->getLastRoll();
        $res2 = (string)$hand->dices[0]->getLastRoll() . ", " .
        (string)$hand->dices[1]->getLastRoll() . ", " . " = " . (string)$hand->sum;

        $this->assertEquals($res1, $res2);
    }

    public function testHandGetLast()
    {
        $this->start();
        $hand = new DiceHand(1);
        $hand->roll();
        $hand->getLast();
        $this->assertEquals($_SESSION["one"], $hand->dices[0]->getLastRoll());
    }

    public function testHandScore()
    {
        $this->start();
        $hand = new DiceHand(1);
        $hand->roll();
        $hand->getLast();
        $_SESSION["result"] = [$_SESSION["one"]];
        $_SESSION["choices"] = ["1" => "one"];
        $hand->score($_SESSION["result"], "1");
        $res = 0;

        if ($hand->dices[0]->getLastRoll() == 1) {
            $res = 1;
        }

        $this->assertEquals($_SESSION["score"], $res);
    }

    public function testHistogram()
    {
        $arr = [1,2,2];
        $dice = new DiceHistogram();
        $dice->setHistogramSerie($arr);
        $res2 = $dice->getHistogramSerie();
        $res = $dice->printHistogram();
        $res1 = "1: *<br>2: **<br>";

        $this->assertEquals($res2, $arr);
        $this->assertEquals($res1, $res);
    }
}
