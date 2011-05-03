<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class NyKunde extends BasicKunde
{
	private $feilmeldinger;

	function __construct($fornavn,$etternavn,$adresse,$postnr,$telefonnr,$epost)
	{
		$db=new sql();
		$error['fornavn']=$this->setFornavn(renStreng($fornavn,$db));
		$error['etternavn']=$this->setEtternavn(renStreng($etternavn,$db));
		$error['adresse']=$this->setAdresse(renStreng($adresse,$db));
		$error['postnr']=$this->setPostnr(renStreng($postnr,$db),$db);
		$error['telefonnr']=$this->setTelefonnr(renStreng($telefonnr,$db));
		$error['epost']=$this->setEpost(renStreng($epost,$db),$db);
		$db->close();
		$this->feilmeldinger=$error;
	}
	
	function getFeilmeldinger()	{ return $this->feilmeldinger; }

	function regKunde()
	{
	   $fornavn=$this->fornavn;
	   $etternavn=$this->etternavn;
	   $adresse=$this->adresse;
	   $postnr=$this->postnr;
	   $telefonnr=$this->telefonnr;
	   $epost=$this->epost;

		$db=new sql();
		$resultat=$db->query("INSERT INTO webprosjekt_kunde (Fornavn,Etternavn,Adresse,PostNr,Telefonnr,Epost,Passord)"
									." VALUES('$fornavn','$etternavn','$adresse','$postnr','$telefonnr','$epost','temporary')");
		$KNr=$db->insert_id;
		if($db->affected_rows<1)
		   return"<p class=\"feilmelding\">Databasefeil ved registrering av ny bruker. Vennligst forsøk på nytt eller ta kontakt med supporten. (Errno NK01)</p>";
	   $passord=genPassord();
	   $passord="testpassord"; // FJERNES NÅR BRUKEREN KAN ENDRE PASSORD!
	   $dbPassord=cryptPass($passord,$KNr.$epost);
	   $resultat=$db->query("UPDATE webprosjekt_kunde SET Passord='$dbPassord' WHERE KNr='$KNr'");
		if($db->affected_rows<1)
			return"<p class=\"feilmelding\">Databasefeil ved registrering av ny bruker. Vennligst forsøk på nytt eller ta kontakt med supporten. (Errno NK02)</p>";
		$db->close();

	   $emne="Registrering i Nettbutikken";
	   $tekst="Hei\r\n\r\n".
	      "Din nye bruker i HBHL nettbutikk er nå registrert.\r\n\r\n".
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
		   return"<p class=\"okemlding\">Brukeren din har nå blitt opprettet. Brukernavn og passord er sendt på e-post til $epost.</p>".
				"<p>Du kan nå <a href=\"index.php?side=logginn\">logge inn</a>.</p>";
		else
		   return"<p class=\"okmelding\">Brukeren din har nå blitt opprettet.</p>".
		      "<p>Her er din innloggingsinformasjon:<br>".
		      "Brukernavn: $epost <br>".
		      "Passord: $passord </p>".
		      "<p>Du kan nå <a href=\"index.php?side=loghinn\">logge inn</a>.</p>";
	}
}

?>