<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use Mos\Dice\Dice;
use Mos\Dice\DiceHand;

$header = $header ?? null;
$message = $message ?? null;

$die = new Dice();
$die->roll();

$diceHand = new DiceHand();
$diceHand->roll();

?><h1><?= $header ?></h1>

<p><?= $message ?></p>
<p>Dice</p>

<p><?= $die->getLastRoll() ?></p>

<p>dicehand</p>


<p><?= $diceHand->getLastRoll() ?></p>
