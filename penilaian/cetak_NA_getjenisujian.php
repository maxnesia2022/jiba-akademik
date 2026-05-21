<?
 ?>
<?
require_once("../include/theme.php"); 
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
OpenDb();
$dasar_penilaian=$_REQUEST["dasarpenilaian"];
$departemen=$_REQUEST["departemen"];
$tahunajaran=$_REQUEST["tahunajaran"];
$semester=$_REQUEST["semester"];
$tingkat=$_REQUEST["tingkat"];
$kelas=$_REQUEST["kelas"];
$pelajaran=$_REQUEST["pelajaran"];
$nip=$_REQUEST["nip"];
?>
<div align="right">
<select name="jen_uji" id="jen_uji" onchange="jen_uji()" style="width:150px">
			  <?
			  $sql_jenispengujian="SELECT * FROM aturannhb WHERE idtingkat='$tingkat' AND idpelajaran='$pelajaran' AND aktif=1 AND dasarpenilaian='$dasar_penilaian' AND nipguru='$nip'";
			  $result_jenispengujian=QueryDb($sql_jenispengujian);
			   if (@mysqli_num_rows($result_jenispengujian)>0){
			  while ($row_jenispengujian=@mysqli_fetch_array($result_jenispengujian)){
				$sql_jenisuji="SELECT jenisujian FROM jenisujian WHERE replid='$row_jenispengujian[idjenisujian]'";
				$result_jenisuji=QueryDb($sql_jenisuji);
				$row_jenisuji=@mysqli_fetch_array($result_jenisuji);
				?>
    		    <option value="<?=urlencode($row_jenispengujian['replid'])?>" <? //IntIsSelected($row['replid'], $kelas) ?>>
   		        <?=$row_jenisuji['jenisujian']?>
   		        </option>
				<?
			  }
				} else {
			  echo "<option value='' > - - - </option>";
			  }
			  ?>
  		    </select>
			</div>