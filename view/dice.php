<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

?>
<h1><?= $header ?></h1>
<p><?= $message ?></p>

<p class="dice-utf8">
<?php foreach ($class as $value) : ?>
    <i class="<?= $value ?>"></i>
<?php endforeach; ?>
</p>

<form action="dice" method="post">
    <input type="radio" name="dices" value="1" required>
    <label for="dices">1</label>
    <input type="radio" name="dices" value="2" required>
    <label for="dices">2</label>
    <input type="submit" name="action" value="start">
</form>
