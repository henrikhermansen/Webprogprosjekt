<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class NyVare extends BasicVare
{
    private $feilmeldinger;

	function __construct($varenavn,$pris,$,$beskrivelse,$bilde,$katNr,$antall)
	{
		$db=new sql();
		$error['varenavn']=$this->setVarenavn(renStreng($varenavn,$db));
		$error['pris']=$this->setPris(renStreng($pris,$db));
		$error['beskrivelse']=$this->setBeskrivelse(renStreng($beskrivelse,$db));
		$error['bilde']=$this->setBilde(renStreng($bilde,$db));
		$error['katnr']=$this->setKatNr(renStreng($katNr,$db),$db);
		$error['antall']=$this->setAntall(renStreng($antall,$db));
		$db->close();
		$this->feilmeldinger=$error;
	}
        
        function getFeilmeldinger()
        {
            return $this->feilmeldinger;
        }

        function legg_til_ny_vare
        {
            $varenavn=  $this->Varenavn;
            $pris=  $this->Pris;
            $beskrivelse=  $this->Beskrivelse;
            $bilde=  $this->Bilde;
            $katNr=  $this->KatNr;
            $antall=  $this->Antall;

		$db=new sql();
		$resultat=$db->query("INSERT INTO webprosjekt_kunde (Varenavn,Pris,Beskrivelse,Bilde,KatNr,Antall)"
									." VALUES('$varenavn','$pris','$beskrivelse','$bilde','$katNr','$antall')");
		$VNr=$db->insert_id;
		if($db->affected_rows<0)
		   return"<p class=\"feilmelding\">Databasefeil ved oppretting av ny vare.</p>";
		$db->close();
        }
}

?>
