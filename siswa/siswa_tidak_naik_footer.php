<?
 ?>
<?
$departemen=$_REQUEST['departemen'];
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];
?>
<frameset cols="52%,*" border="1" framespacing="yes" frameborder="yes">
<frameset rows="110,*" border="1" framespacing="yes" frameborder="no">
<frame src="siswa_tidak_naik_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="siswa_tidak_naik_menu" scrolling="No" noresize="noresize" id="siswa_tidak_naik_menu" title="siswa_tidak_naik_menu" style="border:1; border-bottom-color:#000000; border-bottom-style:solid" />
<frame src="blank_tidaknaik.php" name="siswa_tidak_naik_pilih" id="siswa_tidak_naik_pilih" title="siswa_tidak_naik_pilih" />
</frameset> 
<frame src="siswa_tidak_naik_tujuan.php?departemen=<?=$departemen?>&tingkatawal=<?=$tingkat?>&tahunajaranawal=<?=$tahunajaran?>" name="siswa_tidak_naik_tujuan" id="siswa_tidak_naik_tujuan" title="siswa_tidak_naik_tujuan" style="border:1; border-left-color:#000000; border-left-style:solid" />
</frameset><noframes></noframes>