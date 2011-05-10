function validerVarenavn()
{
    regEx = /^[a-zæøå0-9 .,:;\-\_\+\(\)\/\&\\\ ]{2,100}$/i;
    if(regEx.test(document.ny_vare.varenavn.value))
    {
        document.getElementById("feilVarenavn").innerHTML = "";
        document.getElementById("feilVarenavn").setAttribute("style", "display:none");
        return true;
    }
    document.getElementById("feilVarenavn").innerHTML = "Varenavn kan kun inneholde bokstaver, tall, mellomrom, og (.,:;-+/\\&), og må være mellom 2-100 tegn.";
    document.getElementById("feilVarenavn").setAttribute("style", "display:block");
    return false;
}

function validerPris()
{
    regEx = /^[0-9.]+$/;
    if(regEx.test(document.ny_vare.pris.value))
    {
        document.getElementById("feilPris").innerHTML = "";
        document.getElementById("feilPris").setAttribute("style", "display:none");
        return true;
    }
    document.getElementById("feilPris").innerHTML = "Pris må bestå av kun siffer 0-9 og punktum som desimalseparator.";
    document.getElementById("feilPris").setAttribute("style", "display:block");
    return false;
}

function validerAntall()
{
    regEx = /^[0-9]+$/;
    if(regEx.test(document.ny_vare.antall.value))
    {
        document.getElementById("feilAntall").innerHTML = "";
        document.getElementById("feilAntall").setAttribute("style", "display:none");
        return true;
    }
    document.getElementById("feilAntall").innerHTML = "Antall kan kun inneholde tall 0-9.";
    document.getElementById("feilAntall").setAttribute("style", "display:block");
    return false;
}

function validerBeskrivelse()
{
    if(document.ny_vare.beskrivelse.value != "")
    {
        document.getElementById("feilBeskrivelse").innerHTML = "";
        document.getElementById("feilBeskrivelse").setAttribute("style", "display:none");
        return true;
    }
    document.getElementById("feilBeskrivelse").innerHTML = "Skriv noe i varebeskrivelsen.";
    document.getElementById("feilBeskrivelse").setAttribute("style", "display:block");
    return false;
}

function validerAlle()
{
    validerVarenavn();validerPris();validerAntall();validerBeskrivelse();
    return validerVarenavn() && validerPris() && validerAntall() && validerBeskrivelse();
}