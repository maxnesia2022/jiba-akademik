<?
 ?>
<?
require_once("../include/theme.php");
require_once('../include/errorhandler.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../cek.php');
$status_user = $_REQUEST['tingkat'];
?>
<select name="departemen" id="departemen" style="width:165px;" onKeyPress="return focusNext('keterangan', event)" onFocus="panggil('tt')">
	<?  if ($status_user == 1 || $status_user == ""){	
		echo "<option value='' selected='selected'>Semua</option>";
	} else {
		OpenDb();
		$query_pro = "SELECT departemen FROM departemen WHERE aktif=1 ORDER BY urutan ASC";
		$result_pro = QueryDb($query_pro);
	
		$i = 0;
		while($row_pro = @mysqli_fetch_array($result_pro)) {
			echo "<option value='$row_pro[departemen]' $sel[$i]>$row_pro[departemen]</option>";
			$i++;
		}
	}
?>
	</select>