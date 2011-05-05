<?php

class Vare
{
    function getVarer($kategori)
    {
        if($kategori == 0)
        {
            $db = new sql();
            $resultat = $db->query("SELECT webprosjekt_vare.Bilde, webprosjekt_vare.VNr, webprosjekt_vare.Varenavn, webprosjekt_vare.Beskrivelse, webprosjekt_vare.Pris
                                    FROM webprosjekt_vare;");
            if(!$resultat)
                die("Feil - finner ikke vare i databasen (B02)");
            $db->close();
            $returarray;
            while($rad = $resultat->fetch_assoc())
            {
                $varelinje = array($rad['Bilde'],$rad['VNr'],$rad['Varenavn'],$rad['Beskrivelse'],$rad['Pris']);
                $returarray[] = $varelinje;
            }
            return $returarray;
        }
        else
        {
            $db = new sql();
            $resultat = $db->query("SELECT webprosjekt_vare.Bilde, webprosjekt_vare.VNr, webprosjekt_vare.Varenavn, webprosjekt_vare.Beskrivelse, webprosjekt_vare.Pris
                                    FROM webprosjekt_vare
                                    WHERE KatNr = '$kategori';");
            if(!$resultat)
                die("Feil - finner ikke vare i databasen (B03)");
            $db->close();
            $returarray;
            while($rad = $resultat->fetch_assoc())
            {
                $varelinje = array($rad['Bilde'],$rad['VNr'],$rad['Varenavn'],$rad['Beskrivelse'],$rad['Pris']);
                $returarray[] = $varelinje;
            }
            return $returarray;
        }
    }
}
?>
