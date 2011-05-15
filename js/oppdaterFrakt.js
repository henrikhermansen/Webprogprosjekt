function oppdaterFrakt(frakt,varesum)
{
    document.getElementById("frakt").innerHTML = frakt+",00";
    document.getElementById("totalsum").innerHTML = (frakt+varesum)+",00";
    document.getElementById("moms").innerHTML = ((frakt+varesum)*0.2)+",00";
}