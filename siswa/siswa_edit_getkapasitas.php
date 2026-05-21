<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$kelas=$_POST['kelas'];
if ($kelas <> "") {
OpenDb();
$sql1 = "SELECT kapasitas FROM kelas WHERE replid = '$kelas'";
$result1 = QueryDb($sql1);
$row_cek1 = mysqli_fetch_array($result1);
$sql2 = "SELECT COUNT(*) AS jum FROM siswa WHERE idkelas = '$kelas' AND aktif = 1";
$result2 = QueryDb($sql2);
$row_cek2 = mysqli_fetch_array($result2);
CloseDb();

?>
<input type="hidden" name="kapasitas" id="kapasitas" value="<?=$row_cek1['kapasitas']?>" />
<input type="hidden" name="isi" id="isi" value="<?=$row_cek2['jum']?>" />
<? } ?>