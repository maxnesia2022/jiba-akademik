<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];
?>
<select name="kelas" id="kelas" onchange="change_tabel()">
  <?
OpenDb();
$sql_kelas="SELECT k.replid,k.kelas,k.kapasitas FROM kelas k WHERE k.idtingkat='$tingkat' AND k.idtahunajaran='$tahunajaran' AND k.aktif=1 ORDER BY k.kelas";
$result_kelas=QueryDb($sql_kelas);

while ($row_kelas=@mysqli_fetch_row($result_kelas)){
//$idkelas=$row_kelas[0];
$sql_terisi="SELECT COUNT(*) FROM siswa WHERE idkelas='$row_kelas[0]' AND aktif = 1";
$result_terisi=QueryDb($sql_terisi);
$row_terisi=@mysqli_fetch_row($result_terisi);
$terisi=(int)$row_terisi[0];
?>
      <option value="<?=$row_kelas[0]?>">
        <?=$row_kelas[1]?>&nbsp;Kapasitas&nbsp;:&nbsp;<?=$row_kelas[2]?>&nbsp;Terisi&nbsp;:&nbsp;<?=$terisi?>
        </option>
      <?
}
CloseDb();
?></select>