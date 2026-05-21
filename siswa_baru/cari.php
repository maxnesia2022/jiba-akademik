<?
 ?>
<?
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');

OpenDb();
$jenis=$_REQUEST['jenis'];
	if ($jenis == 'darah' || $jenis == 'kondisi' || $jenis == 'status' || $jenis == 'agama' || $jenis == 'suku') {	
		if ($jenis == 'darah') {
			$row = array('A','0','B','AB');
			$jum = 4;
?>				
			<select name="cari" id="cari" onchange="change_cari()" style="width:150px;">
<? 			for ($i=0;$i<$jum;$i++) { 	 ?>
        		<option value="<?=$row[$i]?>" <?=StringIsSelected($row[$i], $cari)?> ><?=$row[$i]?></option>
              	
<? 			} ?>   
        	</select>
<? 		} else if ($jenis == 'kondisi') {								
			$query = "SELECT kondisisiswa FROM kondisisiswa ORDER BY kondisisiswa ";
			$result = QueryDb($query);			
		} elseif ($jenis == 'status') {	
			$query = "SELECT status FROM statussiswa ORDER BY statusiswa ";
			$result = QueryDb($query);
		} elseif ($jenis == 'agama' || $jenis == 'suku') {		
			$query = "SELECT $jenis FROM $jenis ORDER BY $jenis";
			$result = QueryDb($query);
		}

?>		<select name="cari" id="cari" onchange="change_cari()" style="width:150px;">
<?		while ($row = mysqli_fetch_row($result)) {	?>
   			<option value="<?=$row[0]?>" <?=StringIsSelected($row[0], $cari)?> ><?=$row[0]?></option>
<? 		} ?>    
         </select>

<?	}	else { 	 ?>
    	<input type="text" name="cari" id="cari" size="15"  />
        
<? 	} 
	
CloseDb();

?>