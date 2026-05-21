<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$suku_kiriman=$_REQUEST['suku'];

?>
<select name="suku" id="suku" class="ukuran" onKeyPress="return focusNext('status', event)">
	<option value="">[Pilih Suku]</option>  
    <? // Olah untuk combo suku
	OpenDb();
	$sql_suku="SELECT suku,urutan,replid FROM suku ORDER BY urutan";
	$result_suku=QueryDB($sql_suku);
	while ($row_suku = mysqli_fetch_array($result_suku)) {
	//	if($suku_kiriman=="")
	//	$suku_kiriman=$row_suku['suku'];
		
		
	?>
	<option value="<?=$row_suku['suku']?>" <?=StringIsSelected($row_suku['suku'], $suku_kiriman)?> ><?=$row_suku['suku']?></option>
	<?
    } 
	CloseDb();
	// Akhir Olah Data suku
	?>
    </select>
	
    <img src="../images/ico/tambah.png" onclick="tambah_suku();" onMouseOver="showhint('Tambah Suku!', this, event, '50px')" />