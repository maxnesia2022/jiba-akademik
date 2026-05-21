<?
 ?>
<?
$idkegiatan = $_REQUEST['idkegiatan'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];
?>
<frameset cols="360,*" border="1" frameborder="yes" framespacing="yes">
<frame src="presensikeg.siswa2.siswa.php?idkegiatan=<?=$idkegiatan?>&bulan=<?=$bulan?>&tahun=<?=$tahun?>"
       name="siswa"
       style="border-width: 1px; border-bottom-color:#000000; border-bottom-style:solid" />
<frame src="presensikeg.blank.php" name="report" />
</frameset>
<noframes></noframes>