<?
 ?>
<?
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
$departemen=$_REQUEST['departemen'];
?>
		<select name="dep_asal" id="dep_asal"  onKeyPress="return focusNext('sekolah', event)" onChange="ubah_dep_sekolah_asal()">
        <option value="">[Departemen]</option>
      	<? // Olah untuk combo sekolah
		OpenDb();
		$sql_dep_asal="SELECT departemen FROM departemen ORDER BY urutan";
		$result_dep_asal=QueryDB($sql_dep_asal);
		while ($row_dep_asal = mysqli_fetch_array($result_dep_asal)) {
			if ($departemen=="")
				$departemen=$row_dep_asal['departemen'];
		?>
       <option value="<?=$row_dep_asal['departemen']?>" <?=StringIsSelected($row_dep_asal['departemen'],$departemen)?>>
        <?=$row_dep_asal['departemen']?>
        </option>
      <?
    	} 
		CloseDb();
		// Akhir Olah Data sekolah
		?>
    	</select>