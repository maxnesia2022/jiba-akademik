<?
 ?>
<?
$departemen=$_REQUEST['departemen'];
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];


?>
<frameset cols="37%,*" border="1" framespacing="yes" frameborder="yes">
<frameset rows="140,*" border="1" framespacing="yes" frameborder="no">
<frame src="alumni_menu.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="alumni_menu" scrolling="No" noresize="noresize" id="alumni_menu" title="alumni_menu" style="border:1; border-bottom-color:#000000; border-bottom-style:solid"/>
<frame src="blank_alumni.php" name="alumni_pilih" id="alumni_pilih" title="alumni_pilih" />
</frameset> 
<frame src="alumni_content.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>" name="alumni_content" id="alumni_content" title="alumni_content" style="border:1; border-left-color:#000000; border-left-style:solid"/>
</frameset><noframes></noframes>