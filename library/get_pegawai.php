<?
 ?>
<?
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
//$departemen="-1";

	$departemen=$_REQUEST['departemen'];
	if ($departemen=="-1"){
	$sql_tambahan="";
	} else {
	$sql_tambahan="AND pel.departemen='$departemen'";
	}


?>
<table width="100%" id="table" class="tab" align="center" cellpadding="2" cellspacing="0">
<tr height="30" bordercolor="#000000">
<td class="header" width="7%" align="center">No</td>
    		<td class="header" width="15%" align="center">N I P</td>
    		<td class="header" >Nama</td>
    		<td class="header" width="10%">&nbsp;</td>
		</tr>
		<?
		OpenDb();
		$sql = "SELECT p.nip, p.nama FROM pegawai p, pelajaran pel, guru g WHERE pel.replid=g.idpelajaran AND g.nip=p.nip ".$sql_tambahan;
		//$sql = "SELECT p.nip, p.nama FROM pegawai p LEFT JOIN (guru g LEFT JOIN pelajaran l ON l.replid = g.idpelajaran) ON p.nip = g.nip GROUP BY p.nip";
		$result = QueryDb($sql);
		$cnt = 0;
		while($row = mysqli_fetch_row($result)) { ?>
		<tr>
			<td align="center"><?=++$cnt ?></td>
    		<td align="center"><?=$row[0] ?></td>
    		<td><?=$row[1] ?></td>
    		<td align="center">
    		<input type="button" name="pilih" class="but" id="pilih" value="Pilih" onclick="pilih('<?=$row[0]?>', '<?=$row[1]	?>')" />
    	   	</td>
		</tr>
		<? 	} ?>
		<tr height="26">
			<td colspan="4" align="center" >
        	<input type="button" class="but" name="tutup" id="tutup" value="Tutup" onclick="window.close()" /></td>
		</tr>	
		</table>