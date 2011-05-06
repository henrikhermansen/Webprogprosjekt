<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Handlekurv
{
	private $handlekurv,$varenavn;

	function __construct() { $this->handlekurv=array();$this->varenavn=array(); }

	function leggTilVare($vnr,$antall)
	{
	   $handlekurv=$this->handlekurv;
	   $varenavn=$this->varenavn;
	   $db=new sql();
	   $vnr=renStreng($vnr,$db);
	   $antall=renStreng($antall,$db);
		$resultat=$db->query("SELECT Varenavn FROM webprosjekt_vare WHERE VNr='$vnr'");
		$resultat=$resultat->fetch_assoc();
		$rows=$db->affected_rows;
		$db->close();
		if($rows<1)
		   return "<p class=\"feilmelding\">Fant ingen vare med varenummer $vnr.</p>";
		if($antall<1)
		   return "<p class=\"advarselmelding\">Antall må være minst en.</p>";
		$handlekurv[$vnr]+=$antall;
		$varenavn[$vnr]=$resultat['Varenavn'];
		$this->handlekurv=$handlekurv;
		$this->varenavn=$varenavn;
		$this->oppdater();
		return"<p class=\"okmelding\">$antall stk. ".$resultat['Varenavn']." ble lagt i handlekurven.</p>";
	}
	
	function visHandlekurv()
	{
	   if(count($this->handlekurv)==0)
	      return"<p>Handlekurven er tom.</p>";
	   $return="<ul>\n";
	   $varenavn=$this->varenavn;
		foreach($this->handlekurv as $vnr=>$antall)
			$return.="<li>$antall*".$varenavn[$vnr]."</li>\n";
		$return.="</ul>\n";
		$return.="<p><a href=\"index.php?".$_SERVER['QUERY_STRING']."&amp;tomkurv=true\">Tøm handlevognen</a> <a href=\"index.php?side=kassen\">Gå til kassen</a></p>";
		return $return;
	}
	
	function tomHandlekurv()		{ $this->handlekurv=array();$this->varenavn=array();$this->oppdater(); }
	
	private function oppdater()   { $_SESSION['handlekurv']=serialize($this); }
}

?>