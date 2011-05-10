<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Vare
{
    private $VNr,$Varenavn,$Pris, $Beskrivelse, $Bilde, $KatNr, $Antall;
    /**
     * Konstruktør for å legge til vare og hente ut info om vare med gitt varenummer.
     *
     */
    
    function  __construct($VNr = false)
    {
        if($VNr != false)
        {
            $db = new sql();
            $resultat = $db->query("SELECT * FROM webprosjekt_vare WHERE VNr = '$VNr';");
            $rader = $db->affected_rows;
            $db->close();
            if($rader == 0)
                die("Feil - finner ikke vare i databasen (B06)");
            $resultat = $resultat->fetch_assoc();
            $this->VNr = $resultat['VNr'];
            $this->Varenavn = $resultat['Varenavn'];
            $this->Pris = $resultat['Pris'];
            $this->Beskrivelse = $resultat['Beskrivelse'];
            $this->Bilde = $resultat['Bilde'];
            $this->KatNr = $resultat['KatNr'];
            $this->Antall = $resultat['Antall'];
        }
    }

    function setVarenavn($navn)
    {
        if(!preg_match("/^[a-zæøå0-9 .,:;\-\_\+\(\)\/\&\\\ ]{2,100}$/i", $navn))
                return "Varenavn kan kun inneholde bokstaver, tall, mellomrom, og (.,:;-+/\&), og må være mellom 2-100 tegn.";
        $this->Varenavn = $navn;
        return null;
    }

    function setPris($pris)
    {
        if(!preg_match("/^[0-9.]+$/",$pris))
            return "Pris må bestå av kun siffer 0-9 og punktum som desimalseparator.";

        $this->Pris = $pris;
    }

    function setBeskrivelse($beskrivelse)
    {
        if($beskrivelse == "")
            return "Skriv noe i varebeskrivelsen.";

        $this->Beskrivelse = $beskrivelse;
    }

    function setBilde($bilde)
    {
        if(!preg_match("/^[0-9a-zæøå \/\_\.-]*$/i", $bilde))
            return "Ulovlige tegn i filbane til bilde.";
        $this->Bilde = $bilde;
    }

    function setKatNr($katnr)
    {
        $db = new sql();
        $resultat = $db->query("SELECT * FROM webprosjekt_kategori WHERE KatNr = '$katnr';");
        $rader = $db->affected_rows;
        $db->close();
        if(!$resultat)
            return "Feil ved databasespørring. (H04)";
        if($rader != 1)
            return "Kategori finnes ikke.";
        $this->KatNr = $katnr;
    }

    function setAntall($antall)
    {
        //kobler til databasen og legger inn $antall
        if(!preg_match("/^[0-9]+$/", $antall))
            return "Antall kan kun inneholde tall 0-9.";

        $this->Antall = $antall;
    }

    /**
     * Get-metoder for å hente ut parametere til vare.
     *
     */
    function getVNr() {return $this->VNr;}
    function getVarenavn() {return $this->Varenavn;}
    function getPris() {return $this->Pris;}
    function getBeskrivelse() {return $this->Beskrivelse;}
    function getBilde() {return $this->Bilde;}
    function getKatNr() {return $this->KatNr;}
    function getAntall() {return $this->Antall;}

    function leggTilVare($varenavn,$pris,$beskrivelse,$bilde,$katNr,$antall)
    {
        $db=new sql();
        $error['varenavn']=$this->setVarenavn(renStreng($varenavn,$db));
        $error['pris']=$this->setPris(renStreng($pris,$db));
        $error['beskrivelse']=$this->setBeskrivelse(renStreng(nl2br($beskrivelse),$db,"<br>"));
        $error['bilde']=$this->setBilde(renStreng($bilde,$db));
        $error['katnr']=$this->setKatNr(renStreng($katNr,$db));
        $error['antall']=$this->setAntall(renStreng($antall,$db));
        $db->close();
        return $error;
    }

    function lagreVare()
    {
        $varenavn=  $this->Varenavn;
        $pris=  $this->Pris;
        $beskrivelse= $this->Beskrivelse;
        $bilde=  $this->Bilde;
        $katNr=  $this->KatNr;
        $antall=  $this->Antall;

        $db=new sql();
        $resultat = $db->query("INSERT INTO webprosjekt_vare (Varenavn,Pris,Beskrivelse,Bilde,KatNr,Antall)
                              VALUES('$varenavn','$pris','$beskrivelse','$bilde','$katNr','$antall');");
        if(!$resultat)
           return"<p class=\"feilmelding\">Databasefeil ved oppretting av ny vare (H03).</p>";
        $this->VNr=$db->insert_id;
        if($db->affected_rows<0)
           return"<p class=\"feilmelding\">Databasefeil ved oppretting av ny vare (H04).</p>";
        $db->close();
        return "<p class=\"okmelding\">Vare lagt til.</p>";
    }

    function endreVare()
    {
        $vnr = $this->VNr;
        $varenavn=  $this->Varenavn;
        $pris=  $this->Pris;
        $beskrivelse=  $this->Beskrivelse;
        $bilde=  $this->Bilde;
        $katNr=  $this->KatNr;
        $antall=  $this->Antall;

        $db=new sql();
        $resultat=$db->query("UPDATE webprosjekt_vare SET Varenavn='$varenavn', Pris='$pris', Beskrivelse='$beskrivelse', Bilde='$bilde',KatNr='$katNr', Antall='$antall' WHERE VNr='$vnr'");
        if(!$resultat)
           return"<p class=\"feilmelding\">Ingen endringer registrert. (H01)</p>";
        if($db->affected_rows<0)
           return"<p class=\"feilmelding\">Databasefeil ved endring av vare. (H02)</p>";
        $db->close();
        return "<p class=\"okmelding\">Vare endret.</p>";
    }
    
	function slettVare()
	{
		$db=new sql();
		$vnr=$this->VNr;
		$resultat=$db->query("DELETE FROM webprosjekt_vare WHERE VNr='$vnr'");
		if(!$resultat || $db->affected_rows<1)
		   return"<p class=\"feilmelding\">Kan ikke slette: varen finnes i en eller flere ordre.</p>";
		$db->close();
		return"<p class=\"okmelding\">Vare slettet.</p>";
	}
}
?>
