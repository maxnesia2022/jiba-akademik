<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/dpupdate.php');
    
$id_tingkat = $_REQUEST['id_tingkat'];
$nip_guru = $_REQUEST['nip_guru'];
$id_pelajaran = $_REQUEST['id_pelajaran'];
$aspek = $_REQUEST['aspek'];
$departemen = $_REQUEST['departemen'];
$op = $_REQUEST['op'];


if ($op == "xm8r389xemx23xb2378e23") {
	OpenDb();
	$sql = "DELETE FROM aturannhb WHERE idpelajaran = '$id_pelajaran' AND nipguru = '$nip_guru' AND idtingkat = '$id_tingkat' AND dasarpenilaian = '$aspek'"; 
	
	QueryDb($sql);
	CloseDb();
	?>
    <script>
		document.location.href="perhitungan_rapor_content.php?id_pelajaran=<?=$id_pelajaran?>&nip=<?=$nip_guru?>&departemen=<?=$departemen?>";    	
    </script> 
	<?
}	

?>