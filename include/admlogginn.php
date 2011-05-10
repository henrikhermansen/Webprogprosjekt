<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Logg inn som administrator</h2>
<div id="feilmelding"></div>
<?php
$innlogget = false;

// Brukernavn: sjefen
// Passord: svaktpassord

if(isset ($_POST['knapp']))
{
    $bnavn = $_POST['bnavn'];
    $pord = $_POST['pord'];
    $admin = new Admin();

    if($bnavn == "" || $pord == "")
        echo "<p class=\"feilmelding\">Fyll ut begge feltene</p>";
    else if(!$admin->login($bnavn, $pord))
        echo "<p class=\"feilmelding\">Feil kombinasjon av brukernavn og passord</p>";
    else
    {
        $innlogget = true;
        $_SESSION['admin'] = serialize($admin);
        echo "<p>Du er nå logget inn som ".$bnavn.", og kan <a href=\"index.php\">gå videre til nettbutikken.</a></p>";
    }
}

if(!$innlogget)
{?>
<form name="alogin" action="" method="post">
    <p><label for="bnavn">Brukernavn</label><input type="text" name="bnavn" id="bnavn" /></p>
    <p><label for="pord">Passord</label><input type="password" name="pord" id="pord" /></p>
    <p><input type="submit" name="knapp" value="Logg inn" onClick="return valider_alle()" /></p>
</form>
<?php }

?>