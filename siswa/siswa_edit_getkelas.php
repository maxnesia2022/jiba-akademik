<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$tahunajaran=$_POST['tahunajaran'];
$tingkat=$_POST['tingkat'];
?>
<select name="kelas" id="kelasInfo" style="width:200px;" onKeyPress="return focusNext('idangkatan',event)" onFocus="panggil('kelasInfo')" onchange="change_kelas()">
<?
OpenDb();
$sql = "SELECT replid, kelas, kapasitas FROM kelas where idtingkat='$tingkat' AND idtahunajaran='$tahunajaran' AND aktif = 1 ORDER BY kelas";
$result = QueryDb($sql);
CloseDb();
while ($row = @mysqli_fetch_array($result)) {
	if ($kelas == "") 
		$kelas = $row['replid'];
		
	OpenDb();
	$sql1 = "SELECT COUNT(*) FROM siswa WHERE idkelas = '$row[0]' AND aktif = 1";
	$result1 = QueryDb($sql1);
	$row1 = @mysqli_fetch_row($result1); 				
	CloseDb();
?>
<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $kelas)?> >
<?=$row['kelas'].', kapasitas: '.$row['kapasitas'].', terisi: '.$row1[0]?>
</option>
<?  } ?>
</select>