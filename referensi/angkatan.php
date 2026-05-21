<?php
// =========================================================================
// INIT & INCLUDE FILES
// =========================================================================
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

OpenDb();

$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$varbaris   = isset($_REQUEST['varbaris']) ? $_REQUEST['varbaris'] : 10;
$page       = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
$hal        = isset($_REQUEST['hal']) ? $_REQUEST['hal'] : 0;
$urut       = isset($_REQUEST['urut']) ? $_REQUEST['urut'] : "angkatan";    
$urutan     = isset($_REQUEST['urutan']) ? $_REQUEST['urutan'] : "DESC";    

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

if ($op == "dw8dxn8w9ms8zs22") {
    $sql = "UPDATE angkatan SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
    QueryDb($sql);
    echo "<script>window.location.href='angkatan.php?departemen=".urlencode($departemen)."&page=$page&hal=$hal&varbaris=$varbaris&urut=$urut&urutan=$urutan';</script>";
    exit;
} 
else if ($op == "xm8r389xemx23xb2378e23") {
    $sql = "DELETE FROM angkatan WHERE replid = '$_REQUEST[replid]'";
    QueryDb($sql);
    echo "<script>window.location.href='angkatan.php?departemen=".urlencode($departemen)."&varbaris=$varbaris';</script>";
    exit;
}    
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Angkatan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    
    <script language="javascript">
    function tambah() {
        var departemen = document.getElementById('departemen').value;
        window.open('angkatan_add.php?departemen='+departemen, 'TambahAngkatan','width=500,height=300,resizable=1,scrollbars=1');
    }

    function refresh() {    
        window.location.reload();
    }

    function tampil() {
        var departemen = document.getElementById('departemen').value;
        document.location.href = "angkatan.php?departemen="+departemen+"&varbaris=<?=$varbaris?>";
    }

    function setaktif(replid, aktif) {
        var departemen = document.getElementById('departemen').value;
        var msg = (aktif == 1) ? "Non-aktifkan angkatan ini?" : "Aktifkan angkatan ini?";
        var newaktif = (aktif == 1) ? 0 : 1;
        
        if (confirm(msg)) 
            document.location.href = "angkatan.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&departemen="+departemen+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>&urut=<?=$urut?>&urutan=<?=$urutan?>";
    }

    function edit(replid) {
        window.open('angkatan_edit.php?replid='+replid, 'UbahAngkatan','width=500,height=300,resizable=1,scrollbars=1');
    }

    function hapus(replid) {
        var departemen = document.getElementById('departemen').value;
        if (confirm("Apakah anda yakin akan menghapus angkatan ini?"))
            document.location.href = "angkatan.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
    }

    function cetak() {
        var departemen = document.getElementById('departemen').value;
        var total = document.getElementById("total") ? document.getElementById("total").value : 0;
        window.open('angkatan_cetak.php?departemen='+departemen+'&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakAngkatan','width=790,height=650,resizable=1,scrollbars=1');
    }

    function change_hal() {
        var departemen = document.getElementById("departemen").value;
        var hal = document.getElementById("hal").value;
        var varbaris=document.getElementById("varbaris").value;
        document.location.href="angkatan.php?departemen="+departemen+"&page="+hal+"&hal="+hal+"&varbaris="+varbaris+"&urut=<?=$urut?>&urutan=<?=$urutan?>";
    }

    function change_baris() {
        var departemen = document.getElementById("departemen").value;
        var varbaris=document.getElementById("varbaris").value;
        document.location.href="angkatan.php?departemen="+departemen+"&varbaris="+varbaris+"&urut=<?=$urut?>&urutan=<?=$urutan?>";
    }
    </script>
