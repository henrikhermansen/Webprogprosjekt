<?php if(!$gjennomIndex) die("Access denied.");?>

<h1>Logg ut</h1>

<? unset($_SESSION['kunde']);session_unset(); ?>

<p>Du er n� logget ut.</p>