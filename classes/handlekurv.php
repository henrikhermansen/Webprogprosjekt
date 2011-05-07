<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

class Handlekurv
{
	private $handlekurv,$varenavn,$varepris;

	function __construct() { $this->handlekurv=array();$this->varenavn=array();$this->varepris=array(); }

	function leggTilVare($vnr,$antall)
	{
	   $handlekurv=$this->handlekurv;
	   $varenavn=$this->varenavn;
	   $varepris=$this->varepris;
	   $db=new sql();
	   $vnr=renStreng($vnr,$db);
	   $antall=renStreng($antall,$db);
		$resultat=$db->query("SELECT Varenavn,Pris FROM webprosjekt_vare WHERE VNr='$vnr'");
		$resultat=$resultat->fetch_assoc();
		$rows=$db->affected_rows;
		$db->close();
		if($rows<1)
		   return "<p class=\"feilmelding\">Fant ingen vare med varenummer $vnr.</p>";
		if($antall<1)
		   return "<p class=\"advarselmelding\">Antall må være minst en.</p>";
		$handlekurv[$vnr]+=$antall;
		$varenavn[$vnr]=$resultat['Varenavn'];
		$varepris[$vnr]=$resultat['Pris'];
		$this->handlekurv=$handlekurv;
		$this->varenavn=$varenavn;
		$this->varepris=$varepris;
		$this->oppdater();
		return"<p class=\"okmelding\">$antall stk. ".$resultat['Varenavn']." ble lagt i handlekurven.</p>";
	}
	
	function visHandlekurv()
	{
	   if(count($this->handlekurv)==0)
	      return"<p>Handlekurven er tom.</p>";
		$totalsum=0;
	   $return="<ul>\n";
	   $varenavn=$this->varenavn;
	   $varepris=$this->varepris;
		foreach($this->handlekurv as $vnr=>$antall)
		{
			$return.="<li>$antall*".$varenavn[$vnr]." (".number_format($antall*$varepris[$vnr],0,",",".").",-)</li>\n";
			$totalsum+=($antall*$varepris[$vnr]);
		}
		$return.="<li>Totalt: ".number_format($totalsum,0,",",".").",-</li>\n";
		$return.="</ul>\n";
		$return.="<p><a href=\"index.php?".$_SERVER['QUERY_STRING']."&amp;tomkurv=true\">Tøm handlevognen</a> <br/> <a href=\"index.php?side=kassen\">Gå til kassen</a></p>";
		return $return;
	}
	
	function getHandlekurv()
	{
	   $varenavn=$this->varenavn;
	   $varepris=$this->varepris;
	   $returarray=array();
	   foreach($this->handlekurv as $vnr=>$antall)
      	$returarray[]=array($vnr,$varenavn[$vnr],$varepris[$vnr],$antall,$antall*$varepris[$vnr]);
		return $returarray;
	}
	
	function tomHandlekurv()		{ $this->handlekurv=array();$this->varenavn=array();$this->oppdater(); }
	
	private function oppdater()   { $_SESSION['handlekurv']=serialize($this); }
}

?>