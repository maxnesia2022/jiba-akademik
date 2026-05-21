<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../include/exceldata.php');
require_once('../cek.php');

if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
if (isset($_REQUEST['tahunajaran'])) 
	$tahunajaran = $_REQUEST['tahunajaran'];
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];
//$nis = $_REQUEST['nis'];
$varbaris=20;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];
	
$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];

$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

$urut = "nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	
$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];
	
OpenDb();

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
if ($op == "dw8dxn8w9ms8zs22") 
{
	$sql = "UPDATE siswa SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
	QueryDb($sql);
} 
else if ($op == "xm8r389xemx23xb2378e23") 
{
    $success = true;
    BeginTrans();

    $sql = "SELECT nis FROM siswa WHERE replid = '$_REQUEST[replid]'";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $nis = $row[0];

    $sql = "DELETE FROM tambahandatasiswa WHERE nis = '$nis'";
    QueryDbTrans($sql, $success);

    if ($success)
    {
        $sql = "DELETE FROM riwayatfoto WHERE nis = '$nis'";
        QueryDbTrans($sql, $success);
    }

    if ($success)
    {
        $sql = "DELETE FROM siswa WHERE replid = '$_REQUEST[replid]'";
        QueryDbTrans($sql, $success);
    }

	if ($success) 
	{
		$sql = "SELECT * FROM calonsiswa WHERE replidsiswa = '$_REQUEST[replid]'";
		$result = QueryDb($sql);
		if (mysqli_num_rows($result) > 0) 
		{
			$sql = "UPDATE calonsiswa SET replidsiswa = NULL WHERE replidsiswa = '$_REQUEST[replid]'";
            QueryDbTrans($sql, $success);
		}
	}

    if ($success)
	    CommitTrans();
    else
        RollbackTrans();
	
	if ($success) 
	{	?>
		<script>refresh();</script> 
<?	} 
}	
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pendataan Siswa</title>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Legacy CSS (For tooltips mostly) -->
<link rel="stylesheet" type="text/css" href="../style/style.css">
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">

<!-- Legacy JS Scripts -->
<script language="JavaScript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc; /* slate-50 */
        margin: 0;
        padding: 16px;
    }
    
    /* Mencegah JIBAS class .tab dan scripts mengacaukan struktur tailwind */
    .tab { border: none !important; }
    .tab td, .tab th { border: none !important; }
</style>

<script language="javascript">

function refresh() {	
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var kelas = document.getElementById('kelas').value;
	var tingkat = document.getElementById('tingkat').value;
	
	document.location.href = "siswa_content.php?tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen;
}

