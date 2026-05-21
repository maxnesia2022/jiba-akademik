<?
 ?>
<html>
<head>
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<body>
<table width="100%" border="0" height="100%" >
<tr height="250">
    <td align="center" valign="top" background="../images/ico/b_daftarmutasi.png"
    style="background-repeat:no-repeat;">
    <table border="0"width="100%" height="100%">
    <tr>
    	<td align="center"><? if ($_REQUEST['tipe']=="harian") { ?>
          <font size="2" color="#757575"><b>Klik ikon <img src="../images/ico/view_x.png" border="0"> di
        atas untuk menampilkan Laporan Presensi Harian Per Kelas</b></font>
          <? } else { ?>
          <font size="2" color="#757575"><b>Klik icon <img src="../images/ico/view_x.png" border = "0"> di atas untuk menampilkan
        Laporan Presensi Siswa Per Kelas</b></font>
          <? } ?></td>
   	</tr>
    </table>
    </td>
</tr>
</table>
</body>
</html>