<?
 ?>
<?
$departemen=$_REQUEST['departemen'];
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];
?>
<frameset cols="52%,*" border="1" framespacing="yes" frameborder="yes">
<frameset rows="110,*" border="1" framespacing="yes" frameborder="no">
<frame src="siswa_kenaikan_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="siswa_kenaikan_menu" scrolling="No" noresize="noresize" id="siswa_kenaikan_menu" title="siswa_kenaikan_menu" style="border:1; border-bottom-color:#000000; border-bottom-style:solid"/>
<frame src="blank_kenaikan.php" name="siswa_kenaikan_pilih" id="siswa_kenaikan_pilih" title="siswa_kenaikan_pilih" />
</frameset> 
<frame src="siswa_kenaikan_tujuan.php?departemen=<?=$departemen?>&tingkatawal=<?=$tingkat?>&tahunajaranawal=<?=$tahunajaran?>" name="siswa_kenaikan_tujuan" id="siswa_kenaikan_tujuan" title="siswa_kenaikan_tujuan" style="border:1; border-left-color:#000000; border-left-style:solid"/>
</frameset><noframes></noframes>