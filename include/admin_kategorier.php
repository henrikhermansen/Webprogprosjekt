<?php if(!$gjennomIndex) die("Access denied.");?>

<h2>Kategorier</h2>

<form action="index.php?side=admin_kategorier" method="POST">
<label for="kategori">Ny kategori</label>
<input type="text" name="kategori" id="kategori" maxlength="30" value="<?php echo $_POST['kategori']; ?>" required>
<input type="submit" name="nykategori" id="nykategori" value="Registrer ny kategori">
</form>

<?php
if($_POST['nykategori']=="Registrer ny kategori")
{
	$kategori=new Kategori();
	echo $kategori->nyKategori($_POST['kategori']);
}

if(isset($_GET['slett']))
{
	$kategori=new Kategori();
	$setOk=$kategori->setKategori($_GET['slett']);
	if($setOk!=null)
	   echo $setOk;
	else
	   echo $kategori->slettKategori();
}
?>

<table>
	<tr>
	   <th>Kategori</th>
	   <th>&nbsp;</th>
	</tr>
<?php
$kategorier = getKategorier();

if(!$kategorier)
    echo "<p>Det finnes ingen kategorier i databasen.</p>";
else
    foreach ($kategorier as $katnr=>$katnavn)
		echo "<tr><td>$katnavn</td><td><a href=\"javascript:bekreftSletting('index.php?side=admin_kategorier&amp;slett=$katnr')\">Slett</a></td></tr>\n";
?>
</table>