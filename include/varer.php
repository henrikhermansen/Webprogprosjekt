<?php
$kategori = $_REQUEST['kat'];
$katnavn;

switch ($kategori)
{
    case 0: $katnavn = "Alle kategorier";
            break;
    case 1: $katnavn = "Speilreflekskamera";
            break;
    case 2: $katnavn = "Superzoomkamera";
            break;
    case 3: $katnavn = "Kompaktkamera";
            break;
    case 4: $katnavn = "Undervannskamera";
            break;
    case 5: $katnavn = "Objektiv";
            break;
    case 6: $katnavn = "Tilbehør";
            break;
}

echo "<h2>".$katnavn."</h2>";

?>