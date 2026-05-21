<?
 ?>
<?
require_once('../include/config.php');
require_once('../include/db_functions.php');
$departemen = $_REQUEST['departemen'];
OpenDb();
$sql = "SELECT replid FROM identitas WHERE departemen='$departemen'";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$replid = $row[0];
CloseDb(); 
?>
	<img src="../library/gambar.php?replid=<?=$replid?>&table=identitas" />&nbsp;
<? if ($_REQUEST['gbrbaru']=='1'){ ?>
	<img src="../images/panah.png" border="0" width="100" height="100"/>&nbsp;
	<img src="../../temp/ad-logo-tmp.jpg?<?=date("his")?>" border="0"/>
<? } ?>