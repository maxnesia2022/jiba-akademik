<?
 ?>
<?
$NIS = $_REQUEST['nis'];
?>
<frameset cols = "250, *" border="0" frameborder="yes" framespacing="yes">
    <frame src = "rataus.left.php?oldnis=<?=$NIS?>" name ="left" noresize scrolling="auto" style="border:1; border-color:#000000; border-bottom-style:solid">
    <frame src = "../blank.php" name = "right" noresize scrolling="auto"/>
    </frameset><noframes></noframes>
</html>