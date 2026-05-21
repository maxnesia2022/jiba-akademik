<?
 ?>
<? 
require_once('../include/errorhandler.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$kondisi_kiriman=$_REQUEST['kondisi'];
?>
<select name="kondisi" id="kondisi" class="ukuran" onKeyPress="return focusNext('warga', event)">
 	<option value="">[Pilih Kondisi]</option>
    <? // Olah untuk combo kondisi
	OpenDb();
	$sql_kondisi="SELECT kondisi,urutan FROM kondisisiswa ORDER BY urutan";
	$result_kondisi=QueryDB($sql_kondisi);
	while ($row_kondisi = mysqli_fetch_array($result_kondisi)) {
	//if ($kondisi_kiriman=="")
	//$kondisi_kiriman=$row_kondisi['kondisi'];
	?>
	<option value="<?=$row_kondisi['kondisi']?>"<?=StringIsSelected($row_kondisi['kondisi'],$kondisi_kiriman)?> >
	<?=$row_kondisi['kondisi']?></option>
	<?
    } 
	CloseDb();
	// Akhir Olah Data kondisi
	?>
    </select>&nbsp;<img src="../images/ico/tambah.png" onClick="tambah_kondisi();" />