<?
 ?>
<? 
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$departemen=$_POST['departemen'];
OpenDb();
$sql = "SELECT replid,tahunajaran FROM tahunajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY replid DESC";
$result = QueryDb($sql);
CloseDb();
$row = @mysqli_fetch_array($result);	
$tahunajaran = $row['replid'];				
?>
<input type="text" name="tahun" id="tahun" size="20" readonly class="disabled" value="<?=$row['tahunajaran']?>" style="width:250px;"/>
<input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$row['replid']?>">