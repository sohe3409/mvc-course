<?php

declare(strict_types=1);

namespace Mos\Router;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "Index page",
                "message" => "Hello, this is the index page, rendered as a layout.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } else if ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/dice") {
            $callable = new \sohe\Dice\Game();
            $callable->playGame();

            return;
        } else if ($method === "POST" && $path === "/dice") {
            $callable = new \sohe\Dice\Game();
            $data = $_POST["action"];

            if ($data === "start") {
                $_SESSION['dices'] = $_POST["dices"];
                $callable->startGame();
            } else if ($data === "Roll again") {
                $callable->startGame();
            } else if ($data === "New round") {
                $_SESSION["compScore"] = 0;
                $_SESSION["score"] = 0;
                $callable->startGame();
            } else if ($data === "Stop") {
                $callable->compare($_POST["score"]);
            } else if ($data === "Start over") {
                destroySession();
                $callable->playGame();
            }

            return;
        } else if ($method === "GET" && $path === "/diceGame") {
            $body = renderView("layout/diceGame.php");
            sendResponse($body);

            return;
        }
        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}
