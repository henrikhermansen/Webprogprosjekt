<?php if(!$gjennomIndex) die("Access denied.");?>

<h1>Logg ut</h1>

<?php
unset($_SESSION['kunde']);
unset($_SESSION['admin']);
?>

<p>Du er n� logget ut.</p>