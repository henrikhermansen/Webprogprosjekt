<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Kunde extends BasicKunde
{
	private $utlogging,$sessionExpire,$feilmeldinger;

	function __construct()
	{ $this->sessionExpire=60*30;$this->feilmeldinger=array(); }

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
		if($brukerinfo['Passord']!=cryptPass($passord,$brukerinfo['KNr'].$epost)) // Denne linjen skal settes inn igjen når vi begynner med krypterte passord!
		//if($brukerinfo['Passord']!=$passord)                     // Denne linjen skal FJERNES
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

	/*function endreBruker($fornavn, $etternavn, $epost, $telefon)
	{
	   $db=new sqlConnection();
		$error['fornavn']=$this->setFornavn(trim(mysql_real_escape_string($fornavn,$db->getLink())));
		$error['etternavn']=$this->setEtternavn(trim(mysql_real_escape_string($etternavn,$db->getLink())));
		$error['epost']=$this->setEpost(trim(mysql_real_escape_string($epost,$db->getLink())),$db);
		$error['telefon']=$this->setTelefon(trim(mysql_real_escape_string($telefon,$db->getLink())));
		$db->close();
		unset($db);
		return $error;
	}

	function lagreBruker()
	{
	   $id=$this->id;
	   $fornavn=$this->fornavn;
	   $etternavn=$this->etternavn;
	   $epost=$this->epost;
	   $telefon=$this->telefon;

		$db=new sqlConnection();
		$resultat=$db->update("brukere","fornavn='$fornavn',etternavn='$etternavn',epost='$epost',telefon='$telefon'","id=$id");
		$db->close();
		if(!(is_bool($resultat) && $resultat==true))
			return false;
		return true;
	}

	function endrePassord($gammelt,$nytt,$nytt2)
	{
	   $db=new sqlConnection();
	   $gammelt=trim(mysql_real_escape_string($gammelt,$db->getLink()));
	   $nytt=trim(mysql_real_escape_string($nytt,$db->getLink()));
	   $nytt2=trim(mysql_real_escape_string($nytt2,$db->getLink()));
	   $db->close();
		$kryptGammelt=new CryptPass($gammelt,$this->etternavn.$this->fornavn);
		if($kryptGammelt->getPass()!=$this->passord)
		   return "<span class=\"skjemafeil\">Feil nåværende passord.</span>";
		if($nytt!=$nytt2)
         return "<span class=\"skjemafeil\">Passordene du skrev var ikke like.</span>";
		if(!(strlen($nytt)>=6))
		   return "<span class=\"skjemafeil\">Passordet må være på minst 6 tegn.</span>";

		$kryptNytt=new CryptPass($nytt,$this->etternavn.$this->fornavn);
		$db=new sqlConnection();
		$resultat=$db->update("brukere","passord='".$kryptNytt->getPass()."'","id=".$this->id);
		if(!(is_bool($resultat) && $resultat==true))
			return "<span class=\"skjemafeil\">Databasefeil ved lagring av nytt passord. Vennligst prøv igjen eller kontakt Henrik.</span>";
		$this->passord=$kryptNytt->getPass();
		$_SESSION['bruker']=serialize($this);
		return "<span class=\"skjemaOk\">Passordet ditt ble endret.</span>";
	}*/

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