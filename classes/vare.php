<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Vare
{
    private $VNr, $Varenavn, $Pris, $Beskrivelse, $Bilde, $KatNr, $Antall;

    /**
     * Konstruktør for å legge til vare og hente ut info om vare med gitt varenummer.
     *
     */
    function  __construct($VNr = false)
    {
        if(!VNr) //Legger til vare
        {
            $db = new sql();
            $resultat = $db->query("INSERT INTO webprosjekt_vare(VNr, Varenavn, Pris, Beskrivelse, Bilde, KatNr, Antall) VALUES('$VNr','$Varenavn','$Pris','$Beskrivelse','$Bilde','$KatNr','$Antall')");
            if($db->affected_rows == 0)
                die("Feil - kunne ikke sette inn vare i databasen (B05)");
            $db->close();
        }
        else //hent ut info om varen
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

}
?>
