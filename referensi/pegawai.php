<?php
// =========================================================================
// INIT & INCLUDE FILES
// =========================================================================
require_once('../include/errorhandler.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../cek.php');

OpenDb();

$bagian = "-1";
if (isset($_REQUEST["bagian"]))
	$bagian=$_REQUEST["bagian"];

$varbaris=20;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];

$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

$op = "";
if (isset($_REQUEST['op']))
	$op = $_REQUEST['op'];

if ($op == "dw8dxn8w9ms8zs22")
{
	$sql = "UPDATE jbssdm.pegawai SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
	QueryDb($sql);
}
else if ($op == "xm8r389xemx23xb2378e23")
{
    $sql = "DELETE FROM jbsakad.riwayatfoto WHERE nip = (SELECT nip FROM jbssdm.pegawai WHERE replid = '$_REQUEST[replid]')";
    QueryDb($sql);

    $sql = "DELETE FROM jbssdm.tambahandatapegawai WHERE nip = (SELECT nip FROM jbssdm.pegawai WHERE replid = '$_REQUEST[replid]')";
    QueryDb($sql);

	$sql = "DELETE FROM jbssdm.pegawai WHERE replid = '$_REQUEST[replid]'";
	$result = QueryDb($sql);

	$page = 0;
	$hal = 0;
}

if ($op == "fdgfde342ft45tgwer34rfwef") {
	$pin = random(5);
	$sql = "UPDATE jbssdm.pegawai SET `$_REQUEST[field]` = '$pin' WHERE nip = '$_REQUEST[nip]'";
	QueryDb($sql);
}

