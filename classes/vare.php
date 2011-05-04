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
//            if($db->affected_rows == 0)
//                die("Feil - finner ikke vare i databasen (B01)");
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
                                    FROM webprosjekt_vare, webprosjekt_kategori
                                    WHERE webprosjekt_vare.KatNr=webprosjekt_kategori.KatNr
                                    AND KatNr = '$kategori';");
            if($db->affected_rows == 0)
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
    }
}
?>
