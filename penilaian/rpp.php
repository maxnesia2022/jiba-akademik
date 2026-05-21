<?
 ?>
<?
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/theme.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
OpenDb();
if(isset($_REQUEST["semester"]))
	$semester = $_REQUEST["semester"];
if(isset($_REQUEST["tingkat"]))
	$tingkat = $_REQUEST["tingkat"];
if(isset($_REQUEST["departemen"]))
	$departemen = $_REQUEST["departemen"];		
if(isset($_REQUEST["pelajaran"]))
	$pelajaran = $_REQUEST["pelajaran"];
    ?>
<select name="idrpp" id="idrpp"><!---->
                  <?
				  $sql_rpp="SELECT * FROM rpp WHERE idtingkat='$tingkat' AND idsemester='$semester' AND idpelajaran='$pelajaran' AND aktif=1";
				  $result_rpp=QueryDb($sql_rpp);
				  while ($row_rpp=@mysqli_fetch_array($result_rpp)){
				  ?>
                  <option value="<?=$row_rpp['replid']?>"><?=$row_rpp['rpp']?></option>
                  <?
				  }
				  ?>
                  </select><!---->
                  <!--<input type="text" name="rpp" id="rpp" size="25" readonly onClick="get_rpp('<?=$row_dep['departemen']?>','<?=$row_get_nhb['idtingkat']?>','<?=$semester?>','<?=$row_get_nhb['idpelajaran']?>')"><input type="hidden" name="idrpp" id="idrpp" size="25"--><img src="../images/ico/tambah.png" onClick="get_rpp('<?=$departemen?>','<?=$tingkat?>','<?=$semester?>','<?=$pelajaran?>')" onMouseOver="showhint('Cari RPP!', this, event, '120px')">
                  <?
				  CloseDb();
				 ?>