<?
 ?>
<? 
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$departemen=$_POST['departemen'];
?>
<select name="idtingkat" id="idtingkat" onchange="change_tingkat()" style="width:150px;">
<?
  OpenDb();
	$sql_tingkat = "SELECT replid,tingkat FROM tingkat where departemen='$departemen' AND aktif = 1 ";
	$result_tingkat = QueryDb($sql_tingkat);
	while ($row_tingkat = mysqli_fetch_array($result_tingkat)) {
?>
  <option value="<?=$row_tingkat['replid']?>" <?=StringIsSelected($row_tingkat['departemen'], $departemen) ?>><?=$row_tingkat['tingkat']?></option>
  
  
  <?
  } //while
CloseDb();
?>
</select>