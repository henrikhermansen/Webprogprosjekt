<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Vare extends BasicVare
{
    /**
     * Konstruktør for å legge til vare og hente ut info om vare med gitt varenummer.
     *
     */
    
    function  __construct($VNr = false)
    {
        if($Vnr) //henter ut info om varen
        {
            $db = new sql();
            $resultat = $db->query("SELECT * FROM webprosjekt_vare WHERE VNr = '$VNr';");
            $rader = $db->affected_rows;
            $db->close();
            if($rader == 0)
                die("Feil - finner ikke vare i databasen (B06)");
            $resultat = $resultat->fetch_assoc();
            $this->Vnr = $resultat['VNr'];
            $this->Varenavn = $resultat['Varenavn'];
            $this->Pris = $resultat['Pris'];
            $this->Beskrivelse = $resultat['Beskrivelse'];
            $this->Bilde = $resultat['Bilde'];
            $this->KatNr = $resultat['KatNr'];
            $this->Antall = $resultat['Antall'];
        }
    }

    function nyVare()
    {
        $varenavn=  $this->Varenavn;
        $pris=  $this->Pris;
        $beskrivelse=  $this->Beskrivelse;
        $bilde=  $this->Bilde;
        $katNr=  $this->KatNr;
        $antall=  $this->Antall;
    }

}
?>
