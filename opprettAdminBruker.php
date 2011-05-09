<?php

session_start();

ERROR_REPORTING(E_ALL ^ E_NOTICE);

date_default_timezone_set('Europe/Oslo');
$gjennomIndex=true;

require_once"_functions.php";
require_once"_classes.php";
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="nettbutikk.css" title="Standard css" />
<title>HBHL nettbutikk</title>
</head>
<body>

<div id="hovedramme">

<div id="header">
    <h1><a href="index.php?side=hjem">HBHL nettbutikk</a></h1>
</div>

<div id="l_meny"></div>

<div id="innhold">
	<h2>Opprett administratorbruker</h2>
<?php
if($_POST['knapp']=="Opprett adminbruker")
{
	$admin=new Admin();
	echo $admin->nyAdmin($_POST['brukernavn'],$_POST['passord1'],$_POST['passord2'],$_POST['rotpassord']);
}
?>
	<form name="alogin" action="" method="post">
		<p><label for="brukernavn">Brukernavn</label><input type="text" name="brukernavn" id="brukernavn" maxlength="45"></p>
		<p><label for="passord1">Passord</label><input type="password" name="passord1" id="passord1" maxlength="50"></p>
		<p><label for="passord2">Bekreft passord</label><input type="password" name="passord2" id="passord2" maxlength="50"></p>
		<p><label for="rotpassord">Rotpassord</label><input type="password" name="rotpassord" id="rotpassord" maxlength="50"></p>
		<p><input type="submit" name="knapp" value="Opprett adminbruker"></p>
	</form>
</div>

<div id="r_meny"></div>

</div>
</body>
</html>
