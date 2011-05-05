<?php

session_start();

ERROR_REPORTING(E_ALL ^ E_NOTICE);

date_default_timezone_set('Europe/Oslo');
$gjennomIndex=true;

$side=str_replace("/","",$_REQUEST['side']);
$denied_includes=array("","side_handlekurv"); // Sider som ikke skal kunne vises som andre sider

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
		$side="sessionExpired";
	}
}
if(isset($_SESSION['admin']))   // Innlogget admin
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
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="nettbutikk.css" title="Standard css" />
<title>Nettbutikk</title>
<?php if($side=="nykunde" || ($side=="minkonto" && $_REQUEST['kontoside']=="endrekonto")) echo"<script type=\"text/javascript\" src=\"js/poststed.js\"></script>"; ?>
<?php if($side=="nykunde" || $side=="glemtpassord" ||($side=="minkonto" && $_REQUEST['kontoside']=="endrekonto")) echo"<script type=\"text/javascript\" src=\"js/kundeFeltValidering.js\"></script>"; ?>
<?php if($side=="kontakt") echo"<script type=\"text/javascript\" src=\"js/kontaktValidering.js\"></script>"; ?>
<?php if($side=="admlogginn") echo"<script type=\"text/javascript\" src=\"js/admloginValidering.js\"></script>"; ?>
</head>
<body>

<div id="header">
    <h1>Nettbutikken v&aring;r</h1>
</div>

<div id="l_meny">
	<?php include "menu.php"; ?>
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
