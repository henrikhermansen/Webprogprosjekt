<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Min konto</h2>

<p id="minkontomeny">
    <a href="index.php?side=minkonto&amp;kontoside=oversikt">Oversikt</a>
    <a href="index.php?side=minkonto&amp;kontoside=ordre">Mine ordre</a>
    <a href="index.php?side=minkonto&amp;kontoside=endrekonto">Endre kontoinformasjon</a>
</p>

<?php
if(isset($_REQUEST['kontoside']))
{
    $kontoside = str_replace("/","",$_REQUEST['kontoside']);
    switch ($kontoside)
    {
        case oversikt:  include "include/minkonto_oversikt.php";
                        break;
        case ordre:     include "include/minkonto_ordre.php";
                        break;
        case endrekonto: include "include/minkonto_endrekonto.php";
                        break;
    }
}
else
    include "include/minkonto_oversikt.php";
?>