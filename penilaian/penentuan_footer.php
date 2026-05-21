<?
 ?>
<?
$departemen=$_REQUEST['departemen'];
$tingkat=$_REQUEST['tingkat'];
$tahun=$_REQUEST['tahun'];
$semester=$_REQUEST['semester'];
$kelas=$_REQUEST['kelas'];
$nip=$_REQUEST['nip'];
?>
<frameset cols="15%,*" border="1" frameborder="0" framespacing="0">
    <frame name="penentuan_menu" src="penentuan_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahun=<?=$tahun?>&semester=<?=$semester?>&kelas=<?=$kelas?>&nip=<?=$nip?>"
           target="penentuan_menu" style="border:1px; border-bottom-color:#000000; border-bottom-style:solid">
    <frame name="penentuan_content" src="blank_penentuan_content.php" style="border:1px; border-left-color:#000000; border-left-style:solid">
</frameset><noframes></noframes>