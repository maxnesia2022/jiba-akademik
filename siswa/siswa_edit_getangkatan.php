<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$departemen=$_POST['departemen'];
?>
<select name="angkatan" id="angkatan" class="ukuran" style="width:195px;">          
<? // Olah untuk combo angkatan
	OpenDb();
	$sql_angkatan="SELECT * FROM angkatan WHERE aktif=1 AND departemen='$departemen' ORDER BY replid DESC";
	$result_angkatan=QueryDB($sql_angkatan);
	while ($row_angkatan = mysqli_fetch_array($result_angkatan)) {
	if ($angkatan == "")
		$angkatan = $row_angkatan['replid'];
?>
<option value="<?=$row_angkatan['replid']?>"<?=IntIsSelected($row_angkatan['replid'], $angkatan)?>>
<?=$row_angkatan['angkatan']?></option>
<?  } 	CloseDb();
// Akhir Olah Data angkatan
?>
</select>