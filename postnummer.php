<?php

$gjennomIndex=true;
require_once"functions/sjekkPostnr.php";
echo sjekkPostnr($_REQUEST['postnr']);

?>