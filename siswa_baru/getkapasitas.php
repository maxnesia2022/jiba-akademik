<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$kelas = $_REQUEST['kelas'];
$angkatan = $_REQUEST['angkatan'];
$tahunajaran = $_REQUEST['tahunajaran'];

OpenDb();
$sql = "SELECT kapasitas FROM kelas WHERE replid = '$kelas'";
$result = QueryDb($sql);
$row = mysqli_fetch_row($result);
$kapasitas = $row[0];

$sql1 = "SELECT COUNT(*) FROM siswa WHERE idkelas = '$kelas' AND idangkatan = '$angkatan' AND aktif = 1";
$result1 = QueryDb($sql1);
$row1 = mysqli_fetch_row($result1);
$isi = $row1[0];
CloseDb();
	
?>
<input type="text" name="kapasitas" id="kapasitas" value="<?=$kapasitas?>" />
<input type="text" name="isi" id="isi" value="<?=$isi?>" />