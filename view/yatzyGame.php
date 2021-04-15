<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;
$action = $action ?? null;
$output = $output ?? null;

$_SESSION["rolls"] -= 1;
$count = $_SESSION["rolls"];

?><h1><?= $header ?></h1>

<?php if ($_SESSION["status"] === "play") { ?>
<p>Rolls left: <?= $count ?></p>

    <?php if ($count === 0) { ?>
        <p>Choose witch category to score in:</p>
        <form action="<?= $action ?>" method="post">
            <?php foreach ($_SESSION["choices"] as $k => $v) { ?>
              <input type="radio" name="choice" value="<?= $k ?>" required>
              <label for="choice"><?= $k ?></label>
            <?php } ?>
            <input type="submit" name="action" value="Continue">
        </form>

    <?php } else { ?>
        <p>Choose which dices to throw again:</p>
        <form action="<?= $action ?>" method="post">
            <input type="radio" name="one" value="<?= $_SESSION["one"] ?>">
            <label for="dices"><?= $_SESSION["one"] ?></label><br>
            <input type="radio" name="two" value="<?= $_SESSION["two"] ?>">
            <label for="dices"><?= $_SESSION["two"] ?></label><br>
            <input type="radio" name="three" value="<?= $_SESSION["three"] ?>">
            <label for="dices"><?= $_SESSION["three"] ?></label><br>
            <input type="radio" name="four" value="<?= $_SESSION["four"] ?>">
            <label for="dices"><?= $_SESSION["four"] ?></label><br>
            <input type="radio" name="five" value="<?= $_SESSION["five"] ?>">
            <label for="dices"><?= $_SESSION["five"] ?></label><br><br>

            <input type="submit" name="action" value="Roll again">
        </form>
        <form action="<?= $action ?>" method="post">
            <p>
                <input type="submit" name="action" value="Stop">
            </p>
        </form>

    <?php } ?>
    <p><?= $message ?></p>
<?php } else { ?>
    <h2>End of Game!</h2>

    <form action="<?= $action ?>" method="post">
        <input type="submit" name="action" value="Start over">
    </form>
<?php } ?>


<div>
    <h2>Score board</h2>
    <p>1: <?= $_SESSION["score1"] ?></p>
    <p>2: <?= $_SESSION["score2"] ?></p>
    <p>3: <?= $_SESSION["score3"] ?></p>
    <p>4: <?= $_SESSION["score4"] ?></p>
    <p>5: <?= $_SESSION["score5"] ?></p>
    <p>6: <?= $_SESSION["score6"] ?></p>
    <p>Bonus: <?= $_SESSION["bonus"] ?></p>
    <p>Total: <?= $_SESSION["score"] ?></p>
</div>
