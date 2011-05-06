<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Glemt passord?</h2>

<p>Hvis du har glemt passordet ditt kan vi sende deg et nytt automatisk generert
passord til epost-adressen du har oppgitt.</p>
<p>Passordet kan endres etter du har logget inn.</p>

<?php
$sendt = false;

if(isset($_POST['send']))
{
    $epost = $_POST['epost'];
    $postnr = $_POST['postnr'];

    if($epost == "" || $postnr == "")
        echo "<p class=\"feilmelding\">Fyll ut begge felt.</p>";
    else
    {
        $db = new sql();
        $epost = renStreng($epost, $db);
        $postnr = renStreng($postnr, $db);
        $resultat = $db->query("SELECT KNr, Epost, PostNr FROM webprosjekt_kunde WHERE Epost = '$epost';");
        if(!$resultat)
            die("<p class=\"feilmelding\">Feil - Kunne ikke koble til databasen (011)");
        if($db->affected_rows == 0)
            echo "<p class=\"feilmelding\">Epost-adressen eksisterer ikke.</p>";
        else
        {
            $resultat = $resultat->fetch_assoc();
            if($resultat['PostNr'] != $postnr)
                echo "<p class=\"feilmelding\">Feil kombinasjon av epost og postnummer.</p>";
            else
            {
                $sendt = true;
                $KNr = $resultat['KNr'];
                $passord=genPassord();
                $dbPassord=cryptPass($passord,$KNr.$epost);
                $resultat=$db->query("UPDATE webprosjekt_kunde SET Passord='$dbPassord' WHERE KNr='$KNr'");
		if($db->affected_rows == 0)
			die("<p class=\"feilmelding\">Ukjent databasefeil (012)</p>");
		$db->close();

                $emne="Nytt passord i Nettbutikken";
                $tekst="Hei\r\n\r\n".
                "Du har nå blitt tildelt nytt passord i nettbutikken.\r\n\r\n".
                "Her er din innloggingsinformasjon:\r\n".
                "Brukernavn: $epost \r\n".
                "Passord: $passord \r\n\r\n".
                "For å logge inn, gå til http://nettbutikk.henrikh.net/ \r\n".
		"Du kan selvsagt bytte passord når du har logget inn.\r\n\r\n".
                "Hilsen,\r\nHiranBårdHenrikLars.";
		$hode = 'From: nettbutikk@henrikh.net' . "\r\n".
		'Reply-To: nettbutikk@henrikh.net' . "\r\n".
		'Content-type: text/plain; charset=iso-8859-1' . "\r\n".
		'X-Mailer: PHP/' . phpversion();

		$resultat = @mail($epost, $emne, $tekst, $hode);

		if($resultat)
		   echo "<p class=\"okmelding\">Du har nå fått tilsendt et nytt passord på e-post til $epost.</p>".
			"<p>Du kan nå <a href=\"index.php?side=logginn\">logge inn</a>.</p>";
		else
		   echo "<p class=\"okmelding\">Du har nå fått generert et nytt passord.<br>".
                        "Passord: $passord </p>".
                        "<p>Du kan nå <a href=\"index.php?side=logginn\">logge inn</a>.</p>";
            }
        }
    }
}

if(!$sendt)
{ ?>
<form action="" method="POST">
<p>
	<label for="epost">E-post</label>
	<span><input type="text" name="epost" maxlength="100" required></span>
</p>
<p>
	<label for="passord">Postnummer</label>
	<span><input type="text" name="postnr" maxlength="4" required></span>
</p>
<p>
	<input type="submit" name="send" value="Send nytt passord">
</p>
</form>
<?php } ?>