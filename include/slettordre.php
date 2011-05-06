<?php if(!$gjennomIndex) die("Access denied.");

$ordrenr = $_REQUEST['o'];
$ordre = new Ordre($ordrenr);
$ordre->slettOrdre();

echo "<h2>Ordre slettet</h2>";
echo "<p>Ordren er nå slettet. Gå <a href='index.php?side=admin_ordre'>tilbake til ordre.</a></p>";
?>
