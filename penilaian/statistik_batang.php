<?
 ?>
<?
require_once('../include/config.php');
require_once('../include/db_functions.php');
//include("../library/class/jpgraph.php");
//include("../library/class/jpgraph_bar.php");
//include("../library/class/jpgraph_line.php");
//require_once("../include/chartfactory.php");


OpenDb();
$sql = "SELECT k.kelas, round(SUM(nilaiujian)/(COUNT(DISTINCT u.replid)*COUNT(DISTINCT s.nis)),2) AS rata FROM nilaiujian n, siswa s, ujian u, jenisujian j, kelas k, tahunajaran a WHERE n.idujian = u.replid AND u.idsemester = '$_REQUEST[semester]' AND u.idkelas = k.replid AND u.idjenis = '$_REQUEST[ujian]' AND u.idrpp = '$_REQUEST[rpp]' AND u.idpelajaran = '$_REQUEST[pelajaran]' AND s.nis = n.nis AND u.idjenis = j.replid AND s.idkelas = k.replid AND s.aktif = 1 AND k.idtingkat = '$_REQUEST[tingkat]' AND k.aktif = 1 AND k.idtahunajaran = a.replid AND a.aktif = 1 GROUP BY k.replid ORDER BY k.kelas, u.tanggal, s.nama";
echo "ada nih".$sql;


$title = "Rata-rata Nilai Ujian Kelas per RPP";
$xtitle = "Kelas";
$ytitle = "Rata-rata Nilai Ujian";


/*$CF = new ChartFactory();
$CF->SqlData($sql, $title, $xtitle, $ytitle);
if ($type == "bar")
	$CF->DrawBarChart();
elseif($type == "pie")
	$CF->DrawPieChart();
*/
?>