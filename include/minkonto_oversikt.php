<?php if(!$gjennomIndex) die("Access denied.");?>

<h3>Oversikt</h3>

<p>
<?php
echo "Kundenummer: ".$kunde->getKNr()."<br/>";
echo "E-post: ".$kunde->getEpost()."<br/>";
echo "Telefonnummer: ".$kunde->getTelefonnr();
?>
</p>

<h4>Faktura/leveringsadresse:</h4>
<p>
<?php
echo $kunde->getNavn()."<br/>";
echo $kunde->getAdresse()."<br/>";
echo $kunde->getPostnr()." ".$kunde->getPoststed();
?>
</p>