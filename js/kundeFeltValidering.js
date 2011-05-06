function validerFornavn()
{
	regEx = /^[a-zæøå ]{2,45}$/i;
	if(regEx.test(document.kundeSkjema.fornavn.value))
	{
		document.getElementById("feilFornavn").innerHTML = "";
		document.getElementById("feilFornavn").setAttribute("style", "display:none");
		return true;
	}
	document.getElementById("feilFornavn").innerHTML = "Fornavn kan kun inneholde bokstaver. Minst to og maks 45.";
	document.getElementById("feilFornavn").setAttribute("style", "display:block");
	return false;
}

function validerEtternavn()
{
	regEx = /^[a-zæøå ]{2,45}$/i;
	if(regEx.test(document.kundeSkjema.etternavn.value))
	{
		document.getElementById("feilEtternavn").innerHTML = "";
		document.getElementById("feilEtternavn").setAttribute("style", "display:none");
		return true;
	}
	document.getElementById("feilEtternavn").innerHTML = "Etternavn kan kun inneholde bokstaver. Minst to og maks 45.";
	document.getElementById("feilEtternavn").setAttribute("style", "display:block");
	return false;
}

function validerAdresse()
{
	regEx = /^[a-zæøå0-9. ]{2,100}$/i;
	if(regEx.test(document.kundeSkjema.adresse.value))
	{
		document.getElementById("feilAdresse").innerHTML = "";
		document.getElementById("feilAdresse").setAttribute("style", "display:none");
		return true;
	}
	document.getElementById("feilAdresse").innerHTML = "Adresse kan kun inneholde bokstaver, tall, mellomrom og punktum. 2-100 tegn.";
	document.getElementById("feilAdresse").setAttribute("style", "display:block");
	return false;
}

function validerTelefonnr()
{
	regEx = /^\b\d{8}\b$/;
	if(regEx.test(document.kundeSkjema.telefonnr.value))
	{
		document.getElementById("feilTelefonnr").innerHTML = "";
		document.getElementById("feilTelefonnr").setAttribute("style", "display:none");
		return true;
	}
	document.getElementById("feilTelefonnr").innerHTML = "Telefonnummer må bestå av 8 siffer.";
	document.getElementById("feilTelefonnr").setAttribute("style", "display:block");
	return false;
}

function validerPostnr()
{
	postnr=document.kundeSkjema.postnr.value;
	sjekkPostnummer(postnr);
	
	regEx = /^\b\d{4}\b$/;
	if(regEx.test(document.kundeSkjema.postnr.value))
	{
		document.getElementById("feilPostnr").innerHTML = "";
		document.getElementById("feilPostnr").setAttribute("style", "display:none");
		return true;
	}
	document.getElementById("feilPostnr").innerHTML = "Postnummer må bestå av 4 siffer.";
	document.getElementById("feilPostnr").setAttribute("style", "display:block");
	return false;
}

function validerEpost()
{
	regEx = /^[A-ZÆØÅ0-9._%+-]+@[A-ZÆØÅ0-9.-]+\.[A-Z]{2,4}$/i;
	if(regEx.test(document.kundeSkjema.epost.value))
	{
		document.getElementById("feilEpost").innerHTML = "";
		document.getElementById("feilEpost").setAttribute("style", "display:none");
		return true;
	}
	document.getElementById("feilEpost").innerHTML = "Feil format på e-postadressen.";
	document.getElementById("feilEpost").setAttribute("style", "display:block");
	return false;
}


function validerAlle()
{
   validerFornavn();validerEtternavn();validerAdresse();validerTelefonnr();validerPostnr();validerEpost();
	return validerFornavn() && validerEtternavn() && validerAdresse() && validerTelefonnr() && validerPostnr() && validerEpost();
}

function nullstill()
{
	document.getElementById("feilFornavn").innerHTML = "";
	document.getElementById("feilFornavn").setAttribute("style", "display:none");
	document.getElementById("feilEtternavn").innerHTML = "";
	document.getElementById("feilEtternavn").setAttribute("style", "display:none");
	document.getElementById("feilAdresse").innerHTML = "";
	document.getElementById("feilAdresse").setAttribute("style", "display:none");
	document.getElementById("feilTelefonnr").innerHTML = "";
	document.getElementById("feilTelefonnr").setAttribute("style", "display:none");
	document.getElementById("feilPostnr").innerHTML = "";
	document.getElementById("feilPostnr").setAttribute("style", "display:none");
	document.getElementById("feilEpost").innerHTML = "";
	document.getElementById("feilEpost").setAttribute("style", "display:none");
}

function validerNyttPassord()
{
	if(document.passordSkjema.nyttPass1.value.length>=6)
	{
		document.getElementById("feilNyttPass").innerHTML = "";
		document.getElementById("feilNyttPass").setAttribute("style", "display:none");
		return true;
	}
	document.getElementById("feilNyttPass").innerHTML = "Passordet må bestå av minst 6 tegn.";
	document.getElementById("feilNyttPass").setAttribute("style", "display:block");
	return false;
}