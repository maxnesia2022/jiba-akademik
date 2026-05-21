<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/theme.php');
require_once('../include/compatibility.php');
require_once('../cek.php');
require_once('uploader.func.php');

$op = $_REQUEST['op'];
if ($op == "showuploaddialog")
{
    require_once("uploader.upload.dialog.php");
    
    http_response_code(200);
}
elseif ($op == "showlist")
{
    ShowList();
}
?>