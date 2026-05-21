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
<select name="tingkat" id="tingkat" onchange="change_tingkat()">
  <?
OpenDb();
$sql_tingkat="SELECT t.replid,t.tingkat FROM tingkat t WHERE t.departemen='$departemen' AND t.aktif=1 ORDER BY t.urutan";
$result_tingkat=QueryDb($sql_tingkat);
while ($row_tingkat=@mysqli_fetch_row($result_tingkat)){
	if ($tingkat=="")
		$tingkat=$row_tingkat[0];
?>
      <option value="<?=$row_tingkat[0]?>" <?=StringIsSelected($row_tingkat[0], $tingkat) ?>>
        <?=$row_tingkat[1]?>
        </option>
      <?
}
CloseDb();
?></select>