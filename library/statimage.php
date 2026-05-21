<?
 ?>
<?
require_once("../include/chartfactory.php");
$kode="";
if (isset($_REQUEST['kode']))
$kode = $_REQUEST['kode'];

$departemen = $_REQUEST['departemen'];
$key = $_REQUEST['key'];
$keyword = $_REQUEST['keyword'];
$type = $_REQUEST['type'];

if ($kode==""0){
if ($departemen!="-1")
	$dep="AND p.departemen='$departemen'";

if ($key=="-1")
	$kunci="AND p.replid='$key'";
}

$bulan = array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nop','Des');

//Untuk yang dari calon siswa
if ($kode=="0"){
	if ($keyword=="1"){
		$title = "Jumlah Calon Siswa Aktif Berdasarkan Agama";
		$xtitle = "Agama";
		$ytitle = "Jumlah Calon Siswa";

		$sql = "SELECT c.agama as agama, COUNT(c.nama) FROM calonsiswa c, agama a, prosespenerimaansiswa p WHERE c.aktif=1 AND c.agama=a.agama AND c.idproses=p.replid $kunci GROUP BY c.agama ORDER BY a.urutan";
	}
}

//Untuk yang dari siswa
if ($kode=="1"){
	if ($keyword=="1"){
		$title = "Jumlah Siswa Aktif Berdasarkan Agama";
		$xtitle = "Agama";
		$ytitle = "Jumlah Siswa";

		$sql = "SELECT s.agama as agama, COUNT(s.nis) FROM siswa s, agama a WHERE s.aktif=1 AND s.agama=a.agama GROUP BY s.agama ORDER BY a.urutan";
	}
}


$CF = new ChartFactory();
$CF->SqlData($sql, $title, $xtitle, $ytitle);
if ($type == "bar")
	$CF->DrawBarChart();
elseif($type == "pie")
	$CF->DrawPieChart();
?>