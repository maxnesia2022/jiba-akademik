<?
 ?>
<? 
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$departemen=$_POST['departemen'];

  OpenDb();
	$sql_tahunajaran = "SELECT replid,tahunajaran FROM tahunajaran where departemen='$departemen' AND aktif = 1 ";
	$result_tahunajaran = QueryDb($sql_tahunajaran);
	if($row_tahunajaran = mysqli_fetch_array($result_tahunajaran)) {
?>
  <input type="text" name="tahunajaran" id="tahunajaran" size="21" class="disabled" readonly="readonly" value="<?=$row_tahunajaran['tahunajaran']?>">
  <input type="hidden" name="idtahunajaran" id="idtahunajaran" value="<?=$row_tahunajaran['replid']?>">
  
  <?
  } //while
CloseDb();
?>