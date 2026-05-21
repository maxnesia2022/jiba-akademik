<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

if ($_REQUEST['departemen'] == "SD") {
	$urutan = 2;
} else {
	OpenDb();
	$query = "SELECT urutan FROM departemen WHERE departemen = '$_REQUEST[departemen]'";	
	$hasil = QueryDb($query);	
	CloseDb();
	$row = mysqli_fetch_array($hasil);
	$urutan = $row['urutan'];
}


OpenDb();
$sql_departemen="SELECT departemen,urutan FROM departemen WHERE urutan < '$urutan' ORDER BY urutan DESC LIMIT 1";			
$result_departemen=QueryDB($sql_departemen);
$row_departemen = @mysqli_fetch_array($result_departemen);
$dep_asal = $row_departemen['departemen'];
?>
<input type="hidden" name="dep_asal" id="dep_asal" value="<?=$dep_asal?>" />