<?php if(!$gjennomIndex) die("Access denied.");

$knr = $_REQUEST['knr'];

$db = new sql();
$resultat = $db->query("DELETE FROM webprosjekt_kunde WHERE KNr = '$knr';");
if(!$resultat)
{
    $db->close();
    echo "<h2>Kan ikke slette kunde</h2>";
    echo "<p>Kan ikke slette kunde fra databasen siden det eksisterer ordre på denne kunden. Gå <a href='index.php?side=admin_kunder'>tilbake til kunder.</a></p>";
}
else
{
    if($db->affected_rows == 0)
        die("<p>Feil - finner ikke kunde i databasen (010)</p>");
    $db->close();

    echo "<h2>Kunde slettet</h2>";
    echo "<p>Kunden er nå slettet. Gå <a href='index.php?side=admin_kunder'>tilbake til kunder.</a></p>";
}
?>