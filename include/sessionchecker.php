<?
 ?>
<?
session_name("jbsakad");
session_start();

if (!isset($_SESSION['login']))
{
	if (file_exists("index.php")) 
	   $addr = "index.php";
	elseif (file_exists("../index.php")) 
	   $addr = "../index.php";
	elseif(file_exists("../../index.php")) 
	   $addr = "../../index.php";
	else	
	   $addr = "../../../index.php";
	?>
	<script language="javascript">
		if (self != self.top)
		{
			top.window.location.href='<?=$addr ?>';
		}
		else if (self.name != "")
		{
			window.close();
			opener.top.window.location.href='<?=$addr ?>';
		}
		else
		{
			window.location.href='<?=$addr ?>';	
		}
	</script>
	<?
	exit();	
}  
?>