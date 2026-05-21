<?
 ?>
<?
$departemen=$_REQUEST['departemen'];
$tahunakhir=$_REQUEST['tahunakhir'];
$tahunawal=$_REQUEST['tahunawal'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../style/style.css" rel="stylesheet" type="text/css">
</head>
<frameset cols="55%,*" border="0">
<frame src="gambar_statistik.php?departemen=<?=$departemen?>&tahunakhir=<?=$tahunakhir?>&tahunawal=<?=$tahunawal?>" name="statistik_mutasi_isi">
<frame src="../blank4.php" name="statistik_mutasi_kanan">
</frameset>
</html>