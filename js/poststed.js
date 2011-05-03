function sjekkPostnummer(nr)
{
	var xmlhttp;

	if (nr.length==0)
	{
		document.getElementById("poststed").innerHTML="Ugyldig postnummer";
		return;
	}

	if (window.XMLHttpRequest)
	{// kode for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// kode for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		   if(xmlhttp.responseText=="\r\n")
		      document.getElementById("poststed").innerHTML="Ugyldig postnummer";
			else
				document.getElementById("poststed").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","postnummer.php?postnr="+nr,true);
	xmlhttp.send();
}