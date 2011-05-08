<?php
if(!$gjennomIndex) die("Access denied.");
$vnr = $_REQUEST['vnr'];

//Henter ut info om vare
$Vare = new Vare($vnr);
$Varenavn = $Vare->getVarenavn();
$Pris = $Vare->getPris();
$Beskrivelse = $Vare->getBeskrivelse();
$Bilde = $Vare->getBilde();
if(!is_file($Bilde))
    $Bilde = "images/noimage.gif";
$KatNr = $Vare->getKatNr();
$Antall = $Vare->getAntall();

//for å legge til i handlekurv
if(isset($_POST["leggtilhandlekurv"]))
	echo $handlekurv->leggTilVare($_POST['vnr'],$_POST['antall']);

//Skriver ut vareinfo
echo "<h2>".$Varenavn."</h2>";
echo "<img src='$Bilde' alt='$Varenavn' width='200' height='200' class='vareinfobilde' />";
echo $Beskrivelse;
echo "<div class='vareinfopris'><br/><b>Pris: ".number_format($Pris,2,',','.')."</b><br/><br/>";
echo "Varenummer:  ".$vnr."<br/>";
echo "P&aring lager:  ".$Antall." stk<br/><br/>";
echo "<form action='' method='post' >
        <input type='hidden' name='vnr' value='$vnr' >
        <input type='text' name='antall' value=1 maxlength=4 />
        <input type='submit' name=leggtilhandlekurv value='Legg til' />
    </form></div>";
?>
