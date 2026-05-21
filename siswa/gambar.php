<?
 ?>
<?
/* gambar.php */
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
$nis=$_REQUEST['nis'];
OpenDb();
header("Content-type: image/jpeg");
$query = "SELECT foto FROM siswa WHERE nis = '$nis'";
$result = QueryDb($query);
$num = @mysqli_num_rows($result);
//while ($row = mysqli_fetch_array($result)) {
  if ($row = mysqli_fetch_array($result)) {
    if($row['foto']) {
        echo $row['foto'];
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