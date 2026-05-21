<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../library/datearith.php');
require_once('../cek.php');
require_once('presensikeg.rekapguru.func.php');

$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];
$nip = $_REQUEST['nip'];

OpenDb();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rekapitulasi Presensi Kegiatan Guru</title>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/jquery-1.9.1.js"></script>
<script language="javascript" src="presensikeg.rekapguru.report.js"></script>
</head>

<body>
<br>
<input type='hidden' id='bulan' value='<?=$bulan?>'>
<input type='hidden' id='tahun' value='<?=$tahun?>'>
<input type='hidden' id='nip' value='<?=$nip?>'>      
<?
$showbutton = true;
require_once("presensikeg.rekapguru.report.func.php");
?>
</body>
</html>
<?
CloseDb();
?>
<script language='JavaScript'>
    //Tables('table', 1, 0);
</script>