<?
 ?>
<? 
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$dep_asal=$_REQUEST['dep_asal'];
$sekolah = $_REQUEST['sekolah'];
?>
	<select name="sekolah" id="sekolah" onKeyPress="return focusNext('ketsekolah', event)" style="width:150px;">
     <option value="">[Pilih Asal Sekolah]</option>
     <? // Olah untuk combo sekolah
	OpenDb();
	$sql_sekolah="SELECT sekolah FROM asalsekolah WHERE departemen='$dep_asal' ORDER BY sekolah";
	$result_sekolah=QueryDB($sql_sekolah);
	while ($row_sekolah = mysqli_fetch_array($result_sekolah)) {
	if ($sekolah=="")
		$sekolah=$row_sekolah['sekolah'];
	?>
       <option value="<?=$row_sekolah['sekolah']?>" <?=StringIsSelected($row_sekolah['sekolah'],$sekolah)?>>
        <?=$row_sekolah['sekolah']?>
        </option>
      <?
    } 
	CloseDb();
	// Akhir Olah Data sekolah
	?>
    </select>