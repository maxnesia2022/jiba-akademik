<?
 ?>
<?
require_once('../include/config.php');
require_once('../include/db_functions.php');

$replid=$_REQUEST['replid'];
$table = $_REQUEST['table'];


OpenDb();
header("Content-type: image/jpeg");
$query = "SELECT foto_sem FROM identitas WHERE replid = 16";

//echo $query;	
$result = QueryDb($query);
$num = @mysqli_num_rows($result);
if ($row = mysqli_fetch_array($result)) {
    if($row[foto_sem]) {
        echo $row[foto_sem];
    }else {
    	$filename = "../images/ico/no_image.png";
        $handle = fopen($filename, "r");
        $contents = fread($handle, filesize($filename));

        echo $contents;
    }
  }
//}
CloseDb();
?>