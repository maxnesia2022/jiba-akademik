<?
 ?>
<?
require_once('../include/config.php');
require_once('../include/db_functions.php');
OPenDb();
$departemen=$_REQUEST['departemen']; 
$tahunawal=$_REQUEST['tahunawal'];
$tahunakhir=$_REQUEST['tahunakhir'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<link href="../style/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../script/tools.js"></script>
</head>

<body leftmargin="0" topmargin="0">


<div align="center">
  <a href="#" onclick="newWindow('cetak_statistik_mutasi.php?departemen=<?=$departemen?>&tahunawal=<?=$tahunawal?>&tahunakhir=<?=$tahunakhir?>','s',750,650,'scrollbars=1')" /><img src="../images/ico/print.png" border="0" /><strong>Cetak</strong></a></div>
<table width="100%" border="0">
  <tr>
    <td><div align="center" id="batang">
	<?
	$querysuku = "SELECT COUNT(*) As Jum,j.jenismutasi As jenismutasi FROM mutasisiswa m,jenismutasi j,angkatan a,siswa s WHERE	a.departemen='$departemen' AND s.idangkatan=a.replid AND m.nis=s.nis AND s.statusmutasi=m.jenismutasi AND m.jenismutasi=j.replid AND YEAR(m.tglmutasi) >= '$tahunawal' AND YEAR(m.tglmutasi) <= '$tahunakhir' GROUP BY jenismutasi";
$resultsuku = QueryDb($querysuku);
if (@mysqli_num_rows($resultsuku)>0){
	?>
    <img src="gambar_statistik.php?departemen=<?=$departemen?>&tahunawal=<?=$tahunawal?>&tahunakhir=<?=$tahunakhir?>"/></div></td>
  <? } else { ?>
  <img src="../images/ico/blank_statistik.png"/></div></td>
  <?
	}
	?>
  </tr>
</table>
</body>
</html>