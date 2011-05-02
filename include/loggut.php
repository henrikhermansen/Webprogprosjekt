<?php if(!$gjennomIndex) die("Access denied.");?>

<h1>Logg ut</h1>

<? unset($_SESSION['kunde']);session_unset(); ?>

<p>Du er nå logget ut.</p>