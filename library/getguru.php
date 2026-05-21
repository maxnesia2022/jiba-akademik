<?
 ?>
<?
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');

$nip = $_REQUEST['nip'];
$nama = $_REQUEST['nama'];
$pelajaran = $_REQUEST['pelajaran'];
?>
<table cellpadding="0" width="100%">
<tr>
	<td width="17%"><strong>Guru yang Mengajar</strong></td>
    <td>
    <input type="text" name="nipguru" id="nipguru" size="15" class="disabled" value="<?=$nip ?>" readonly onClick="pegawai()"/>
    <input type="text" name="namaguru" id="namaguru" size="30" class="disabled" value="<?=$nama ?>" readonly onClick="pegawai()"/>
    <input type="hidden" name="nip" id="nip" value="<?=$nip ?>" />
    <input type="hidden" name="nama" id="nama" value="<?=$nama ?>" /> 
    <a href="JavaScript:pegawai()"><img src="../images/ico/cari.png" border="0" /></a>
    </td>
</tr>
<tr>
	<td><strong>Status Guru</strong></td>
    <td>
    	<select name="jenis" id="jenis" style="width:150px;" onKeyPress="return focusNext('keterangan', event)">
    <?	OpenDb();
		$sql = "SELECT s.replid,s.status FROM statusguru s, guru g WHERE g.nip = '$nip' AND g.idpelajaran = $pelajaran AND g.statusguru = s.status ORDER BY status";	
		
		$result = QueryDb($sql);
		CloseDb();
	
		while($row = mysqli_fetch_array($result)) {
			if ($jenis == "")
				$jenis = $row['replid'];				
			?>
          <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $jenis) ?>>
            <?=$row['status']?>
            </option>
          <?
			} //while
			?>
        </select>    
	</td>
</tr>
</table>