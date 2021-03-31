<?php

declare(strict_types=1);

namespace Mos\Dice;

// use function Mos\Functions\{
//     destroySession,
//     redirectTo,
//     renderView,
//     renderTwigView,
//     sendResponse,
//     url
// };

/**
 * Class Router.
 */
class Dice
{
    const FACES = 6;

    private int $roll = null;

    public static function roll(): int
    {
        $this->$roll = rand(1, 6);
        return $this->$roll;
    }

    public static function getLastRoll(): int
    {
        return $this->$roll;
    }
}
