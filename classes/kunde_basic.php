<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class BasicKunde
{
	protected $KNr, $fornavn, $etternavn, $adresse, $postnr, $poststed, $telefonnr, $epost, $passord;

	function setFornavn($navn)
	{
		if(!preg_match("/^\b[a-zæøå ]{2,45}\b$/i",$navn))
         return "Fornavn kan kun inneholde bokstaver. Minst to og maks 45.";
		$this->fornavn=$navn;
		return null;
	}

	function setEtternavn($navn)
	{
		if(!preg_match("/^\b[a-zæøå ]{2,45}\b$/i",$navn))
			return "Etternavn kan kun inneholde bokstaver. Minst to og maks 45.";
		$this->etternavn=$navn;
		return null;
	}
	
	function setAdresse($adresse)
	{
		if(!preg_match("/^\b[a-zæøå0-9. ]{2,100}\b$/i",$adresse))
			return "Adresse kan kun inneholde bokstaver, tall, mellomrom og punktum. 2-100 tegn.";
		$this->adresse=$adresse;
		return null;
	}
	
	function setPostnr($postnr,$db)
	{
		if(!preg_match("/^\b\d{4}\b$/i",$postnr))
			return "Postnummer må bestå av 4 siffer.";
		$poststed=sjekkPostnr($postnr);
		if($poststed=="Ugyldig postnummer")
		   return "Ugyldig postnummer.";
		$this->poststed=$poststed;
		$this->postnr=$postnr;
		return null;
	}

	function setTelefonnr($tlf)
	{
		if(!preg_match("/^\b\d{8}\b$/",$tlf))
		   return "Telefonnummer må bestå av 8 siffer.";
		$this->telefonnr=$tlf;
		return null;
	}

	function setEpost($epost,$db)
	{
		$sjekkEpost=$db->query("SELECT COUNT(Epost) FROM webprosjekt_kunde WHERE Epost='$epost'");
		$sjekkEpost=$sjekkEpost->fetch_row();
		if($sjekkEpost[0]>0 && $epost!=$this->epost)
		   return "E-postadressen er allerede registrert.";
		if(!preg_match("/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i",$epost))
			return "Feil format på e-postadressen.";
	   if(strlen($epost)>100)
	      return "E-postadressen kan maks inneholde 100 tegn.";
		$this->epost=$epost;
		return null;
	}
	
	function getInfo()
	{
		return array(
		"KNr"=>$this->KNr,
		"fornavn"=>$this->fornavn,
		"etternavn"=>$this->etternavn,
		"adresse"=>$this->adresse,
		"postnr"=>$this->postnr,
		"poststed"=>$this->poststed,
		"telefonnr"=>$this->telefonnr,
		"epost"=>$this->epost);
}
	
	function getFornavn()	{ return $this->fornavn; }
	function getEtternavn()	{ return $this->etternavn; }
	function getNavn()		{ return $this->fornavn." ".$this->etternavn; }
	function getAdresse()	{ return $this->adresse; }
	function getPostnr()		{ return $this->postnr; }
	function getPoststed()	{ return $this->poststed; }
	function getTelefonnr()	{ return $this->telefonnr; }
	function getEpost()		{ return $this->epost; }

	function getKNr()			{ return $this->KNr; }
	function getUtlogging()	{ return $this->utlogging; }

	function glemtPassord($epost,$postnr)
	{
		if($epost == "" || $postnr == "")
			return "<p class=\"feilmelding\">Fyll ut begge felt.</p>";
		else
		{
			$db = new sql();
			$epost = renStreng($epost, $db);
			$postnr = renStreng($postnr, $db);
			$resultat = $db->query("SELECT KNr FROM webprosjekt_kunde WHERE Epost = '$epost' AND Postnr = '$postnr';");
			if(!$resultat)
				return "<p class=\"feilmelding\">Feil - Kunne ikke koble til databasen (011)";
			if($db->affected_rows == 0)
				return "<p class=\"feilmelding\">Feil kombinasjon av epost og postnummer.</p>";
			else
			{
			   $resultat=$resultat->fetch_assoc();
				$KNr = $resultat['KNr'];
				$passord=genPassord();
				$dbPassord=cryptPass($passord,$KNr.$epost);
				$resultat=$db->query("UPDATE webprosjekt_kunde SET Passord='$dbPassord' WHERE KNr='$KNr'");
				if($db->affected_rows == 0)
					return "<p class=\"feilmelding\">Ukjent databasefeil (012)</p>";
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
					return "<p class=\"okmelding\">Du har nå fått tilsendt et nytt passord på e-post til $epost.</p>".
					"<p>Du kan nå <a href=\"index.php?side=logginn\">logge inn</a>.</p>";
				else
					return "<p class=\"okmelding\">Du har nå fått generert et nytt passord.<br>".
					"Passord: $passord </p>".
					"<p>Du kan nå <a href=\"index.php?side=logginn\">logge inn</a>.</p>";
			}
		}
    }
}

?>