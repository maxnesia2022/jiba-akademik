<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/theme.php'); 

$status_kiriman=$_REQUEST['status'];

?>


<select name="status" id="status" class="ukuran" onKeyPress="return focusNext('kondisi', event)">
	<option value="">[Pilih Status]</option>
    <? // Olah untuk combo status
	OpenDb();
	$sql_status="SELECT replid,status,urutan FROM statussiswa ORDER BY urutan";
	$result_status=QueryDB($sql_status);
	while ($row_status = mysqli_fetch_array($result_status)) {
	//tambahan
	//if($status_kiriman=="")
	//$status_kiriman=$row_status['status'];
	// end of tambahan
	?>
    <option value="<?=$row_status['status']?>"<?=StringIsSelected($row_status['status'],$status_kiriman)?> ><?=$row_status['status']?></option>
	<?
    } 
	CloseDb();
	// Akhir Olah Data status
	?>
    </select>&nbsp;<img src="../images/ico/tambah.png" onclick="tambah_status();" />