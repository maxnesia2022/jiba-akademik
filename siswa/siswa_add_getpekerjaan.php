<?
 ?>
<?
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$pekerjaan_kiriman=$_REQUEST['pekerjaan'];
?>
	<select name="pekerjaanayah" id="Infopekerjaanayah" class="ukuran"  onKeyPress="return focusNext('Infopekerjaanibu', event)" onfocus="panggil('Infopekerjaanayah')" style="width:140px">
    <option value="">[Pilih Pekerjaan]</option>
      <? 
	OpenDb();
	
	$sql_kerja_ibu="SELECT pekerjaan FROM jenispekerjaan ORDER BY pekerjaan";
	$result_kerja_ibu=QueryDB($sql_kerja_ibu);
	while ($row_kerja_ibu = mysqli_fetch_array($result_kerja_ibu)) {
	//if ($pekerjaan_kiriman=="")
	//$pekerjaan_kiriman=$row_kerja_ibu['pekerjaan'];
	?>
      <option value="<?=$row_kerja_ibu['pekerjaan']?>"<?=StringIsSelected($row_kerja_ibu['pekerjaan'],$pekerjaan_kiriman)?>><?=$row_kerja_ibu['pekerjaan']?></option>
      <?
    } 
	CloseDb();
	// Akhir Olah Data sekolah
	?>
	</select>