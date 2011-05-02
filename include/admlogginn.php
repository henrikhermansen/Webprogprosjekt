<script type="text/javascript">
    function valider_alle()
    {
        if(document.alogin.bnavn.value != "" && document.alogin.pord.value != "")
            return true;
        document.getElementById("feilmelding").innerHTML = "Fyll ut begge felt";
        return false;
    }
</script>

<h2>Logg inn som administrator:</h2>

<?php

// Brukernavn: sjefen
// Passord: svaktpassord

if(!isset($_POST['knapp']))
echo
'<form name="alogin" action="" method="post">
    <span style="display: inline-block; width:5em">Brukernavn:</span><input type="text" name="bnavn" /><br/>
    <span style="display: inline-block; width:5em">Passord:</span><input type="password" name="pord" /><br/>
    <br/>
    <input type="submit" name="knapp" value="Logg inn" onClick="return valider_alle()" />
    <div id="feilmelding" style="color: #ff0000;"></div>
</form>';
else
{
    $bnavn = $_POST['bnavn'];
    $pord = $_POST['pord'];

    if($bnavn == "" || $pord == "")
        die("<p>Begge felter må fylles ut</p>");

    $admin = new Admin();

    if(!$admin->login($bnavn, $pord))
        die("<p>Feil kombinasjon av brukernavn og passord</p>");

    echo "<p>Du er nå logget inn som ".$bnavn.".</p>";
}
?>