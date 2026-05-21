<?
 ?>
<?
$departemen=$_REQUEST['departemen'];
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];
?>
<frameset cols="37%,*" border="1" framespacing="yes" frameborder="yes">
<frameset rows="140,*" border="1" framespacing="yes" frameborder="no">
<frame src="mutasi_siswa_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="mutasi_siswa_menu" scrolling="No" noresize="noresize" id="mutasi_siswa_menu" title="mutasi_siswa_menu" style="border:1; border-bottom-color:#000000; border-bottom-style:solid"/>
<frame src="blank_mutasi.php" name="mutasi_siswa_pilih" id="mutasi_siswa_pilih" title="mutasi_siswa_pilih" scrolling="yes"/>
</frameset> 
<frame src="mutasi_siswa_content.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="mutasi_siswa_tujuan" id="mutasi_siswa_tujuan" title="mutasi_siswa_tujuan" style="border:1; border-left-color:#000000; border-left-style:solid"/>
</frameset><noframes></noframes>