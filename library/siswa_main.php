<?
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Guru Main</title>
<script language="javascript">
function tutup() {
	window.close();
}

function pilih(nis, nama, flag) {	
	opener.acceptSiswa(nis, nama, flag);
	window.close();	
}
	
</script>	 
</head>

<frameset rows = "20%, *" border="0">
    <frame src = "daftarsiswa_header.php" name = "header" scrolling="no" />
    <frame src = "../blank_white.php" name = "footer" noresize scrolling="no" /> ;
    </frameset><noframes></noframes>
</html>