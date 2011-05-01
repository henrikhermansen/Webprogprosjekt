<?php if(!$gjennomIndex) die("Access denied.");?>

<?php

function cryptPass($passord,$salt)
{
	return hash("sha512",hash("md5",$salt).hash("md5",$passord));
}

?>