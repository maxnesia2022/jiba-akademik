<?
 ?>
<?
//include('../cek.php');
require_once('../include/config.php');
require_once('../include/common.php');
require_once('../include/db_functions.php');
//require_once('../library/departemen.php');
$departemen = $_POST["departemen"];
OpenDb();
?>
<select name="kelas" id="kelas" onChange="kelas()" style="width:150px">
            <?	$sql="SELECT k.replid,k.kelas FROM kelas k,tahunajaran ta,tingkat ti WHERE k.idtahunajaran=ta.replid AND k.idtingkat=ti.replid AND ti.departemen='$departemen' AND ta.departemen='$departemen' AND k.aktif=1 ORDER BY k.kelas";
			$result=QueryDb($sql);
			while ($row=@mysqli_fetch_array($result)){
					if ($kelas == "")
						$kelas = $row[replid]; 
						?>
            <option value="<?=$row[replid] ?>" <?=StringIsSelected($row[replid], $kelas) ?> >
            <?=$row[kelas] ?>
            </option>
            <?	} ?>
          </select>