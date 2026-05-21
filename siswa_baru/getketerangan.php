<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$kapasitas = 0;
$isi = 0;
if ($_REQUEST['kelompok'] <> "") {
OpenDb();
			  $sql_cek_kap="SELECT kapasitas FROM kelompokcalonsiswa WHERE replid = '$_REQUEST[kelompok]'";
			  $res_cek_kap=QueryDb($sql_cek_kap);
			  $row_cek_kap=@mysqli_fetch_array($res_cek_kap);
			  
			  $sql_cek_jum = "SELECT COUNT(replid) FROM calonsiswa WHERE idkelompok = '$_REQUEST[kelompok]' AND aktif = 1";
			  $res_cek_jum = QueryDb($sql_cek_jum);				
			  $row_cek_jum = mysqli_fetch_row($res_cek_jum);
			  CloseDb();

OpenDb();
$sql = "SELECT keterangan FROM kelompokcalonsiswa WHERE replid = '$_REQUEST[kelompok]'";
$result = QueryDb($sql);
CloseDb();
$row = @mysqli_fetch_array($result);
}			
?>
<textarea name="keterangan" id="keterangan" rows="2" cols="60" readonly style="background-color:#E5F7FF" ><?=$row['keterangan'] ?>
</textarea>
<input type="hidden" name="kapasitas" id="kapasitas" value="<?=$row_cek_kap['kapasitas']?>" />
<input type="hidden" name="isi" id="isi" value="<?=$row_cek_jum[0]?>" />