<?
 ?>
<?
header("Content-type: image/jpeg");

require_once('../include/config.php');
require_once('../include/db_functions.php');

$replid = (int)$_REQUEST['replid'];
$table = $_REQUEST['table'];
$field = "";
if (isset($_REQUEST['field']))
	$field = $_REQUEST['field'];

if ($replid != 0)
{
	OpenDb();
	
	$query = "SELECT foto FROM $table WHERE replid = $replid";
	$result = QueryDb($query);
	$num = mysqli_num_rows($result);
	if ($row = mysqli_fetch_array($result))
	{
		if ($row['foto']) 
		{
			echo $row['foto'];
		}
		else 
		{
			$filename = "../images/ico/no_image.png";
			$contents = "";
			
			if ($handle = @fopen($filename, "r"))
			{
				$contents = @fread($handle, filesize($filename));
				@fclose($handle);
			}
	
			echo $contents;
		}
	}
	CloseDb();	
}
?>