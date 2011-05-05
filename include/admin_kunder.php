<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Kunder</h2>

<?php

$db = new sql();
$resultat = $db->query("SELECT * FROM webprosjekt_kunde;");
if(!$resultat)
    die("<p>Feil - kunne ikke koble til databasen (009)</p>");
if($db->affected_rows == 0)
    die("<p>Ingen kunder i databasen</p>");
$db->close();
$kunder;
while($rad = $resultat->fetch_assoc())
{
    $kundelinje = array($rad['KNr'],$rad['Fornavn'],$rad['Etternavn'],$rad['Adresse'],$rad['PostNr'],$rad['Telefonnr'],$rad['Epost']);
    $kunder[] = $kundelinje;
}

if(count($kunder) == 0)
    echo "<p>Det eksisterer ingen kunder i databasen</p>";
else
{
    echo "<table><tr><th>Kundenr</th><th>Navn</th><th>Adresse</th><th>Postnummer og sted</th><th>Telefonnr</th><th>E-post</th><th></th></tr>";

    foreach ($kunder as $kundelinje)
    {
        echo "<tr>";
        echo "<td>$kundelinje[0]</td>";
        echo "<td>$kundelinje[1] $kundelinje[2]</td>";
        echo "<td>$kundelinje[3]</td>";
        echo "<td>$kundelinje[4] ".  sjekkPostnr($kundelinje[4])."</td>";
        echo "<td>$kundelinje[5]</td>";
        echo "<td>$kundelinje[6]</td>";
        echo "<td><a href='index.php?side=slettkunde&amp;knr=$kundelinje[0]'>Slett</a><td>";
        echo "</tr>";
    }
    echo "</table>";
}

?>