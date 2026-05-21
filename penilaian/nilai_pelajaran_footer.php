<?
 ?>
<?
if(isset($_REQUEST["departemen"]))
	$departemen = $_REQUEST["departemen"];

if(isset($_REQUEST["tingkat"]))
	$tingkat = $_REQUEST["tingkat"];

if(isset($_REQUEST["semester"]))
	$semester = $_REQUEST["semester"];

if(isset($_REQUEST["kelas"]))
	$kelas = $_REQUEST["kelas"];

if(isset($_REQUEST["nip"]))
	$nip = $_REQUEST["nip"];

if(isset($_REQUEST["nama"]))
	$nama = $_REQUEST["nama"];
?>
<frameset cols = "200, *" border ="1" frameborder="0" framespacing="0">
    <frame src = "nilai_pelajaran_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&nama=<?=$nama?>&semester=<?=$semester?>&kelas=<?=$kelas?>&nip=<?=$nip?>" name ="nilai_pelajaran_menu" scrolling="auto"/>
    <frame src = "blank_nilai_pelajaran_content.php" name ="nilai_pelajaran_content" style="border:1px; border-left-color:#000000; border-left-style:solid" scrolling="auto"/>
</frameset><noframes></noframes>