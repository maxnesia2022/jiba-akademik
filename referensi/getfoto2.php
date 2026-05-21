<?
 ?>
<?
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../include/imageresizer.php');

$foto1 = $_FILES['foto'];
$uploadedfile = $foto1['tmp_name'];
$uploadedtypefile = $foto1['type'];
$uploadedsizefile = $foto1['size'];
if (strlen($uploadedfile) != 0)
{
	$tmp_path = realpath(".") . "/../../temp";
	$tmp_exists = file_exists($tmp_path) && is_dir($tmp_path);
	if (!$tmp_exists)
		mkdir($tmp_path, 0755);
	
	$filename = "$tmp_path/ad-logo-tmp.jpg";
	ResizeImage($foto1, 100, 90, 80, $filename);
}
?>
<script language="javascript">
	setTimeout("kembali()",1);
</script>
<script language="javascript">
function kembali(){
	document.location.href = "logo2.php?gbrbaru=1&departemen=<?=$_REQUEST['departemen']?>";
}	
</script>