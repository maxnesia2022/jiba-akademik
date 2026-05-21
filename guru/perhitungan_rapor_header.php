<?
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Aturan Perhitungan Nilai Rapor</title>
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript" src="../script/validasi.js"></script>
<script language="javascript">
function caripegawai() {
	parent.perhitungan_rapor_footer.location.href = "../blank2.php";
	parent.perhitungan_rapor_content.location.href = "blank_rapor.php";
	newWindow('../library/guru.php?flag=0', 'CariPegawai','600','590','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function acceptPegawai(nip, nama, flag) {
	document.getElementById('nip').value = nip;	
	document.getElementById('nama').value = nama;	
	parent.perhitungan_rapor_footer.location.href = "../guru/perhitungan_rapor_footer.php?nip="+nip+"&nama="+nama;
	parent.perhitungan_rapor_content.location.href = "../guru/blank_rapor.php";
}

function validate() {
	return validateEmptyText('nip', 'NIP Guru');
}

</script>
</head>
<body leftmargin="5" topmargin="5" style="background-color:#f5f5f5">
<form name="main" enctype="multipart/form-data" >
<strong>Pilih Guru</strong>
<table width="100%" border="0">
			
  <tr>
    <td><strong>NIP</strong></td>
    <td><input type="text" name="nip" id="nip" size="10" class="disabled" readonly value="<?=$nip ?>"  onClick="caripegawai()"/>&nbsp;&nbsp;
    <a href="JavaScript:caripegawai()" onmouseover="showhint('Cari Guru!', this, event, '80px')"><img src="../images/ico/lihat.png" border="0"/></a>
    </td>
    </tr>
  <tr>
    <td><strong>Nama</strong></td>
    <td><input type="text" name="nama" id="nama" size="25" class="disabled" readonly value="<?=$nama ?>"  onClick="caripegawai()"/></td>
    </tr>
</table>

</form>

</body>
</html>