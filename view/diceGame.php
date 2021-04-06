<h1><?= $header ?></h1>
<p><?= $message ?></p>

<?php

if (!isset($_SESSION["score"])) {
      $_SESSION["score"] = 0;
}
if (!isset($_SESSION["user"])) {
      $_SESSION["user"] = 0;
}
if (!isset($_SESSION["computer"])) {
      $_SESSION["computer"] = 0;
}
if (!isset($_SESSION["compScore"])) {
      $_SESSION["compScore"] = 0;
}
$_SESSION["score"] ?? 0;
$_SESSION["user"] ?? 0;
$_SESSION["computer"] ?? 0;
$_SESSION["compScore"] ?? 0;

$_SESSION["score"] += (int)$sum;
$total = $_SESSION["score"];
if ($total > 21) {
    $status = "Your score: " . $total . "<br> You lost!";
    $_SESSION["computer"] += 1;
} else if ($total === 21) {
    $status = "Your score: " . $total . "<br>Congratulations, you won!";
    $_SESSION["user"] += 1;
} else {
    $status = "Total score: " . $total;
}?>

<p><?= $sum ?></p>
<p><?= $status ?></p>



<form action="dice" method="post">
    <input type="submit" name="action" value="Roll again">
</form>
<br>
<form action="dice" method="post">
    <input type="hidden" name="score" value="<?= $total ?>">
    <input type="submit" name="action" value="Stop">
</form>
<br>
<form action="dice" method="post">
    <input type="submit" name="action" value="New round">
</form>

<h2>Rounds won:</h2>
<p>You: <?= $_SESSION["user"] ?></p>
<p>Computer: <?= $_SESSION["computer"] ?></p>

<form action="dice" method="post">
    <input type="submit" name="action" value="Start over">
</form>
<br>
