<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
OpenDb();
$departemen = $_POST['departemen'];
?>
<select name="kelas" id="kelas" onchange="change_kelas()"  style="width:100px">
<?
	$sql_kelas = "SELECT k.replid,k.kelas FROM kelas k,tahunajaran t WHERE k.aktif=1 AND t.departemen='$departemen' AND k.idtahunajaran=t.replid ORDER BY k.replid";
	
	$result_kelas = QueryDb($sql_kelas);
	
			
	while($row_kelas =@mysqli_fetch_row($result_kelas)) {
?>
		<option value="<?=urlencode($row_kelas[0])?>"><?=$row_kelas[1]?></option>
<?
	} //while
	CloseDb();
?>
</select>