function tambah() {
	var departemen = document.getElementById('departemen').value;
	var kelas = document.getElementById('kelas').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	newWindow('siswa_add.php?departemen='+departemen+'&kelas='+kelas+'&tahunajaran='+tahunajaran+'&tingkat='+tingkat, 'TambahSiswa','905','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function edit(replid, nis) {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var kelas = document.getElementById('kelas').value;
	var tingkat = document.getElementById('tingkat').value;
	newWindow('siswa_edit.php?replid='+replid+'&departemen='+departemen+'&tahunajaran='+tahunajaran+'&kelas='+kelas+'&tingkat='+tingkat, 'UbahSiswa','905','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function hapus(replid, nis) {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var kelas = document.getElementById('kelas').value;
	var tingkat = document.getElementById('tingkat').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	if (confirm('Apakah anda yakin akan menghapus siswa ini?'))
		document.location.href = "siswa_content.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&nis="+nis+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function change_urut(urut,urutan) {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var kelas = document.getElementById('kelas').value;
	var tingkat = document.getElementById('tingkat').value;
	
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	document.location.href = "siswa_content.php?tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function cetak() {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var kelas = document.getElementById('kelas').value;
	var tingkat = document.getElementById('tingkat').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	var total=document.getElementById("total").value;
	
	newWindow('siswa_cetak.php?departemen='+departemen+'&tahunajaran='+tahunajaran+'&tingkat='+tingkat+'&kelas='+kelas+'&urut='+urut+'&urutan='+urutan+'&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function exel(){
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var kelas = document.getElementById('kelas').value;
	var tingkat = document.getElementById('tingkat').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	
	newWindow('siswa_cetak_excel.php?departemen='+departemen+'&tahunajaran='+tahunajaran+'&tingkat='+tingkat+'&kelas='+kelas+'&urut='+urut+'&urutan='+urutan, 'CetakSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function tampil(replid) {
	newWindow('../library/detail_siswa.php?replid='+replid, 'DetailSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function refresh_after_add(){
	var departemen = document.getElementById('departemen').value;
	var kelas = document.getElementById('kelas').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	
	document.location.href = "siswa_content.php?tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function setaktif(replid, aktif) {
	var msg;
	var newaktif;
	var departemen = document.getElementById('departemen').value;
	var kelas = document.getElementById('kelas').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	var kapasitas = document.getElementById('kapasitas').value;
	var isi = document.getElementById('isi').value;
		
	if (aktif == 1) {
		msg = "Apakah anda yakin akan mengubah  siswa ini menjadi TIDAK AKTIF?";
		newaktif = 0;
	} else	{	
		msg = "Apakah anda yakin akan mengubah siswa ini menjadi AKTIF?";
		newaktif = 1;
	}
	
	if (confirm(msg)) {
		document.location.href = "siswa_content.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
		parent.header.location.href = "siswa_header.php?tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&departemen="+departemen+"&kelas="+kelas;
	}
}

function change_page(page) {
	var departemen = document.getElementById('departemen').value;
	var kelas = document.getElementById('kelas').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href = "siswa_content.php?tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&page="+page+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris+"&hal="+page;
}

function change_hal() {
	var departemen = document.getElementById("departemen").value;
	var kelas = document.getElementById('kelas').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="siswa_content.php?tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function change_baris() {
	var departemen = document.getElementById("departemen").value;
	var kelas = document.getElementById('kelas').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href= "siswa_content.php?tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

</script>
</head>
<body class="text-slate-700 antialiased selection:bg-emerald-200">

<div class="w-full max-w-full">
    <!-- Hidden Inputs -->
    <input type="hidden" name="departemen" id="departemen" value="<?=$departemen ?>" />
    <input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran ?>" />
    <input type="hidden" name="kelas" id="kelas" value="<?=$kelas ?>" />
    <input type="hidden" name="tingkat" id="tingkat" value="<?=$tingkat ?>" />
    <input type="hidden" name="urut" id="urut" value="<?=$urut ?>" />
    <input type="hidden" name="urutan" id="urutan" value="<?=$urutan ?>" />

    <?
	$sql_tot = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,s.aktif,DAY(tgllahir),MONTH(tgllahir),YEAR(tgllahir),s.replid,s.nisn FROM siswa s, kelas k, tahunajaran t WHERE s.idkelas = '$kelas' AND k.idtahunajaran = '$tahunajaran' AND k.idtingkat = '$tingkat' AND s.idkelas = k.replid AND t.replid = k.idtahunajaran AND s.alumni=0 ORDER BY replid ";
	$result_tot = QueryDb($sql_tot);
	$total=ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
	$jumlah = mysqli_num_rows($result_tot);
	$akhir = ceil($jumlah/5)*5;
	
	$sql = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,s.aktif,DAY(tgllahir),MONTH(tgllahir),YEAR(tgllahir),s.replid,s.statusmutasi,s.alumni,s.nisn FROM siswa s, kelas k, tahunajaran t WHERE s.idkelas = '$kelas' AND k.idtahunajaran = '$tahunajaran' AND k.idtingkat = '$tingkat' AND s.idkelas = k.replid AND t.replid = k.idtahunajaran AND s.alumni=0 ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
	$result = QueryDb($sql);
	
	if (@mysqli_num_rows($result)>0){ 
		$sql_kapasitas = "SELECT kapasitas FROM kelas WHERE replid = '$kelas'";
		$result_kapasitas = QueryDb($sql_kapasitas);
		$row_kapasitas = mysqli_fetch_row($result_kapasitas);
		$kapasitas = $row_kapasitas[0];
		
		$sql_siswa = "SELECT COUNT(*) FROM siswa WHERE idkelas = '$kelas' AND aktif = 1";
		$result_siswa = QueryDb($sql_siswa);
		$row_siswa = mysqli_fetch_row($result_siswa);
		$isi = $row_siswa[0];
	?>
    
    <input type="hidden" name="total" id="total" value="<?=$total?>"/>
    <input type="hidden" name="kapasitas" id="kapasitas" value="<?=$kapasitas?>"/>
    <input type="hidden" name="isi" id="isi" value="<?=$isi?>"/>
    
    <!-- Top Action Toolbar -->
    <div class="flex flex-wrap items-center justify-end gap-3 mb-4">
        <button type="button" onClick="refresh()" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" onMouseOver="showhint('Refresh Data!', this, event, '80px')">
            <img src="../images/ico/refresh.png" class="w-4 h-4 opacity-80" /> Refresh
        </button>
        <button type="button" onClick="exel()" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" onMouseOver="showhint('Ekspor data ke Excel!', this, event, '120px')">
            <img src="../images/ico/excel.png" class="w-4 h-4 opacity-80" /> Cetak Excel
        </button>
        <button type="button" onClick="cetak()" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-300 rounded-md shadow-sm text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" onMouseOver="showhint('Cetak Data Siswa!', this, event, '100px')">
            <img src="../images/ico/print.png" class="w-4 h-4 opacity-80" /> Cetak
        </button>
        <button type="button" onClick="tambah()" class="inline-flex items-center gap-2 px-4 py-1.5 bg-emerald-600 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" onMouseOver="showhint('Tambah Data Baru!', this, event, '100px')">
            <img src="../images/ico/tambah.png" class="w-4 h-4 filter brightness-0 invert" /> Tambah Data Siswa
        </button>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-4">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-slate-600" id="table">
                <thead class="text-xs text-emerald-950 uppercase bg-emerald-100/80 border-b border-emerald-200">
                    <tr>		
                        <th scope="col" class="px-4 py-3.5 text-center font-bold w-[4%]">No</th>
                        
                        <th scope="col" class="px-4 py-3.5 font-bold cursor-pointer hover:bg-emerald-200/80 transition-colors whitespace-nowrap w-[10%]" onClick="change_urut('nis','<?=$urutan?>')">
                            <div class="flex items-center justify-between">N I S <?=change_urut('nis',$urut,$urutan)?></div>
                        </th>
                        
                        <th scope="col" class="px-4 py-3.5 font-bold cursor-pointer hover:bg-emerald-200/80 transition-colors whitespace-nowrap w-[10%]" onClick="change_urut('nisn','<?=$urutan?>')">
                            <div class="flex items-center justify-between">N I S N <?=change_urut('nisn',$urut,$urutan)?></div>
                        </th>
                        
                        <th scope="col" class="px-4 py-3.5 font-bold cursor-pointer hover:bg-emerald-200/80 transition-colors whitespace-nowrap" onClick="change_urut('nama','<?=$urutan?>')">
                            <div class="flex items-center justify-between">Nama <?=change_urut('nama',$urut,$urutan)?></div>
                        </th>
                        
                        <th scope="col" class="px-4 py-3.5 font-bold cursor-pointer hover:bg-emerald-200/80 transition-colors whitespace-nowrap w-[15%]" onClick="change_urut('asalsekolah','<?=$urutan?>')">
                            <div class="flex items-center justify-between">Asal Sekolah <?=change_urut('asalsekolah',$urut,$urutan)?></div>
                        </th>
                        
                        <th scope="col" class="px-4 py-3.5 font-bold cursor-pointer hover:bg-emerald-200/80 transition-colors whitespace-nowrap w-[20%]" onClick="change_urut('tgllahir','<?=$urutan?>')">
                            <div class="flex items-center justify-between">Tempat Tanggal Lahir <?=change_urut('tgllahir',$urut,$urutan)?></div>
                        </th>
                        
                        <th scope="col" class="px-4 py-3.5 font-bold cursor-pointer hover:bg-emerald-200/80 transition-colors whitespace-nowrap text-center w-[8%]" onClick="change_urut('aktif','<?=$urutan?>')">
                            <div class="flex items-center justify-center gap-1">Status <?=change_urut('aktif',$urut,$urutan)?></div>
                        </th>
                        
                        <th scope="col" class="px-4 py-3.5 text-center font-bold w-[12%]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <? 
                    CloseDb();
                    if ($page==0){
                        $cnt = 1;
                    }else{ 
                        $cnt = (int)$page*(int)$varbaris+1;
                    }
                    while ($row = @mysqli_fetch_row($result)) {
                    ?>	
                    <tr class="hover:bg-emerald-50/50 transition-colors bg-white group">        			
                        <td class="px-4 py-2.5 text-center font-medium text-slate-500"><?=$cnt?></td>
                        <td class="px-4 py-2.5 text-center font-semibold text-slate-700"><?=$row[0]?></td>
                        <td class="px-4 py-2.5 text-slate-600"><?=$row[12]?></td>
                        <td class="px-4 py-2.5 font-bold text-emerald-900"><?=$row[1]?></td>
                        <td class="px-4 py-2.5 text-slate-600"><?=$row[2]?></td>
                        <td class="px-4 py-2.5 text-slate-600"><?=$row[3].', '.$row[6].'&nbsp;'.NamaBulan($row[7]).'&nbsp;'.$row[8]?></td>
                        <td class="px-4 py-2.5 text-center">
                            <? if ($row[10] == 0) { ?>
                                <? if (SI_USER_LEVEL() == $SI_USER_STAFF) {  			
                                    if ($row[5] == 1) { ?> 
                                        <span class="inline-flex drop-shadow-sm" onMouseOver="showhint('Status Aktif!', this, event, '80px')">
                                            <img src="../images/ico/aktif.png" class="w-5 h-5"/>
                                        </span>
                                    <? } else { ?>                
                                        <span class="inline-flex drop-shadow-sm opacity-50 grayscale" onMouseOver="showhint('Status Tidak Aktif!', this, event, '80px')">
                                            <img src="../images/ico/nonaktif.png" class="w-5 h-5"/>
                                        </span>
                                    <? }
                                } else {	
                                    if ($row[5] == 1) {	?>
                                        <a href="JavaScript:setaktif(<?=$row[9] ?>, <?=$row[5] ?>)" class="inline-flex drop-shadow-sm hover:scale-110 transition-transform" onMouseOver="showhint('Status Aktif!', this, event, '80px')">
                                            <img src="../images/ico/aktif.png" class="w-5 h-5"/>
                                        </a>
                                    <? } else { 
                                        if ($kapasitas > $isi) { ?>
                                            <a href="JavaScript:setaktif(<?=$row[9] ?>, <?=$row[5] ?>)" class="inline-flex drop-shadow-sm opacity-60 hover:opacity-100 hover:scale-110 transition-all" onMouseOver="showhint('Status Tidak Aktif!', this, event, '80px')">
                                                <img src="../images/ico/nonaktif.png" class="w-5 h-5"/>
                                            </a>
                                        <? } else { ?>
                                            <span class="inline-flex drop-shadow-sm opacity-40 grayscale cursor-not-allowed" onMouseOver="showhint('Status siswa tidak dapat diaktifkan karena kapasitas kelas tidak mencukupi!', this, event, '165px')">
                                                <img src="../images/ico/nonaktif.png" class="w-5 h-5"/>
                                            </span>
                                        <? }
                                    } 
                                } 
                            } else {
                                if ($row[5] == 1) { ?> 
                                    <span class="inline-flex drop-shadow-sm" onMouseOver="showhint('Status Aktif!', this, event, '80px')">
                                        <img src="../images/ico/aktif.png" class="w-5 h-5"/>
                                    </span>
                                <? } else { ?>                
                                    <span class="inline-flex drop-shadow-sm opacity-50 grayscale" onMouseOver="showhint('Sudah di mutasi!', this, event, '80px')">
                                        <img src="../images/ico/nonaktif.png" class="w-5 h-5"/>
                                    </span>
                                <? }
                            } ?>        	
                        </td>
                        <td class="px-4 py-2.5">
                            <div class="flex items-center justify-center gap-1.5 opacity-80 group-hover:opacity-100 transition-opacity">
                                <a href="JavaScript:tampil(<?=$row[9]?>)" class="p-1.5 hover:bg-sky-100 rounded-md transition-colors" onMouseOver="showhint('Detail Data Siswa!', this, event, '80px')">
                                    <img src="../images/ico/lihat.png" class="w-4 h-4"/>
                                </a>        
                                <a href="#" onClick="newWindow('siswa_cetak_detail.php?replid=<?=$row[9]?>', 'DetailSiswa','800','650','resizable=1,scrollbars=1,status=0,toolbar=0')" class="p-1.5 hover:bg-slate-200 rounded-md transition-colors" onMouseOver="showhint('Cetak Detail Data Siswa!', this, event, '80px')">
                                    <img src="../images/ico/print.png" class="w-4 h-4"/>
                                </a>
                                <a href="JavaScript:edit(<?=$row[9]?>)" class="p-1.5 hover:bg-amber-100 rounded-md transition-colors" onMouseOver="showhint('Ubah Data Siswa!', this, event, '80px')">
                                    <img src="../images/ico/ubah.png" class="w-4 h-4"/>
                                </a>
                            <? 	if (SI_USER_LEVEL() != $SI_USER_STAFF) {	?>             	
                                <a href="JavaScript:hapus(<?=$row[9] ?>,'<?=$row[0] ?>')" class="p-1.5 hover:bg-rose-100 rounded-md transition-colors" onMouseOver="showhint('Hapus Data Siswa!', this, event, '80px')">
                                    <img src="../images/ico/hapus.png" class="w-4 h-4"/>
                                </a>
                            <?	} ?>
                            </div>
                        </td>
                    </tr>
                    <?		
                        $cnt++; 
                    } 
                    ?>			
                </tbody>
            </table>
        </div>
    </div>
    
    <script language='JavaScript'>
	    // Script JIBAS legacy 
        if(typeof Tables === "function") {
            Tables('table', 1, 0);
        }
    </script>

    <!-- Pagination Settings -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 bg-white border border-slate-200 rounded-xl shadow-sm text-sm font-medium">
        <div class="flex items-center gap-3 text-slate-600">
            <span>Halaman</span>
            <select name="hal" id="hal" onChange="change_hal()" class="form-select text-sm border border-slate-300 rounded-md shadow-sm bg-slate-50 px-3 py-1.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 cursor-pointer transition-colors hover:bg-white">
                <? for ($m=0; $m<$total; $m++) {?>
                    <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
                <? } ?>
            </select>
            <span>dari <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100"><?=$total?></span> halaman</span>
        </div>
        
        <div class="flex items-center gap-3 text-slate-600">
            <span>Jumlah baris per halaman:</span>
            <select name="varbaris" id="varbaris" onChange="change_baris()" class="form-select text-sm border border-slate-300 rounded-md shadow-sm bg-slate-50 px-3 py-1.5 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 cursor-pointer transition-colors hover:bg-white">
                <? 	for ($m=10; $m <= 100; $m=$m+10) { ?>
                    <option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
                <? 	} ?>
            </select>
        </div>
    </div>

    <?	} else { ?>

    <!-- Empty State -->
    <div class="flex flex-col items-center justify-center min-h-[300px] bg-white rounded-xl border border-slate-200 shadow-sm mt-4 p-8 text-center">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4 text-slate-400">
            <i class="fa-solid fa-folder-open text-2xl"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-700 mb-1">Data Siswa Tidak Ditemukan</h3>
        <p class="text-slate-500 font-medium mb-6">Belum ada data yang tersimpan di sistem untuk filter saat ini.</p>
        
        <? //if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <button onClick="tambah()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md shadow-sm transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500/50 font-medium transform active:scale-95">
            <i class="fa-solid fa-plus text-sm"></i> Isi Data Baru
        </button>
        <? //} ?>
    </div>
    
    <? } ?> 

</div>
<?
CloseDb();
?>
</body>
</html>