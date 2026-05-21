<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$departemen=$_REQUEST['departemen'];
?>
<select name="tahunajaran" id="tahunajaran" onchange="change_tahunajaran()">
  <?
OpenDb();
$sql_tahunajaran="SELECT t.replid,t.tahunajaran FROM tahunajaran t WHERE t.departemen='$departemen' AND t.aktif=1 ORDER BY t.tglmulai";
$result_tahunajaran=QueryDb($sql_tahunajaran);
$sql_tahunajaran;
while ($row_tahunajaran=@mysqli_fetch_row($result_tahunajaran)){
	if ($tahunajaran=="")
		$tahunajaran=$row_tahunajaran[0];
?>
      <option value="<?=$row_tahunajaran[0]?>" <?=StringIsSelected($row_tahunajaran[0], $tahunajaran) ?>>
        <?=$row_tahunajaran[1]?>
        </option>
      <?
}
CloseDb();
?></select>