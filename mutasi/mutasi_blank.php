<?
 ?>
<html>
<head>
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../style/style.css"></head>
</html>
<html>
<head>
</head>
<body>
<table width="100%" border="0" height="100%">
<? if (isset($_REQUEST["from_left"])){?>
<tr>
  <td height="34" align="right" valign="top"><font size="4" face="Verdana, Arial, Helvetica, sans-serif" style="background-color:#ffcc66">&nbsp;</font>&nbsp;<font size="4" face="Verdana, Arial, Helvetica, sans-serif" color="Gray">Mutasi Siswa</font><br />
      <a href="../mutasi.php" target="content"> <font size="1" color="#000000"><b>Mutasi</b></font></a>&nbsp>&nbsp<font size="1" color="#000000"><b>Mutasi Siswa</b></font></td>
</tr>
<? } ?>
<tr>
    <td align="center" valign="middle" background="../images/ico/b_daftarmutasi.png"
    style="background-repeat:no-repeat;">
        <font size="2" color="#757575"><b>
        <? if (isset($_REQUEST["from_left"])){?>
        Pilih Siswa yang akan dimutasi di panel kiri 
        <? } else { ?>
        Pilih Departemen dan Tahun Mutasi sesuai dengan Daftar Mutasi Siswa yang akan ditampilkan
		<? } ?>
        </b></font> </td>
</tr>

</table>
</body>
</html>