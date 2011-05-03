function valider_alle()
    {
        if(document.alogin.bnavn.value != "" && document.alogin.pord.value != "")
            return true;
        document.getElementById("feilmelding").innerHTML = "<p class=\"feilmelding\">Fyll ut begge feltene</p>";
        return false;
    }