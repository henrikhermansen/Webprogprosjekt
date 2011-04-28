<?php
session_start();

date_default_timezone_set('Europe/Oslo');
$gjennomIndex=true;

$side=str_replace("/","",$_REQUEST['side']);
$denied_includes=array("","side_handlekurv"); // Sider som ikke skal kunne vises som andre sider

require_once"_functions.php";
require_once"_classes.php";

// Dette er kun en test for å vise prinsippet med klassen sql.
$db=new sql();
if($db->connect_error)
	echo"Tilkoblingen feilet bla bla";
$db->close();
// Test END
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="nettbutikk.css" title="Standard css" />
<title>Nettbutikk</title>
</head>
<body>

<div id="header">
	<h1>Nettbutikken vår</h1>
</div>

<div id="v_meny">
	<h3>Kategorier:</h3>
	<ul>
		<li><a href="#">Alle kategorier</a></li>
		<li><a href="#">Kategori 1</a></li>
		<li><a href="#">Kategori 2</a></li>
		<li><a href="#">Kategori 3</a></li>
		<li><a href="#">Kategori 4</a></li>
		<li><a href="#">Kategori 5</a></li>
	</ul>
	<hr/>
	<ul>
		<li><a href="index.php?side=logginn">Logg inn</a></li>
		<li><a href="index.php?side=nykunde">Ny kunde</a></li>
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
