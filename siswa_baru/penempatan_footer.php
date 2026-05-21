<?
 ?>
<?
$dep = $_REQUEST['departemen'];
$proses = $_REQUEST['proses'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Guru Footer</title>
</head>
<frameset cols = "60%, *" border ="1" framespacing="0">
	<frameset rows = "120,60%" border ="0" framespacing="0" >
		<frame src = "penempatan_menu.php?departemen=<?=$dep?>&proses=<?=$proses?>" name ="menu" />	
		<frame src = "blank_penempatan_daftar.php" name ="daftar"/>
	</frameset>
	<frame src = "penempatan_content.php?departemen=<?=$dep?>&proses=<?=$proses?>&aktif=0" name ="isi"/>
</frameset>
</html>