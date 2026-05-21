<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

$pendidikan_kiriman = $_REQUEST['pendidikan'];
// Olah untuk combo sekolah
?>
	<select name="pendidikanayah" id="Infopendidikanayah" class="ukuran"  onKeyPress="return focusNext('Infopendidikanibu', event)" onfocus="panggil('Infopendidikanayah')" style="width:140px">
	<option value="">[Pilih Pendidikan]</option>
<?
	OpenDb();
	$sql="SELECT pendidikan FROM tingkatpendidikan ORDER BY pendidikan";
	$result=QueryDB($sql);
	CloseDb();
	while ($row = mysqli_fetch_array($result)) {
	//if ($pendidikan_kiriman=="")
	//	$pendidikan_kiriman=$row['pendidikan'];
		?>
     	 <option value="<?=$row['pendidikan']?>"<?=StringIsSelected($row['pendidikan'],$pendidikan_kiriman)?> >
		 <?=$row['pendidikan']?></option>
   	<? } ?> 
	</select>