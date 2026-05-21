<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');

$departemen = $_REQUEST['departemen'];
$pelajaran = $_REQUEST['pelajaran'];
?>
<select name="pelajaran" id="pelajaran" onKeyPress="return focusNext('jam2', event)">
   	<?	OpenDb();
		$sql = "SELECT replid,nama FROM pelajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY nama";
		$result = QueryDb($sql);
		CloseDb();
		while ($row = @mysqli_fetch_array($result)) {
			if ($pelajaran == "") 				
				$pelajaran = $row['replid'];			
		?>
        
    	<option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $pelajaran)?> ><?=$row['nama']?></option>
                  
    <?	} ?>
</select>