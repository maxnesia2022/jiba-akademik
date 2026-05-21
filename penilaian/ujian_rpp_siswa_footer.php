<?
 ?>
<?
$kelas=$_REQUEST['kelas'];
$semester=$_REQUEST['semester'];
$pelajaran=$_REQUEST['pelajaran'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> Content Penentuan Nilai Rapor </TITLE>
</HEAD>
<frameset cols="18%,*" border="1" frameborder="0" framespacing = "0">
    <frame name="menu" src="ujian_rpp_siswa_menu.php?kelas=<?=$kelas?>&semester=<?=$semester?>&pelajaran=<?=$pelajaran?>" >
    <frame name="content" src="../blank.php" style="border:1px; border-left-color:#000000; border-left-style:solid">
</frameset><noframes></noframes>
</HTML>