</head>
<body class="bg-emerald-950 text-slate-800 min-h-screen p-4 md:p-6 overflow-x-hidden">

    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-emerald-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- HEADER & BREADCRUMB -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-emerald-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Referensi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">DATA ANGKATAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../referensi.php" target="content" class="text-emerald-700 hover:underline font-semibold">Referensi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Angkatan</span>
            </div>
        </div>

        <?    
        $sql_tot = "SELECT * FROM angkatan WHERE departemen = '$departemen' ORDER BY angkatan DESC";
        $result_tot = QueryDb($sql_tot);
        $total = @ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
        $jumlah = @mysqli_num_rows($result_tot);
                
        $sql="SELECT * FROM angkatan WHERE departemen = '$departemen' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
        $result = QueryDb($sql);
        
        if (@mysqli_num_rows($result) > 0){
        ?>    
        <input type="hidden" name="total" id="total" value="<?=$total?>"/>

        <!-- Control Bar -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Departemen</label>
                <div class="relative">
                    <select name="departemen" id="departemen" onChange="tampil()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-48 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                        <? $dep = getDepartemen(SI_USER_ACCESS());    
                        foreach($dep as $value) {
                            if ($departemen == "") $departemen = $value; ?>
                            <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                        <? } ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <button onClick="refresh()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-arrows-rotate text-emerald-600"></i> Refresh
                </button>
                <button onClick="JavaScript:cetak()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-print text-sky-600"></i> Cetak
                </button>
                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                    <button onClick="JavaScript:tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-plus"></i> Tambah Angkatan
                    </button>
                <? } ?>
            </div>
        </div>

        <!-- Premium Modern Table -->
        <div class="overflow-hidden border border-slate-100 rounded-3xl shadow-sm bg-white mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase text-xs font-bold tracking-wider">
                        <th class="py-4 px-6 text-center w-16">No</th>
                        <th class="py-4 px-6">Angkatan</th>
                        <th class="py-4 px-6">Keterangan</th>
                        <th class="py-4 px-6 text-center w-32">Status</th>
                        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                            <th class="py-4 px-6 text-center w-36">Aksi</th>
                        <? } ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-800">
                    <?    
                    $cnt = ($page * $varbaris);
                    while ($row = @mysqli_fetch_array($result)) {
                    ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="py-3 px-6 text-center text-slate-400 font-semibold"><?=++$cnt ?></td>
                        <td class="py-3 px-6 text-emerald-850 font-bold"><?=$row['angkatan']?></td>
                        <td class="py-3 px-6 text-slate-500"><?=$row['keterangan']?></td>
                        <td class="py-3 px-6 text-center">
                            <a href="JavaScript:setaktif(<?=$row['replid'] ?>, <?=$row['aktif'] ?>)" class="inline-block transition-transform active:scale-95">
                                <span class="inline-flex items-center gap-1.5 py-1.5 px-3.5 rounded-full text-xs font-semibold <?=$row['aktif']==1?'bg-emerald-100 text-emerald-800':'bg-slate-100 text-slate-600'?> shadow-sm border border-emerald-200/50 transition-colors">
                                    <span class="w-1.5 h-1.5 rounded-full <?=$row['aktif']==1?'bg-emerald-600':'bg-slate-400'?>"></span> <?=$row['aktif']==1?'Aktif':'Nonaktif'?>
                                </span>
                            </a>
                        </td>
                        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                        <td class="py-3 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onClick="JavaScript:edit(<?=$row['replid'] ?>)" class="p-2 text-sky-600 hover:bg-sky-50 rounded-xl transition-colors" title="Ubah Angkatan">
                                    <i class="fa-solid fa-pen-to-square text-base"></i>
                                </button>
                                <button onClick="JavaScript:hapus(<?=$row['replid'] ?>)" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus Angkatan">
                                    <i class="fa-solid fa-trash-can text-base"></i>
                                </button>
                            </div>
                        </td>
                        <? } ?>
                    </tr>
                    <? } CloseDb(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2.5 text-sm text-slate-600 font-semibold">
                <span>Halaman</span>
                <select name="hal" id="hal" onChange="change_hal()" class="bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl px-2 py-1.5 focus:ring-emerald-500 shadow-sm cursor-pointer">
                    <?    for ($m=0; $m<$total; $m++) {?>
                         <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
                    <? } ?>
                </select>
                <span>dari <strong class="text-slate-900"><?=$total?></strong> halaman</span>
            </div>
            <div class="flex items-center gap-2.5 text-sm text-slate-600 font-semibold">
                <span>Baris per halaman</span>
                <select name="varbaris" id="varbaris" onChange="change_baris()" class="bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl px-2 py-1.5 focus:ring-emerald-500 shadow-sm cursor-pointer">
                    <?     for ($m=5; $m <= 50; $m=$m+5) { ?>
                        <option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
                    <?     } ?>
                </select>
            </div>
        </div>

        <? } else { ?>
            <!-- Fallback No Data State -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-12 text-center max-w-xl mx-auto mt-12">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-inner">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Tidak ditemukan adanya data</h3>
                <p class="text-xs text-slate-500 mb-6">Silakan periksa filter departemen Anda atau tambahkan angkatan baru.</p>
                <button onClick="JavaScript:tambah()" class="inline-flex items-center gap-2 bg-emerald-950 hover:bg-emerald-900 text-white font-bold text-xs py-3 px-6 rounded-2xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-plus"></i> Tambah Data Baru
                </button>
            </div>
        <? } ?>
    </div>
</body>
</html>
