<?
 ?>
<? 
$departemen = $_REQUEST['departemen'];
$semester = $_REQUEST['semester'];	
$tingkat = $_REQUEST['tingkat'];
$kelas = $_REQUEST['kelas'];
$bln =  (int)substr($_REQUEST['tanggal'],3,2);
$thn =  (int)substr($_REQUEST['tanggal'],6,4);


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
function pilih(replid) {		
	opener.parent.header.location.href = "presensi_header.php?replid="+replid;
	opener.parent.footer.location.href = "presensi_footer.php?replid="+replid;
	window.close();
}
	
</script>	 
</head>

<frameset rows = "30%, *" border="1">
    <frame src = "presensi_lihat_header.php?departemen=<?=$departemen?>&semester=<?=$semester?>&tingkat=<?=$tingkat?>&kelas=<?=$kelas?>&bln=<?=$bln?>&thn=<?=$thn?>" name = "header" noresize scrolling="no" />
    <frame src = "presensi_lihat_footer.php?semester=<?=$semester?>&kelas=<?=$kelas?>&bln=<?=$bln?>&thn=<?=$thn?>&pelajaran=-1" name = "footer" noresize scrolling="no" />
    </frameset><noframes></noframes>
</html>