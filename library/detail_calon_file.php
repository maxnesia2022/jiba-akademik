<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/rupiah.php');

$replid = $_REQUEST['replid'];

OpenDb();
$sql = "SELECT filedata, filename, filemime, filesize FROM tambahandatacalon WHERE replid = $replid";
$res = QueryDb($sql);
if ($row = mysqli_fetch_array($res))
{
    $filedata = $row['filedata'];
    $filename = $row['filename'];
    $filemime = $row['filemime'];
    $filesize = $row['filesize'];

    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-Type: $filemime");
    header("Content-Disposition: attachment; filename=\"$filename\";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: $filesize");
    ob_clean();
    flush();
    echo $filedata;
}
CloseDb();
?>