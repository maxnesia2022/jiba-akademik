<?
 ?>
<?
if(isset($_GET['departemen'])){
	$file1 = "filter_penentuan.php?departemen=$_GET[departemen]&tingkat=$_GET[tingkat]&semester=$_GET[semester]&kelas=$_GET[kelas]";
	$file2 = "penentuan_footer.php?departemen=$_GET[departemen]&tingkat=$_GET[tingkat]&semester=$_GET[semester]&kelas=$_GET[kelas]";
}else{
	$file1 = "filter_penentuan.php";
	$file2 = "blank_penentuan.php";
}
?>
<frameset rows="90,*" border="1" frameborder="0" framespacing="0">
    <frame name="filter_penentuan" src="filter_penentuan.php" target="filter_penentuan"  scrolling="no" style="border:1px; border-bottom-color:#000000; border-bottom-style:solid">
    <frame name="penentuan_footer" src="blank_penentuan.php">
</frameset><noframes></noframes>
</html>