<?
 ?>
<?
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('departemen.php');

OpenDb();
?>
<table width="100%" id="table" class="tab" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
<tr height="30">
	<td class="header" width="7%" align="center">No</td>
    <td class="header" width="15%" align="center">N I S</td>
    <td class="header" >Nama</td>
	<td class="header" >Kelas</td>
	<td class="header" height="30">&nbsp;</td>
</tr>
<?

$kelas = $_REQUEST['kelas'];
$sql = "SELECT s.nis, s.nama, k.kelas FROM siswa s,kelas k WHERE s.aktif=1 AND k.replid=s.idkelas AND s.statusmutasi=0 AND s.idkelas='$kelas'  ORDER BY s.nama"; 
$result = QueryDb($sql);
$cnt = 1;
	
while($row = mysqli_fetch_row($result)) {
if ($cnt%2==0)
	$bg="bgcolor='#e7e7cf'";
if ($cnt%2==1)
	$bg="bgcolor='#ffffff'";
	?>
<tr>
	<td height="25" align="center" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$cnt ?></td>
    <td height="25" align="center" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[0] ?></td>
    <td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[1] ?></td>
	<td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer"><?=$row[2] ?></td>
	<td height="25" <?=$bg?> onClick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')" style="cursor:pointer" align="center"><input type="button" value="Pilih" onclick="ambilpilih('<?=$row[0]?>','<?=$row[1]?>')"  class="but"></td>
</tr>
<?
$cnt++;
}
CloseDb();	
if (mysqli_num_rows($result) == 0) { ?>
<tr height="26"><td colspan="4" align="center"><em>Tidak ditemukan data</em></td></tr>
<? } ?>

</table>