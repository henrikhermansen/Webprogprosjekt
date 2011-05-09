<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Varer</h2>

<p><a href="index.php?side=admin_legg_til_ny_vare">Legg til ny vare</a></p>

<table>
	<tr>
	   <th>VareNr</th>
	   <th>Varenavn</th>
	   <th>Pris</th>
	   <th>På lager</th>
	   <th>&nbsp;</th>
	</tr>
<?php
$vareliste = getVarer();

if(!$vareliste)
    echo "<p>Det finnes ingen varer i databasen.</p>";
else
    foreach ($vareliste as $varer)
    {
        $vnr = $varer[1];
        $varenavn = substr($varer[2], 0, 50);
        $pris = (number_format($varer[4],2,',','.'));
        $antall=$varer[5];
        echo "<tr><td>$vnr</td><td>$varenavn</td><td>$pris</td><td>$antall</td><td><a href=\"index.php?side=admin_endrevare&amp;vnr=$vnr\">Endre</a></td></tr>\n";
    }
?>
</table>