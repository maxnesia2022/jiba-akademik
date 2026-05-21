<?
 ?>
<?
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

$departemen=$_REQUEST['departemen'];
$idangkatan=$_REQUEST['idangkatan'];
$iddasar=$_REQUEST['iddasar'];

for ($i=1;$i<=17;$i++) {
   if ($iddasar == $i) {
	$dasar = $kriteria[$i];
	$judul = $kriteria_judul[$i];	
	$tabel = $kriteria_tabel[$i];
	//$file = $kriteria_file[$i];
   }				
}

if ($departemen=="-1" && $idangkatan<0)
	$kondisi=" AND a.replid=s.idangkatan ";
if ($departemen<>"-1" && $idangkatan<0)
	$kondisi=" AND a.departemen='$departemen' AND a.replid=s.idangkatan ";
if ($departemen<>"-1" && $idangkatan>0)
	$kondisi=" AND s.idangkatan='$idangkatan' AND a.replid=s.idangkatan AND a.departemen='$departemen' ";
	
	OpenDb();
	$sql = "SELECT s.replid FROM siswa s, angkatan a WHERE s.aktif = 1 $kondisi";
	$result = QueryDb($sql);
	if (mysqli_num_rows($result) > 0) {
?>
<frameset cols="55%,*" frameborder="yes" border="1">
    <frame name="grafik" src="grafik.php?dasar=<?=$dasar?>&departemen=<?=$departemen?>&idangkatan=<?=$idangkatan?>&iddasar=<?=$iddasar?>&tabel=<?=$tabel?>"  id="batang_statistik">
	<frameset rows="50%,*" frameborder="yes" border="1">
		<!--<frame name="table_statistik" src="statistik_table.php?departemen=<?=$departemen?>&idangkatan=<?=$idangkatan?>&iddasar=<?=$iddasar?>&nama_judul=<?=$judul?>dasar=<?=$dasar?>&tabel=<?=$tabel?>" target="table_statistik" allowtransparency="yes"  id="table_statistik" scrolling="auto">-->
		<frame name="table_statistik" src="statistik_table.php?dasar=<?=$dasar?>&departemen=<?=$departemen?>&idangkatan=<?=$idangkatan?>&tabel=<?=$tabel?>&nama_judul=<?=$judul?>&iddasar=<?=$iddasar?>" id="table_statistik" scrolling="auto" >
		<frame name="detail_statistik" src="../blank_white.php" id="detail_statistik" scrolling="auto">
	</frameset>
</frameset>

<noframes></noframes>
</html>
<?	} else { ?>
<head>
<link rel="stylesheet" type="text/css"  href="../style/style.css">
</head>
<body>
<table border="0" width="100%" align="center">
<!-- TABLE CENTER -->
<tr height="300">
	<td align="left" valign="top" style="background-repeat:no-repeat; background-image:url(../images/ico/b_statistik.png)">
    <table width="100%" border="0" height="100%">
   	<tr>
  		<td align="center">
		<font size = "2" color ="red"><b>Tidak ditemukan adanya data.<br />
	Tambah data siswa pada departemen <?=$departemen?> di menu Pendataan Siswa pada bagian Pendataan Siswa. 
		</b></font>        
    	</td>
  	</tr>
	</table>
</tr>
</table>

	</td>
</tr>
</table>
</body>
<?	} ?>