<?
 ?>
<? $departemen = $_REQUEST['departemen']; ?>
<frameset rows="85,*" border="1" framespacing="yes" frameborder="yes">
		<frame src="mutasi_siswa_header.php?departemen=<?=$departemen?>" name="mutasi_siswa_header" scrolling="No" noresize="noresize" id="mutasi_siswa_header" title="mutasi_siswa_header" style="border:1; border-bottom-color:#000000; border-bottom-style:solid" />
		<frame src="blank_mutasi_all.php" name="mutasi_siswa_footer" scrolling="no" noresize="noresize" id="mutasi_siswa_footer" title="mutasi_siswa_footer"/>
</frameset><noframes></noframes>