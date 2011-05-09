<?php

session_start();

ERROR_REPORTING(E_ALL ^ E_NOTICE);

date_default_timezone_set('Europe/Oslo');
$gjennomIndex=true;

$side=str_replace("/","",$_REQUEST['side']);
$denied_includes=array("","side_handlekurv","krev_innlogging","krev_admin","minkonto_oversikt","minkonto_ordre","minkonto_endrekonto","minkonto_endrepassord"); // Sider som ikke skal kunne vises som andre sider
$require_login=array("","minkonto","kassen"); // Sider som kun skal kunne vises til innloggede kunder
$require_admin=array("","admin_kunder","admin_legg_til_ny_vare","admin_ordre","admin_ordreoversikt","admin_varer","admin_endreordre","admin_kategorier","admin_endrevare"); // Sider som kun skal kunne vises til innloggede administratorer

require_once"_functions.php";
require_once"_classes.php";

if(isset($_SESSION['kunde']) && $side!="loggut")   // Innlogget kunde
{
	$kunde=unserialize($_SESSION['kunde']);
	if($kunde->refreshSession())	// Hvis session ikke har gått ut på tid
	   $_SESSION['kunde']=serialize($kunde);
	else  // Session har gått ut på tid
	{
		unset($_SESSION['kunde']);
		$side="sessionExpired";
	}
}
if(isset($_SESSION['admin']) && $side!="loggut")   // Innlogget admin
{
	$admin = unserialize($_SESSION['admin']);
	if($admin->refreshSession())	// Hvis session ikke har gått ut på tid
		$_SESSION['admin'] = serialize($admin);
	else  // Session har gått ut på tid
	{
		unset($_SESSION['admin']);
		$side = "sessionExpired";
	}
}

if(isset($_SESSION['handlekurv']))
	$handlekurv=unserialize($_SESSION['handlekurv']);
else
	$handlekurv=new Handlekurv();

if($_REQUEST['tomkurv']==true)
	$handlekurv->tomHandlekurv();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="nettbutikk.css" title="Standard css" />
<title>HBHL nettbutikk</title>
<?php if($side=="nykunde" || ($side=="minkonto" && $_REQUEST['kontoside']=="endrekonto")) echo"<script type=\"text/javascript\" src=\"js/poststed.js\"></script>"; ?>
<?php if($side=="nykunde" || $side=="glemtpassord" || ($side=="minkonto" && ($_REQUEST['kontoside']=="endrekonto" || $_REQUEST['kontoside']=="endrepassord"))) echo"<script type=\"text/javascript\" src=\"js/kundeFeltValidering.js\"></script>"; ?>
<?php if($side=="kontakt") echo"<script type=\"text/javascript\" src=\"js/kontaktValidering.js\"></script>"; ?>
<?php if($side=="admlogginn") echo"<script type=\"text/javascript\" src=\"js/admloginValidering.js\"></script>"; ?>
<?php if($side=="admin_legg_til_ny_vare" || $side=="admin_endrevare") echo"<script type=\"text/javascript\" src=\"js/vareValidering.js\"></script>"; ?>
<?php if($side=="admin_ordreoversikt" || $side=="admin_kunder"  || $side=="admin_endrevare" || $side=="admin_kategorier") echo"<script type=\"text/javascript\" src=\"js/bekreftSletting.js\"></script>"; ?>
</head>
<body>

<div id="hovedramme">

<div id="header">
    <h1><a href="index.php?side=hjem">HBHL nettbutikk</a></h1>
</div>

<div id="l_meny">
	<?php include "menu.php"; ?>
</div>

<div id="innhold">
	<?php
	if(is_file("include/".$side.".php") && !array_search($side,$denied_includes))
	{
	   if(!isset($kunde) && array_search($side,$require_login))
			include "include/krev_innlogging.php";
	   elseif(!isset($admin) && array_search($side,$require_admin))
	      include "include/krev_admin.php";
		else
			include "include/$side.php";
	}
	else
		//include(isset($bruker)?"include/bestill.php":"include/login.php");
		include"include/hjem.php";
		//include"404.php";
	?>
</div>

<div id="r_meny"><?php include "include/side_handlekurv.php"; ?></div>

</div>
</body>
</html>
