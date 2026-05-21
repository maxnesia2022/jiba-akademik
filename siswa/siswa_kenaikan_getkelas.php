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
<select name="kelas" id="kelas">
  <?
OpenDb();
$sql_kelas="SELECT k.replid,k.kelas FROM kelas k WHERE k.idtingkat='$tingkat' AND k.idtahunajaran='$tahunajaran' AND k.aktif=1 ORDER BY k.kelas";
$result_kelas=QueryDb($sql_kelas);
echo $sql_kelas;
while ($row_kelas=@mysqli_fetch_row($result_kelas)){
	if ($kelas=="")
		$kelas=$row_kelas[0];
?>
      <option value="<?=$row_kelas[0]?>" <?=StringIsSelected($row_kelas[0], $kelas) ?>>
        <?=$row_kelas[1]?>
        </option>
      <?
}
CloseDb();
?></select>