$urut = "nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kepegawaian</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="../script/SpryValidationSelect.js" type="text/javascript"></script>
    <link href="../script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    <script language="javascript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
    function refresh(){
        var bagian=document.getElementById("bagian").value;
        document.location.href = "pegawai.php?bagian="+bagian+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>&urut=<?=$urut?>&urutan=<?=$urutan?>"
    }

    function change_bagian(){
        var bagian=document.getElementById("bagian").value;
        document.location.href="pegawai.php?bagian="+bagian+"&varbaris=<?=$varbaris?>";
    }

    function setaktif(replid, aktif) {
        var bagian=document.getElementById("bagian").value;
        var msg;
        var newaktif;
        
        if (aktif == 1) {
            msg = "Apakah anda yakin akan mengubah status pegawai ini menjadi TIDAK AKTIF?";
            newaktif = 0;
        } else	{	
            msg = "Apakah anda yakin akan mengubah status pegawai ini menjadi AKTIF?";
            newaktif = 1;
        }
        
        if (confirm(msg)) 
            document.location.href = "pegawai.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&bagian="+bagian+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>&urut=<?=$urut?>&urutan=<?=$urutan?>";
    }

    function hapus(replid) {
        var bagian=document.getElementById("bagian").value;
        if (confirm("Apakah anda yakin akan menghapus pegawai ini?"))
            document.location.href = "pegawai.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&bagian="+bagian+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>&urut=<?=$urut?>&urutan=<?=$urutan?>";
    }

    function change_urut(urut,urutan) {	
        var bagian=document.getElementById("bagian").value;
        var varbaris=document.getElementById("varbaris").value;
        
        if (urutan =="ASC"){
            urutan="DESC"
        } else {
            urutan="ASC"
        }
        
        document.location.href="pegawai.php?bagian="+bagian+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris="+varbaris;
    }

    function tambah() {
        var bagian=document.getElementById("bagian").value;
        newWindow('pegawai_add.php?bagian='+bagian, 'TambahPegawai','500','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function lihat(replid) {	
        newWindow('pegawai_view.php?replid='+replid, 'LihatPegawai','790','610','resizable=0,scrollbars=1,status=0,toolbar=0')
    }

    function edit(replid) {
        newWindow('pegawai_edit.php?replid='+replid, 'UbahPegawai','535','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function cetak(urut,urutan) {
        var bagian=document.getElementById("bagian").value;
        var total=document.getElementById("total").value;
        
        newWindow('pegawai_cetak.php?bagian='+bagian+'&urut='+urut+'&urutan='+urutan+'&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakPegawai','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function cetak_detail(replid) {
        newWindow('pegawai_cetak_detail.php?replid='+replid, 'CetakDetailCalonSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function change_page(page) {
        var bagian=document.getElementById("bagian").value;
        var varbaris=document.getElementById("varbaris").value;
        document.location.href="pegawai.php?bagian="+bagian+"&page="+page+"&hal="+page+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }

    function change_hal() {
        var bagian = document.getElementById("bagian").value;
        var hal = document.getElementById("hal").value;
        var varbaris=document.getElementById("varbaris").value;
        document.location.href="pegawai.php?bagian="+bagian+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }

    function change_baris() {
        var bagian = document.getElementById("bagian").value;
        var varbaris=document.getElementById("varbaris").value;
        document.location.href="pegawai.php?bagian="+bagian+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }

    function gantipin(field, nip) {
        if (confirm("Apakah anda yakin akan mengganti PIN ini?")) {
            var bagian = document.getElementById("bagian").value;
            var hal = document.getElementById("hal").value;
            var varbaris=document.getElementById("varbaris").value;
            document.location.href = "pegawai.php?op=fdgfde342ft45tgwer34rfwef&bagian="+bagian+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>&urut=<?=$urut?>&urutan=<?=$urutan?>&field="+field+"&nip="+nip;
        }	
    }

    function exel()
    {
        newWindow('pegawai_excel.php', 'ExcelPegawai','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" onload="document.getElementById('bagian').focus()">

    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <!-- Background icon emerald-900 -->
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-users-gear text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Referensi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">MANAJEMEN KEPEGAWAIAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../referensi.php" target="content" class="text-emerald-700 hover:underline font-semibold">Referensi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Kepegawaian</span>
            </div>
        </div>

        <?
        if ($bagian != "-1"){
            $sql_tot = "SELECT * FROM jbssdm.pegawai WHERE bagian='$bagian' ORDER BY replid";
            $result_tot = QueryDb($sql_tot);
            $total = @ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
            $jumlah = @mysqli_num_rows($result_tot);
                        
            $sql_pegawai="SELECT * FROM jbssdm.pegawai WHERE bagian='$bagian' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
        } else {
            $sql_tot = "SELECT * FROM jbssdm.pegawai ORDER BY replid";
            $result_tot = QueryDb($sql_tot);
            $total = @ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
            $jumlah = @mysqli_num_rows($result_tot);
            
            $sql_pegawai="SELECT * FROM jbssdm.pegawai ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
        }
        
        $akhir = @ceil($jumlah/5)*5;
        $result_pegawai=QueryDb($sql_pegawai);
        
        if (@mysqli_num_rows($result_pegawai) > 0){ ?>
        <input type="hidden" name="total" id="total" value="<?=$total?>"/>

        <!-- Control Bar: Filter Bagian & Action Buttons -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Dropdown Filter Bagian -->
            <div class="flex items-center gap-3">
                <label for="bagian" class="text-sm font-bold text-slate-700">Bagian</label>
                <div class="relative">
                    <select name="bagian" id="bagian" onchange="change_bagian()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-56 pl-4 pr-10 py-2.5 shadow-sm transition-colors cursor-pointer">
                        <option value="-1" <?=StringIsSelected($row_bag['bagian'] ?? '', $bagian)?>>Semua Bagian</option>
                        <?
                        $sql_bag = "SELECT bagian FROM jbssdm.bagianpegawai ORDER BY urutan";    
                        $result_bag = QueryDB($sql_bag);
                        while ($row_bag = @mysqli_fetch_array($result_bag)){
                        ?>
                            <option value="<?=$row_bag['bagian']?>" <?=StringIsSelected($row_bag['bagian'], $bagian)?>>
                                <?=$row_bag['bagian']?>
                            </option>
                        <? } ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <button onClick="refresh()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-arrows-rotate text-emerald-600"></i> Refresh
                </button>
                <button onClick="JavaScript:exel()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-regular fa-file-excel text-emerald-700"></i> Excel
                </button>
                <button onClick="JavaScript:cetak('<?=$urut?>','<?=$urutan?>')" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-print text-sky-600"></i> Cetak
                </button>
                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                    <button onClick="JavaScript:tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-plus"></i> Tambah Pegawai
                    </button>
                <? } ?>
            </div>
        </div>

        <!-- Premium Modern Table -->
        <div class="overflow-hidden border border-slate-100 rounded-3xl shadow-sm bg-white mb-6">
            <table class="w-full text-left border-collapse" id="table">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase text-xs font-bold tracking-wider select-none">
                        <th class="py-4 px-5 text-center w-14">No</th>
                        
                        <!-- Sortable Columns -->
                        <th class="py-4 px-5 cursor-pointer hover:bg-slate-100 transition-colors w-32" onClick="change_urut('nip','<?=$urutan?>')">
                            N I P <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-5 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('nama','<?=$urutan?>')">
                            Nama Lengkap <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-5 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('tmplahir','<?=$urutan?>')">
                            Tempat Tanggal Lahir <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-5 text-center w-40" onClick="change_urut('pinpegawai','<?=$urutan?>')">
                            PIN Pegawai
                        </th>
                        <th class="py-4 px-5 text-center w-32" onClick="change_urut('aktif','<?=$urutan?>')">
                            Status
                        </th>
                        <th class="py-4 px-5 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-800">
                    <? 	
                    if ($page==0)
                        $cnt = 1;
                    else 
                        $cnt = (int)$page*(int)$varbaris+1;
                    
                    while ($row_pegawai = mysqli_fetch_array($result_pegawai)) { ?>
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td class="py-3.5 px-5 text-center text-slate-400 font-semibold"><?=$cnt ?></td>
                        <td class="py-3.5 px-5 text-slate-600 font-bold"><?=$row_pegawai['nip'] ?></td>
                        <td class="py-3.5 px-5 text-slate-900 font-extrabold"><?=$row_pegawai['nama'] ?></td>
                        <td class="py-3.5 px-5 text-slate-500"><?=$row_pegawai['tmplahir'] ?>, <span class="font-semibold text-slate-600"><?=format_tgl($row_pegawai['tgllahir']) ?></span></td>
                        <td class="py-3.5 px-5 text-center">
                            <div class="inline-flex items-center gap-2 bg-slate-100 border border-slate-200 rounded-xl px-2.5 py-1 text-xs font-mono font-bold text-slate-700">
                                <span><?=$row_pegawai['pinpegawai'] ?></span>
                                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                <button onClick="JavaScript:gantipin('pinpegawai','<?=$row_pegawai['nip']?>')" class="text-emerald-700 hover:text-emerald-600 transition-colors" title="Ganti PIN">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                </button>
                                <? } ?>
                            </div>
                        </td>    
                        <td class="py-3.5 px-5 text-center">
                            <? if (SI_USER_LEVEL() == $SI_USER_STAFF) { ?>
                                <? if ($row_pegawai['aktif'] == 1) { ?> 
                                    <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Aktif
                                    </span>
                                <? } else { ?>                
                                    <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                                    </span>
                                <? } ?>
                            <? } else { ?>
                                <a href="JavaScript:setaktif(<?=$row_pegawai['replid'] ?>, <?=$row_pegawai['aktif'] ?>)" class="inline-block transition-transform active:scale-95">
                                    <? if ($row_pegawai['aktif'] == 1) { ?>
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3.5 rounded-full text-xs font-semibold bg-emerald-100 hover:bg-emerald-200 text-emerald-800 shadow-sm border border-emerald-200/50 transition-colors">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Aktif
                                        </span>
                                    <? } else { ?>
                                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3.5 rounded-full text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200/50 transition-colors">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                                        </span>
                                    <? } ?>
                                </a>
                            <? } ?>
                        </td>
                        <td class="py-3.5 px-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onClick="JavaScript:lihat(<?=$row_pegawai['replid'] ?>)" class="p-2 text-emerald-700 hover:bg-emerald-50 rounded-xl transition-colors" title="Lihat Profil">
                                    <i class="fa-solid fa-eye text-base"></i>
                                </button>
                                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?> 
                                    <button onClick="JavaScript:cetak_detail(<?=$row_pegawai['replid'] ?>)" class="p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-colors" title="Cetak Profil">
                                        <i class="fa-solid fa-print text-base"></i>
                                    </button> 
                                    <button onClick="JavaScript:edit(<?=$row_pegawai['replid'] ?>)" class="p-2 text-sky-600 hover:bg-sky-50 rounded-xl transition-colors" title="Ubah Data">
                                        <i class="fa-solid fa-pen-to-square text-base"></i>
                                    </button>
                                    <button onClick="JavaScript:hapus(<?=$row_pegawai['replid'] ?>)" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus Data">
                                        <i class="fa-solid fa-trash-can text-base"></i>
                                    </button>
                                <? } ?>
                            </div>
                        </td>
                    </tr>
                    <? $cnt++; } CloseDb(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination & Row Count Control Bar -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2.5 text-sm text-slate-600 font-semibold">
                <span>Halaman</span>
                <div class="relative">
                    <select name="hal" id="hal" onChange="change_hal()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl pl-3 pr-8 py-1.5 focus:ring-emerald-500 shadow-sm cursor-pointer">
                        <?	for ($m=0; $m<$total; $m++) {?>
                             <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
                        <? } ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
                <span>dari <strong class="text-slate-900"><?=$total?></strong> halaman</span>
            </div>

            <div class="flex items-center gap-2.5 text-sm text-slate-600 font-semibold">
                <span>Jumlah baris per halaman</span>
                <div class="relative">
                    <select name="varbaris" id="varbaris" onChange="change_baris()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl pl-3 pr-8 py-1.5 focus:ring-emerald-500 shadow-sm cursor-pointer">
                        <? 	for ($m=10; $m <= 100; $m=$m+10) { ?>
                            <option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
                        <? 	} ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>
        </div>

        <? } else { ?>
            <!-- Fallback No Data State -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-12 text-center max-w-xl mx-auto mt-12">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-inner">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Tidak ditemukan adanya data</h3>
                <p class="text-xs text-slate-500 mb-6">Silakan periksa filter bagian pegawai Anda atau buat profil pegawai baru.</p>
                <? if (SI_USER_LEVEL() != $SI_USER_STAFF ) { ?>
                    <button onClick="JavaScript:tambah()" class="inline-flex items-center gap-2 bg-emerald-950 hover:bg-emerald-900 text-white font-bold text-xs py-3 px-6 rounded-2xl shadow-md transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-plus"></i> Tambah Pegawai Baru
                    </button>
                <? } ?>
            </div>
        <? } ?> 

    </div>
</body>
</html>
<script language="javascript">
	var spryselect1 = new Spry.Widget.ValidationSelect("bagian");
	var spryselect1 = new Spry.Widget.ValidationSelect("hal");
	var spryselect1 = new Spry.Widget.ValidationSelect("varbaris");
</script>
