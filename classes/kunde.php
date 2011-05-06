<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Kunde extends BasicKunde
{
	private $utlogging,$sessionExpire;

	function __construct()
	{ $this->sessionExpire=60*30; }

	function login($epost,$passord)
	{
		$db=new sql();
		$passord=renStreng($passord,$db);
		$epost=renStreng($epost,$db);
		$brukerinfo=$db->query("SELECT * FROM webprosjekt_kunde WHERE Epost='$epost'");
		$rows=$db->affected_rows;
		$db->close();
		if($rows==0)
			return false;
		$brukerinfo=$brukerinfo->fetch_assoc();
		if($brukerinfo['Passord']!=cryptPass($passord,$brukerinfo['KNr'].$epost))
		   return false;
		$this->KNr=$brukerinfo['KNr'];
		$this->fornavn=$brukerinfo['Fornavn'];
		$this->etternavn=$brukerinfo['Etternavn'];
		$this->adresse=$brukerinfo['Adresse'];
		$this->postnr=$brukerinfo['PostNr'];
		$this->poststed=sjekkPostnr($this->postnr);
		$this->telefonnr=$brukerinfo['Telefonnr'];
		$this->epost=$brukerinfo['Epost'];
		$this->passord=$brukerinfo['Passord'];
		$this->utlogging=time()+$this->sessionExpire;
		return true;
	}

	function refreshSession()
	{
	   if(time()>$this->utlogging)
	      return false;
		$this->utlogging=time()+$this->sessionExpire;
		return true;
	}

	function endreKunde($fornavn,$etternavn,$adresse,$postnr,$telefonnr)
	{
	   $db=new sql();
		$error['fornavn']=$this->setFornavn(renStreng($fornavn,$db));
		$error['etternavn']=$this->setEtternavn(renStreng($etternavn,$db));
		$error['adresse']=$this->setAdresse(renStreng($adresse,$db));
		$error['postnr']=$this->setPostnr(renStreng($postnr,$db),$db);
		$error['telefonnr']=$this->setTelefonnr(renStreng($telefonnr,$db));
		$db->close();
		return $error;
	}

	function lagreKunde()
	{
	   $KNr=$this->KNr;
	   $fornavn=$this->fornavn;
	   $etternavn=$this->etternavn;
	   $adresse=$this->adresse;
	   $postnr=$this->postnr;
	   $telefonnr=$this->telefonnr;

		$db=new sql();
		$resultat=$db->query("UPDATE webprosjekt_kunde SET Fornavn='$fornavn',Etternavn='$etternavn',Adresse='$adresse',Postnr='$postnr',Telefonnr='$telefonnr' WHERE KNr='$KNr'");
		$errno=$db->errno;
		$rows=$db->affected_rows;
		$db->close();
		if($errno==0 && $rows==1)
		   return 1;
		if($errno==0 && $rows==0)
		   return 0;
		if($errno!=0)
		   return -1;
		return -2;
	}

	function endrePassord($gammelt,$nytt1,$nytt2)
	{
	   $db=new sql();
	   $gammelt=renStreng($gammelt,$db);
	   $nytt1=renStreng($nytt1,$db);
	   $nytt2=renStreng($nytt2,$db);
	   $db->close();
		$gammelt=cryptPass($gammelt,$this->KNr.$this->epost);
		if($gammelt!=$this->passord)
		   return "<p class=\"feilmelding\">Feil nåværende passord.</p>";
		if($nytt1!=$nytt2)
         return "<p class=\"feilmelding\">Passordene du skrev var ikke like.</p>";
		if(strlen($nytt1)<6)
		   return "<p class=\"feilmelding\">Passordet må være minst 6 tegn.</p>";

		$nytt=cryptPass($nytt1,$this->KNr.$this->epost);
		if($gammelt==$nytt)
		   return "<p class=\"okmelding\">Passordet har blitt endret.</p>";
		$db=new sql();
		$KNr=$this->KNr;
		$resultat=$db->query("UPDATE webprosjekt_kunde SET Passord='$nytt' WHERE KNr='$KNr'");
		$errno=$db->errno;
		$rows=$db->affected_rows;
		$db->close();
		if($errno==0 && $rows==1)
		{
		   $this->passord=$nytt;
		   $_SESSION['kunde']=serialize($this);
		   return "<p class=\"okmelding\">Passordet har blitt endret.</p>";
		}
		if($errno==0 && $rows==0)
		   return "<p class=\"feilmelding\">Vi beklager! En ukjent feil har oppstått ved endring av passord. (EP01)</p>";
		if($errno!=0)
		   return "<p class=\"feilmelding\">Vi beklager! En feil har oppstått ved endring av passord. (EP02)</p>";
		return "<p class=\"feilmelding\">Vi beklager! En ukjent feil har oppstått ved endring av passord. (EP03)</p>";
	}

        function getAlleOrdre()
        {
            $db = new sql();
            $resultat = $db->query("SELECT OrdreNr FROM webprosjekt_ordre WHERE KNr = '$this->KNr' ORDER BY OrdreDato DESC;");
            $rader = $db->affected_rows;
            $db->close();
            $ordrenummer;
            while($rad = $resultat->fetch_assoc())
                $ordrenummer[] = $rad['OrdreNr'];
            return $ordrenummer;
        }
}

?>