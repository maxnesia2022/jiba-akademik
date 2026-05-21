<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

OpenDb();
$query = "SELECT urutan FROM departemen WHERE departemen = '$_REQUEST[departemen]'";	
$hasil = QueryDb($query);	
CloseDb();
$row = mysqli_fetch_array($hasil);
$urutan = $row['urutan'];


?>
<select name="dep_asal" id="dep_asal" onchange="change_departemen(0)">
<? // Olah untuk combo departemen
	
	OpenDb();
	$sql_departemen="SELECT departemen,urutan FROM departemen WHERE urutan < '$urutan' ORDER BY urutan DESC LIMIT 1";			
	$result_departemen=QueryDB($sql_departemen);
	if (mysqli_num_rows($result_departemen) == 0) {
		$dep_asal = $departemen;
	} else {	
		$row_departemen = @mysqli_fetch_array($result_departemen);	
		$dep_asal = $row_departemen['departemen'];
	}
				
							
	?>
	<option value="<?=$row_departemen['departemen']?>" <?=StringIsSelected($row_departemen['departemen'], $dep_asal)?>><?=$row_departemen['departemen']?></option>
	<? //	} 
		CloseDb();
		// Akhir Olah Data kondisi
	?>
</select>