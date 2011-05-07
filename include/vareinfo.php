<?php
if(!$gjennomIndex) die("Access denied.");
$vnr = $_REQUEST['vnr'];

$db = new sql();
$resultat = $db->query("SELECT * FROM webprosjekt_vare where KatNr='$vnr';");
if($db->affected_rows == 0)
        die("Feil (B04)");
while($rad = $resultat->fetch_assoc())
        if(!$katnavn=$rad["Navn"])
            echo"Kategorien finnes ikke";
$db->close();

//for å legge til i handlekurv
if(isset($_POST["leggtilhandlekurv"]))
	echo $handlekurv->leggTilVare($_POST['vnr'],$_POST['antall']);


?>
