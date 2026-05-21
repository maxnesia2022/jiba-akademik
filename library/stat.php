<?
 ?>
<?
/*
Kalo dari kesiswaan, kode=0
Kalo dari calonsiswa, kode=1

*/
$kode="";
if (isset($_REQUEST[kode])){
	$kode=$_REQUEST[kode];
	}
?>
<frameset rows="65,*" border="1">
	<frame name="statheader" src="statheader.php?kode=<?=$kode?>" scrolling="no" />
    <frame name="statcontent" src="blank.php" />
</frameset><noframes></noframes>