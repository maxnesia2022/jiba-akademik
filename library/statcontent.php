<?
 ?>
<?
$key = $_REQUEST["key"];
$keyword = $_REQUEST["keyword"];
$departemen = $_REQUEST["departemen"];
$kode = $_REQUEST["kode"];
?>
<frameset cols="60%,*" border="1" frameborder="1" framespacing="0">
	<frame name="statgrafik" src="statgrafik.php?key=<?=$key?>&keyword=<?=$keyword?>&departemen=<?=$departemen?>&kode=<?=$kode?>">
    <frameset rows="150,*" border="1" frameborder="1" framespacing="0">
	    <frame name="stattabel" src="stattabel.php?key=<?=$key?>&keyword=<?=$keyword?>&departemen=<?=$departemen?>&kode=<?=$kode?>" />
        <frame name="statdetail" src="blank.php" />
    </frameset>
</frameset><noframes></noframes>