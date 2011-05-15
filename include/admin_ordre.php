<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Ordre</h2>

<?php

$db = new sql();
$resultat = $db->query("SELECT OrdreNr FROM webprosjekt_ordre ORDER BY OrdreDato DESC;");
if(!$resultat)
    die("<p>Feil - kunne ikke koble til databasen (006)</p>");
$db->close();
$ordrenummer;
while($rad = $resultat->fetch_assoc())
    $ordrenummer[] = $rad['OrdreNr'];

if(count($ordrenummer) == 0)
    echo "<p>Du har ingen eksisterengde ordre.</p>";
else
{
    echo "<table><tr><th>Ordrenummer</th><th>Kunde</th><th>Ordredato</th><th>Ordrebeløp</th></tr>";

    foreach ($ordrenummer as $value)
    {
        $ordre = new Ordre($value);
        echo "<tr><td><a href='index.php?side=admin_ordreoversikt&amp;o=".$ordre->getOrdreNr()."'>".$ordre->getOrdreNr()."</td>
                <td>".$ordre->getKundenavn()."</td><td>".$ordre->getOrdreDato()."</td><td>".number_format($ordre->getOrdretotal()+$ordre->getFraktsum(),2,',','.')."</td></tr>";
    }

    echo "</table>";
}

?>