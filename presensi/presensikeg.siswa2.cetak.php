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
require_once('../include/getheader.php');

OpenDb();

$nis = $_REQUEST['nis'];
$idkegiatan = $_REQUEST['idkegiatan'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];

$sql = "SELECT departemen
          FROM tahunajaran t, kelas k, siswa s
         WHERE s.nis = '$nis'
           AND s.idkelas = k.replid
           AND k.idtahunajaran = t.replid";
$res = QueryDb($sql);
$row = mysqli_fetch_row($res);
$departemen = $row[0];

$sql = "SELECT nama
          FROM siswa
         WHERE nis = '$nis'";   
$res = QueryDB($sql);	
$row = mysqli_fetch_row($res);
$nama = $row[0];
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS AKADEMIK [Cetak Laporan Presensi Kegiatan Siswa]</title>
</head>

<body>
    
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr>
	<td align="left" valign="top" colspan="2">
		<?=getHeader($departemen)?>
		<center>
			<font size="4"><strong>LAPORAN PRESENSI KEGIATAN SISWA</strong></font><br />
		</center>
		<br /><br />
	</td>
</tr>	
<tr>
	<td width='60'><strong>Siswa</strong></td>
    <td><strong>: <?= $nis . ' - ' . $nama ?></strong></td>
</tr>
<tr>
	<td align="left" valign="top" colspan="2">

<?
	$showbutton = false;
	require_once("presensikeg.siswa2.report.func.php");
?>        
    </td>
</tr>	        
</table>

</body>
</html>
<script type="text/javascript">
	window.print();
</script>