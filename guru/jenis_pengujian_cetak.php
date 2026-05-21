<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/getheader.php');
$id = $_REQUEST['id'];
OpenDb();
$sql = "SELECT j.replid,j.jenisujian,j.idpelajaran,j.keterangan,p.replid,p.nama,p.departemen,j.info1 FROM jenisujian j, pelajaran p WHERE j.idpelajaran = '$id' AND p.replid=j.idpelajaran ";   
$result = QueryDb($sql);
$cnt = 0;
$row = @mysqli_fetch_row($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Cetak Jenis Pengujian]</title>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($row[6])?>

<center>
  <font size="3"><strong>DATA JENIS PENGUJIAN</strong></font><br />
 </center>
<br />
    <br />
<strong>
Pelajaran  : <?=$row[5]?>
<br />
Departemen : <?=$row[6]?>
<br /><br /><br /></strong>
<table class="tab" id="table" border="1" cellpadding="2" style="border-collapse:collapse" cellspacing="2" width="100%" align="left" bordercolor="#000000">
    <!-- TABLE CONTENT -->
    <tr height="30">
    	<td width="4%" class="header" align="center">No</td>
        <td width="30%" class="header" align="center">Singkatan</td>
		<td width="30%" class="header" align="center">Jenis Pengujian</td>
        <td width="47%" class="header" align="center">Keterangan</td>
    </tr>
    
     <?
		OpenDb();
		$sql = "SELECT j.replid,j.jenisujian,j.idpelajaran,j.keterangan,p.replid,p.nama,p.departemen,j.info1 FROM jenisujian j, pelajaran p WHERE j.idpelajaran = '$id' AND j.idpelajaran = p.replid ORDER BY j.jenisujian";   
		$result = QueryDb($sql);
		$cnt = 0;
		while ($row = @mysqli_fetch_row($result)) {
		?>
    <tr>   	
       	<td align="center"><?=++$cnt ?></td>
        <td align="center"><?=$row[7]?></td>
		<td align="center"><?=$row[1]?></td>
        <td><?=$row[3]?></td>        
    </tr>
<?	} 
	CloseDb(); ?>	
    
    <!-- END TABLE CONTENT -->
    </table>

</td></tr></table>
</body>
<script language="javascript">
window.print();
</script>
</html>