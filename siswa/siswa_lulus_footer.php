<?
 ?>
<?
$departemen=$_REQUEST['departemen'];
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];
?>
<frameset cols="52%,*" border="1" framespacing="yes" frameborder="yes">
<frameset rows="110,*" border="1" framespacing="yes" frameborder="no">
<frame src="siswa_lulus_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="siswa_lulus_menu" scrolling="No" noresize="noresize" id="siswa_lulus_menu" title="siswa_lulus_menu" style="border:1; border-bottom-color:#000000; border-bottom-style:solid"/>
 <frame src="blank_lulus.php" name="siswa_lulus_pilih" id="siswa_lulus_pilih" title="siswa_lulus_pilih" />
</frameset> 
<frame src="siswa_lulus_tujuan.php?departemenawal=<?=$departemen?>&tahunajaranawal=<?=$tahunajaran?>" name="siswa_lulus_tujuan" id="siswa_lulus_tujuan" title="siswa_lulus_tujuan" style="border:1; border-left-color:#000000; border-left-style:solid" />
</frameset><noframes></noframes>