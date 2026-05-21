<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$op = $_REQUEST['op'];

if ($op == "dw8dxn8w9ms8zs22") {
	OpenDb();
	$sql = "UPDATE tingkat SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
	QueryDb($sql);
	CloseDb();
} else if ($op == "xm8r389xemx23xb2378e23") {
	OpenDb();
	$sql = "DELETE FROM tingkat WHERE replid = '$_REQUEST[replid]'";
	QueryDb($sql);
	CloseDb();
	   
}	
OpenDb();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Tingkat</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function tambah() {
	var departemen = document.getElementById('departemen').value;
	newWindow('tingkat_add.php?departemen='+departemen, 'TambahTingkat','500','310','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function refresh() {	
	document.location.reload();
}

function tampil() {
	var departemen = document.getElementById('departemen').value;
	document.location.href = "tingkat.php?departemen="+departemen;
}

function setaktif(replid, aktif) {
	var msg;
	var newaktif;
	var departemen = document.getElementById('departemen').value;
	
	if (aktif == 1) {
		msg = "Apakah anda yakin akan mengubah tingkat ini menjadi TIDAK AKTIF?";
		newaktif = 0;
	} else	{	
		msg = "Apakah anda yakin akan mengubah tingkat ini menjadi AKTIF?";
		newaktif = 1;
	}
	
	if (confirm(msg)) 
		document.location.href = "tingkat.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&departemen="+departemen;
}

function edit(replid) {
	newWindow('tingkat_edit.php?replid='+replid, 'UbahTingkat','500','310','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function hapus(replid) {
	var departemen = document.getElementById('departemen').value;
	if (confirm("Apakah anda yakin akan menghapus tingkat ini?"))
		document.location.href = "tingkat.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen;
		
}

function cetak() {
	var departemen = document.getElementById('departemen').value;
	newWindow('tingkat_cetak.php?departemen='+departemen, 'CetakTingkat','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
}
</script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" onload="document.getElementById('departemen').focus()">

    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-layer-group text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Referensi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PENDATAAN TINGKAT</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../referensi.php" target="content" class="text-emerald-700 hover:underline font-semibold">Referensi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Tingkat</span>
            </div>
        </div>

        <!-- Control Bar -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <label for="departemen" class="text-sm font-bold text-slate-700">Departemen</label>
                <div class="relative">
                    <select name="departemen" id="departemen" onChange="tampil()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-56 pl-4 pr-10 py-2.5 shadow-sm transition-colors cursor-pointer">
                        <?php
                        $dep = getDepartemen(SI_USER_ACCESS());    
                        foreach($dep as $value) {
                            if ($departemen == "") $departemen = $value;
                            echo "<option value='$value' ".StringIsSelected($value, $departemen).">$value</option>";
                        }
                        ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onClick="refresh()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-arrows-rotate text-emerald-600"></i> Refresh
                </button>
                <button onClick="JavaScript:cetak()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-print text-sky-600"></i> Cetak
                </button>
                <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                    <button onClick="JavaScript:tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-plus"></i> Tambah Tingkat
                    </button>
                <?php } ?>
            </div>
        </div>

        <?php
        OpenDb();
        $sql = "SELECT replid,tingkat,keterangan,aktif,urutan FROM tingkat WHERE departemen='$departemen' ORDER BY urutan";    
        $result = QueryDb($sql);
        if (@mysqli_num_rows($result) > 0) { ?>

        <!-- Premium Modern Table -->
        <div class="overflow-hidden border border-slate-100 rounded-3xl shadow-sm bg-white">
            <table class="w-full text-left border-collapse" id="table">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase text-xs font-bold tracking-wider">
                        <th class="py-4 px-6 text-center w-16">No</th>
                        <th class="py-4 px-6">Jenjang / Tingkat</th>
                        <th class="py-4 px-6">Keterangan</th>
                        <th class="py-4 px-6 text-center w-32">Status</th>
                        <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                            <th class="py-4 px-6 text-center w-36">Aksi</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-800">
                    <?php 	
                    $cnt = 0;
                    while ($row = @mysqli_fetch_array($result)) { ?>
                        <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                            <td class="py-3 px-6 text-center text-slate-400 font-semibold"><?=++$cnt ?></td>
                            <td class="py-3 px-6 text-emerald-850 font-bold"><?=$row['tingkat'] ?></td>
                            <td class="py-3 px-6 text-slate-500"><?=$row['keterangan'] ?></td>
                            <td class="py-3 px-6 text-center">
                                <?php if (SI_USER_LEVEL() == $SI_USER_STAFF) { ?>
                                    <?php if ($row['aktif'] == 1) { ?> 
                                        <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Aktif
                                        </span>
                                    <?php } else { ?>                
                                        <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                                        </span>
                                    <?php } ?>
                                <?php } else { ?>
                                    <a href="JavaScript:setaktif(<?=$row['replid'] ?>, <?=$row['aktif'] ?>)" class="inline-block transition-transform active:scale-95">
                                        <?php if ($row['aktif'] == 1) { ?>
                                            <span class="inline-flex items-center gap-1.5 py-1.5 px-3.5 rounded-full text-xs font-semibold bg-emerald-100 hover:bg-emerald-200 text-emerald-800 shadow-sm border border-emerald-200/50 transition-colors">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Aktif
                                            </span>
                                        <?php } else { ?>
                                            <span class="inline-flex items-center gap-1.5 py-1.5 px-3.5 rounded-full text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-600 border border-slate-200/50 transition-colors">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Nonaktif
                                            </span>
                                        <?php } ?>
                                    </a>
                                <?php } ?>
                            </td>
                            <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>         
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button onClick="JavaScript:edit(<?=$row['replid'] ?>)" class="p-2 text-sky-600 hover:bg-sky-50 rounded-xl transition-colors" title="Ubah Tingkat">
                                        <i class="fa-solid fa-pen-to-square text-base"></i>
                                    </button>
                                    <button onClick="JavaScript:hapus(<?=$row['replid'] ?>)" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus Tingkat">
                                        <i class="fa-solid fa-trash-can text-base"></i>
                                    </button>
                                </div>
                            </td>
                            <?php } ?>  
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <?php } else { ?>
            <!-- Fallback No Data State -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-12 text-center max-w-xl mx-auto mt-12">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-inner">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <?php if ($departemen != "") { ?>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Tidak ditemukan adanya data</h3>
                    <p class="text-xs text-slate-500 mb-6">Silakan periksa filter departemen Anda atau buat data tingkat baru.</p>
                    <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                        <button onClick="JavaScript:tambah()" class="inline-flex items-center gap-2 bg-emerald-950 hover:bg-emerald-900 text-white font-bold text-xs py-3 px-6 rounded-2xl shadow-md transition-all duration-200 active:scale-95">
                            <i class="fa-solid fa-plus"></i> Tambah Data Baru
                        </button>
                    <?php } ?>
                <?php } else { ?>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Belum ada data Departemen</h3>
                    <p class="text-xs text-slate-500">Silakan isi terlebih dahulu di menu Departemen pada bagian Referensi.</p>
                <?php } ?>
            </div>
        <?php } ?> 

    </div>

</body>
</html>
<?php CloseDb(); ?>