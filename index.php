<?php

session_start();

ERROR_REPORTING(E_ALL ^ E_NOTICE);

date_default_timezone_set('Europe/Oslo');
$gjennomIndex=true;

$side=str_replace("/","",$_REQUEST['side']);
$denied_includes=array("","side_handlekurv","sessionExpired"); // Sider som ikke skal kunne vises som andre sider

require_once"_functions.php";
require_once"_classes.php";

if(isset($_SESSION['kunde']))   // Innlogget kunde
{
	$kunde=unserialize($_SESSION['kunde']);
	if($kunde->refreshSession())	// Hvis session ikke har gått ut på tid
	   $_SESSION['kunde']=serialize($kunde);
	else  // Session har gått ut på tid
	{
		unset($_SESSION['kunde']);
		session_unset();
	   $side="sessionExpired";
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="nettbutikk.css" title="Standard css" />
<title>Nettbutikk</title>
</head>
<body>

<div id="header">
    <h1>Nettbutikken v&aring;r</h1>
</div>

<div id="v_meny">
	<h3>Kategorier:</h3>
	<ul>
		<?php
		$db = new sql();
		$resultat = $db->query("SELECT * FROM webprosjekt_kategori;");
		if($db->affected_rows == 0)
			die("Feil (001)");
		while($rad = $resultat->fetch_assoc())
			echo '<li><a href="index.php?side=varer&amp;kat='.$rad["KatNr"].'">'.$rad["Navn"].'</a></li>';
		$db->close();
		?>
		<!--<li><a href="index.php?side=varer&amp;kat=1">Speilreflekskamera</a></li>
		<li><a href="index.php?side=varer&amp;kat=2">Superzoomkamera</a></li>
		<li><a href="index.php?side=varer&amp;kat=3">Kompaktkamera</a></li>
		<li><a href="index.php?side=varer&amp;kat=4">Undervannskamera</a></li>
		<li><a href="index.php?side=varer&amp;kat=5">Objektiv</a></li>
		<li><a href="index.php?side=varer&amp;kat=6">Tilbeh&oslash;r</a></li>-->
		<li><a href="index.php?side=varer&amp;kat=0">Alle kategorier</a></li>
	</ul>
	<hr/>
	<ul>
		<?php
		if(!isset($kunde) || $side=="loggut")
		{?>
			<li><a href="index.php?side=logginn">Logg inn</a></li>
			<li><a href="index.php?side=nykunde">Ny kunde</a></li>
		<?php }
		else
		{?>
			<li><a href="index.php?side=minkonto">Min konto</a></li>
			<li><a href="index.php?side=loggut">Logg ut</a></li>
		<?php }
		?>
		<li><a href="index.php?side=kontakt">Kontakt oss</a></li>
		<li><a href="index.php?side=admlogginn">Administrator</a></li>
	</ul>
</div>

<div id="innhold">
	<?php
	if(is_file("include/".$side.".php") && !array_search($side,$denied_includes))
		include "include/".$side.".php";
	else
		//include(isset($bruker)?"include/bestill.php":"include/login.php");
		include"include/hjem.php";
		//include"404.php";
	?>
</div>

<div id="r_meny">
	<?php
	include "include/side_handlekurv.php";
	?>
</div>

</body>
</html>
