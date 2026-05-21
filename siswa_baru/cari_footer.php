<?
 ?>
<?
$dep = $_REQUEST['departemen'];
$jenis = $_REQUEST['jenis'];
$cari = $_REQUEST['cari'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Guru Footer</title>
</head>
	<frameset cols = "25%, *" border ="1">
    <frame src = "cari_menu.php?departemen=<?=$dep?>&jenis=<?=$jenis?>&cari=<?=$cari?>" name ="menu"  scrolling="no"/>
    <frame src = "../blank2.php" name ="isi" scrolling="no"/>
    </frameset><noframes></noframes>

<body>
</body>
</html>