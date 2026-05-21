<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
//require_once('../include/rupiah.php');
$idkelas=$_REQUEST['idkelas'];
?>
<script language="javascript" src="../script/tables.js"></script>
<table width="50%" border="0" cellspacing="0" class="tab" id="table">
  <?
  			if ($urutan=="") {
			$urutan="nis"; }
	
	?>
		
	<?
	//$jenis=$_REQUEST['jenis'];
	
    OpenDb();
		$sql_siswa = "SELECT nis,nama,idkelas from siswa WHERE idkelas='$idkelas' ORDER BY $urutan"; 
		echo $sql_siswa;
		$result_siswa = QueryDb($sql_siswa);
		$cnt_siswa = 1;
		if ($jumlah = mysqli_num_rows($result_siswa)>0) {
			?>
			<tr>
    <td width="70" class="header">No</td>
    <td width="440" class="header">NIS</td>
    <td width="477" class="header">Nama</td>
   

  </tr>
			<?
		while ($row_siswa = @mysqli_fetch_array($result_siswa)) {
		$nis=$row_siswa['nis'];
		$nama=$row_siswa['nama'];
		$idkelas=$row_siswa['idkelas'];
				
				
		?>
  <tr> 
  	<td><?=$cnt_siswa?></td>
    <td><?=$nis?></td>
    <td><a href="#" onClick="newWindow('siswa_tampil.php?nis=<?=$nis?>&departemen=<?=$departemen?>', 'DetailSiswa','782','864','resizable=1,scrollbars=1,status=0,toolbar=0')"><?=$nama?></a></td>
   
    
  </tr>
  <?
			
			
		}
		$cnt_siswa++;
		} else {
			?>
<tr><td align="center" class="header">Tidak ada data yang sesuai dengan pencarian</td></tr>
<?
		
 }
		CloseDb();

?>

</table>
<script language='JavaScript'>
	    Tables('table', 1, 0);
 		</script>