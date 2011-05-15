function oppdaterFrakt(frakt,varesum)
{
    document.getElementById("frakt").innerHTML = addCommas(frakt)+",00";
    document.getElementById("totalsum").innerHTML = addCommas(frakt+varesum)+",00";
    document.getElementById("moms").innerHTML = addCommas((frakt+varesum)*0.2)+",00";
}

// Takk til http://www.mredkj.com/javascript/numberFormat.html for følgende funksjon addCommas()
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}