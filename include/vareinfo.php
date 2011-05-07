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

//Skriver ut vareinfo
echo "Varenummer:  ".$vnr."<br/>";
echo "<div class='Vareinfonavn'><h2>".$Varenavn."</h2></div>";
echo "<div class='infotab'><div class='Vareinfobilde'><img src='$Bilde' alt='$Varenavn' width='200' height='200' /></div>";
echo "<div class='vareinfoinfo'><b>Pris:  ".$Pris." NOK<br/></b>";
echo "P&aring lager:  ".$Antall." stk<br/>";
echo "<form action='' method='post' >
        <input type='hidden' name='vnr' value='$vnr' >
        <input type='text' name='antall' value=1 maxlength=4 />
        <input type='submit' name=leggtilhandlekurv value='Legg til' />
    </form></div></div>";
echo "<div class='vareinfobeskrivelse'><b>Beskrivelse:</b><br/>".$Beskrivelse."</div>";

//for å legge til i handlekurv
if(isset($_POST["leggtilhandlekurv"]))
	echo $handlekurv->leggTilVare($_POST['vnr'],$_POST['antall']);

?>
