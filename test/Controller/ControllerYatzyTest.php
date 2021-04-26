<?php

declare(strict_types=1);

namespace Mos\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
/**
 * Test cases for the controller Form.
 */
class ControllerYatzyTest extends TestCase
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

    public function testCreateTheControllerClass()
    {
        $controller = new Yatzy();
        $this->assertInstanceOf("\Mos\Controller\Yatzy", $controller);
    }

    public function testControllerViewAction()
    {
        $_SESSION = array('key' => 'value');
        $controller = new Yatzy();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->view();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerProcessAction()
    {
        $this->start();
        $controller = new Yatzy();

        $exp = "\Psr\Http\Message\ResponseInterface";

        $res = $controller->process();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerProcessActionStart()
    {
        $this->start();
        $action = ["Start!", "Roll again", "Stop", "Continue"];
        $yatzy = new Yatzy();

        $_POST["action"] = $action[0];
        $yatzy->process();
        $this->assertEquals($_SESSION["score"], 0);

        $_POST["action"] = $action[1];
        $yatzy->process();
        $this->assertEquals($_SESSION["rolls"], 1);

        $_POST["action"] = $action[2];
        $yatzy->process();
        $this->assertEquals($_SESSION["rolls"], 0);

        $_POST["action"] = $action[3];
        $_POST["choice"] = "1";
        $_SESSION["one"] = 1;
        $_SESSION["two"] = 1;
        $_SESSION["three"] = 1;
        $_SESSION["four"] = 1;
        $_SESSION["five"] = 1;
        $_SESSION["result"] = [
            $_SESSION["one"],
            $_SESSION["two"],
            $_SESSION["three"],
            $_SESSION["four"],
            $_SESSION["five"]];

        $yatzy->process();
        $this->assertEquals($_SESSION["score1"], 5);
    }
}
