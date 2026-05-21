<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
OpenDb();
$sql = "SELECT replid,proses FROM prosespenerimaansiswa WHERE aktif=1 AND departemen='$_REQUEST[departemen]'";				
$result = QueryDb($sql);
CloseDb();
$row = mysqli_fetch_array($result);
$proses = $row['replid'];

?>
<input type="text" name="nama_proses" id="nama_proses" style="width:270px;" class="disabled" value="<?=$row['proses']?>" readonly />
<input type="hidden" name="proses" id="proses"  value="<?=$proses?>" />

<!--
<select name="kondisi" id="kondisi" class="ukuran">
    <? // Olah untuk combo kondisi
/*	$kondisi_kiriman=$_REQUEST['kondisi_kiriman'];
	OpenDb();
	$sql_kondisi="SELECT kondisi,urutan FROM kondisisiswa ORDER BY urutan";
	$result_kondisi=QueryDB($sql_kondisi);
	while ($row_kondisi = mysqli_fetch_array($result_kondisi)) {
	if ($kondisi_kiriman=="")
	$kondisi_kiriman=$row_kondisi['kondisi'];*/
	?>
	<option value="<?=$row_kondisi['kondisi']?>"<?=StringIsSelected($row_kondisi['kondisi'],$kondisi_kiriman)?> >
	<?=$row_kondisi['kondisi']?></option>
	<?
    //} 
	//CloseDb();
	// Akhir Olah Data kondisi
	?>
    </select>&nbsp;<img src="../images/ico/tambah.png" onClick="tambah_kondisi();" />-->