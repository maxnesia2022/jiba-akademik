<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$idrpp=$_REQUEST['rpp'];
OpenDb();
?>
<select name="idrpp" id="idrpp" style="width:170px;" onkeypress="return focusNext('deskripsi', event)">
<option value="" <?=IntIsSelected("", $idrpp) ?> >Tanpa RPP</option>
<? 
	$sql_rpp="SELECT * FROM rpp WHERE idtingkat=$_REQUEST[tingkat] AND idsemester=$_REQUEST[semester] AND idpelajaran=$_REQUEST[pelajaran] AND aktif=1 ORDER BY rpp";
	$result_rpp=QueryDb($sql_rpp);
	while ($row_rpp=@mysqli_fetch_array($result_rpp)){
		//if($idrpp=="")
		//	$idrpp=$row_rpp['replid'];
?>
		<option value="<?=$row_rpp['replid'] ?>" <?=IntIsSelected($row_rpp['replid'], $idrpp) ?> ><?=$row_rpp['rpp'] ?>
		</option>
<? } ?>

	</select>
	<img src="../images/ico/tambah.png" onClick="get_rpp('<?=$_REQUEST['tingkat']?>','<?=$_REQUEST['pelajaran']?>','<?=$_REQUEST['semester']?>')" onMouseOver="showhint('Tambah RPP!', this, event, '80px')">