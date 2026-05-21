<?
 ?>
<?
$departemen=$_REQUEST['departemen'];
$tahunawal=$_REQUEST['tahunawal'];
$tahunakhir=$_REQUEST['tahunakhir'];
?>
<frameset rows="*"  cols="619,*" border="1" frameborder="yes">
	<frame src="grafik.php?departemen=<?=$departemen?>&tahunawal=<?=$tahunawal?>&tahunakhir=<?=$tahunakhir?>" name="kiri"  style="border:1; border-right-color:#000000; border-right-style:solid" />
    <frame src="statistik_mutasi_table.php?departemen=<?=$departemen?>&tahunawal=<?=$tahunawal?>&tahunakhir=<?=$tahunakhir?>" name="kanan" />
</frameset>
<noframes></noframes>