<?php if(!$gjennomIndex) die("Access denied.");?>

<h3>Mine ordre</h3>

<?php

$ordrenummer = $kunde->getAlleOrdre();
if(count($ordrenummer) == 0)
    echo "<p>Du har ingen eksisterengde ordre.</p>";
else
{
    echo "<table><tr><th>Ordrenummer</th><th>Ordredato</th><th>Ordrebeløp</th></tr>";

    foreach ($ordrenummer as $value)
    {
        $ordre = new Ordre($value);
        echo "<tr><td><a href='index.php?side=ordreoversikt&amp;o=".$ordre->getOrdreNr()."'>".$ordre->getOrdreNr()."</td>
                <td>".$ordre->getOrdreDato()."</td><td>".number_format($ordre->getOrdretotal()+$ordre->getFraktsum(),2,',','.')."</td></tr>";
    }
    
    echo "</table>";
}
?>