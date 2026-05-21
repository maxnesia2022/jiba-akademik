<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$departemen=$_POST['departemen'];
?>
<select name="tingkat" id="tingkatInfo" onChange="change_tingkat()" style="width:55px;" onKeyPress="return focusNext('kelas',event)" onFocus="panggil('tingkatInfo')">
<?
	OpenDb();
	$sql = "SELECT replid,tingkat FROM tingkat where departemen='$departemen' AND aktif = 1 ORDER BY urutan";
	$result = QueryDb($sql);
	CloseDb();
	while ($row = @mysqli_fetch_array($result)) {
	if ($tingkat == "")
		$tingkat = $row['replid'];
?>
	<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tingkat)?> ><?=$row['tingkat']?></option>
<?	}	?>
</select>