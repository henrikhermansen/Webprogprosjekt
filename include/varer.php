<?php if(!$gjennomIndex) die("Access denied.");?>

<?php
$kategori = $_REQUEST['kat'];
$katnavn;

if($kategori == 0)
{
    $katnavn = "Alle kategorier";
}
else
{
    $db = new sql();
    $resultat = $db->query("SELECT * FROM webprosjekt_kategori where KatNr='$kategori';");
    if($db->affected_rows == 0)
            die("Feil (B03)");
    while($rad = $resultat->fetch_assoc())
            if(!$katnavn=$rad["Navn"])
                echo"Kategorien finnes ikke";
    $db->close();
}

echo "<h2>".$katnavn."</h2>";

if(isset($_POST["leggtilhandlekurv"]))
	echo $handlekurv->leggTilVare($_POST['vnr'],$_POST['antall']);

$vareliste = getVarer($kategori);

if(count($vareliste) == 0)
    echo "<p>Det finnes ingen varer i denne kategorien.</p>";
else
    foreach ($vareliste as $varer)
    {
        $bildeurl = $varer[0];
        $vnr = $varer[1];
        $varenavn = substr($varer[2], 0, 50);
        $beskrivelse_substring = substr($varer[3], 0, 240);
        $beskrivelse = str_replace("<br/>", " ", $beskrivelse_substring);
        $pris = (number_format($varer[4],2,',','.'));

        if(!is_file($bildeurl))
           $bildeurl = "images/noimage.gif";
        echo "<div class='varebilde'><img src='$bildeurl' alt='$varenavn' height='100' /></div>
                <div class='varetekst'>
                <h3><a href='index.php?side=vareinfo&amp;vnr=".$vnr."'>$varenavn</a></h3>
                <p>$beskrivelse...</p>
                </div>
                <div class='pris'><p><b>$pris</b></p><br/>
                <form class='leggtilvare' action='' method='post' >
                    <input type='hidden' name='vnr' value='$vnr' >
                    <input type='text' name='antall' value=1 maxlength=4 />
                    <input type='submit' name=leggtilhandlekurv value='Legg til' />
                </form>
                </div>";
        echo "<hr/>";
    }
?>

