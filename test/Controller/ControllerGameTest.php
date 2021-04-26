<?php

declare(strict_types=1);

namespace Mos\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Form.
 */
class ControllerGameTest extends TestCase
{
    public function start()
    {
        $_SESSION = array('key' => 'value');
        $_POST = array('key' => 'value');
        $_SESSION["dices"] = 0;
        $_SESSION["computer"] = 0;
        $_SESSION["user"] = 0;
        $_SESSION["compScore"] = 0;
        $_SESSION["score"] = 0;
        $_POST["action"] = "";
    }

    public function testCreateTheControllerClass()
    {
        $controller = new Game();
        $this->assertInstanceOf("\Mos\Controller\Game", $controller);
    }

    public function testControllerView()
    {
        $controller = new Game();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->playGame();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerProcess()
    {
        $this->start();
        $controller = new Game();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->startGame();
        $this->assertInstanceOf($exp, $res);
    }

    public function testControllerProcessAction()
    {
        $this->start();
        $action = ["start", "Roll again", "Stop", "New round", "Start over"];
        $game = new Game();

        $_POST["action"] = $action[0];
        $_POST["dices"] = 1;
        $game->startGame();
        $this->assertEquals($_SESSION["dices"], 1);

        $_POST["action"] = $action[1];
        $game->startGame();

        $_POST["action"] = $action[2];
        $_POST["score"] = 0;
        $game->startGame();
        $this->assertEquals($_SESSION["computer"], 1);

        $_POST["action"] = $action[2];
        $_POST["score"] = 30;
        $game->startGame();
        $this->assertEquals($_SESSION["computer"], 2);

        $_POST["action"] = $action[2];
        $_POST["score"] = 21;
        $game->startGame();
        $this->assertEquals($_SESSION["user"], 1);

        $_POST["action"] = $action[3];
        $game->startGame();
    }
}
