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

header('Content-Type: application/vnd.ms-excel'); //IE and Opera  
header('Content-Type: application/x-msexcel'); // Other browsers  
header('Content-Disposition: attachment; filename=LaporanPresensiKegiatanSiswa.xls');
header('Expires: 0');  
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

$nis = $_REQUEST['nis'];
$bulan = $_REQUEST['bulan'];
$tahun = $_REQUEST['tahun'];

OpenDb();

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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS AKADEMIK [Cetak Laporan Presensi Kegiatan Siswa]</title>
<style type="text/css">
<!--
.style1 {
	font-size: 16px;
	font-family: Verdana;
}
.style4 {font-family: Verdana; font-weight: bold; font-size: 12px; }
.style5 {font-family: Verdana}
.style6 {font-size: 12px}
.style7 {font-family: Verdana; font-size: 12px; }
-->
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="0">
<tr>
    <th scope="row" colspan="8"><span class="style1">Rekapitulasi Presensi Kegiatan Siswa</span></th>
</tr>
</table>
<br />

<table width="27%">
<tr>
	<td><span class="style4">Siswa</span></td>
    <td width="57%" colspan="7"><span class="style4">: <?= $nis .' - '. $nama ?></span></td>
</tr>
</table>
<br />

<?
$showbutton = false;
require_once("presensikeg.rekapsiswa.report.func.php");
?>

</body>
</html>