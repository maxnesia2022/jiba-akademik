<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../cek.php');
require_once('../library/dpupdate.php');

OpenDb();

$op = "";
if (isset($_REQUEST['op']))
    $op = $_REQUEST['op'];

if ($op == "xm8r389xemx23xb2378e23")
{
    $sql = "DELETE FROM kelompokpelajaran WHERE replid = '$_REQUEST[replid]'";
    $result = QueryDb($sql);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelompok Pelajaran</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
        function tambah() {
            newWindow('kelompokpelajaran_add.php', 'TambahKelompokPelajaran','530','350','resizable=1,scrollbars=1,status=0,toolbar=0')
        }

        function refresh() {
            document.location.href = "kelompokpelajaran.php";
        }

        function edit(replid) {
            newWindow('kelompokpelajaran_edit.php?replid='+replid, 'UbahKelompokPelajaran','530','350','resizable=1,scrollbars=1,status=0,toolbar=0')
        }

        function hapus(replid) {
            if (confirm("Apakah anda yakin akan menghapus data ini?"))
                document.location.href = "kelompokpelajaran.php?op=xm8r389xemx23xb2378e23&replid="+replid;
        }

        function cetak() {
            newWindow('kelompokpelajaran_cetak.php', 'CetakKelompokPelajaran','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <!-- Background icon emerald-900 -->
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-layer-group text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Guru & Pelajaran</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">KELOMPOK PELAJARAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../guru.php?page=p" target="content" class="text-emerald-700 hover:underline font-semibold">Guru & Pelajaran</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Kelompok Pelajaran</span>
            </div>
        </div>

        <!-- Action Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-wrap items-center justify-end gap-2.5">
            <button onClick="refresh()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                <i class="fa-solid fa-arrows-rotate text-emerald-600"></i> Refresh
            </button>
            <button onClick="JavaScript:cetak()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                <i class="fa-solid fa-print text-sky-600"></i> Cetak
            </button>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                <button onClick="JavaScript:tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-plus"></i> Tambah Kelompok
                </button>
            <? } ?>
        </div>

        <?
        $sql = "SELECT * FROM kelompokpelajaran";
        $result = QueryDb($sql);
        if (@mysqli_num_rows($result) > 0) {
        ?>
        <!-- Premium Modern Table -->
        <div class="overflow-hidden border border-slate-100 rounded-3xl shadow-sm bg-white">
            <table class="w-full text-left border-collapse" id="table">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase text-xs font-bold tracking-wider select-none">
                        <th class="py-4 px-6 text-center w-16">No</th>       
                        <th class="py-4 px-6 w-32 text-center">Kode</th>
                        <th class="py-4 px-6">Kelompok</th>
                        <th class="py-4 px-6 text-center w-24">Urutan</th>
                        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                            <th class="py-4 px-6 text-center w-32">Aksi</th>
                        <? } ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-800">
                    <? 	
                    $cnt = 0;
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td class="py-3.5 px-6 text-center text-slate-400 font-semibold"><?=++$cnt?></td>
                        <td class="py-3.5 px-6 text-center text-emerald-800 font-bold"><?=$row['kode']?></td>
                        <td class="py-3.5 px-6 text-slate-900 font-extrabold"><?=$row['kelompok']?></td>
                        <td class="py-3.5 px-6 text-center font-bold text-slate-600"><?=$row['urutan']?></td>
                        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                        <td class="py-3.5 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onClick="JavaScript:edit(<?=$row['replid'] ?>)" class="p-2 text-sky-600 hover:bg-sky-50 rounded-xl transition-colors" title="Ubah">
                                    <i class="fa-solid fa-pen-to-square text-base"></i>
                                </button>
                                <button onClick="JavaScript:hapus(<?=$row['replid'] ?>)" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus">
                                    <i class="fa-solid fa-trash-can text-base"></i>
                                </button>
                            </div>
                        </td>
                        <? } ?>
                    </tr>
                    <? } ?>
                </tbody>
            </table>
        </div>
        <script language='JavaScript'>
            Tables('table', 1, 0);
        </script>
        <? } else { ?>
        <!-- Fallback No Data State -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-12 text-center max-w-xl mx-auto mt-12">
            <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-inner">
                <i class="fa-solid fa-folder-open"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Tidak ditemukan adanya data</h3>
            <p class="text-xs text-slate-500 mb-6">Silakan buat kelompok pelajaran baru untuk memulai pendataan.</p>
            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                <button onClick="JavaScript:tambah()" class="inline-flex items-center gap-2 bg-emerald-950 hover:bg-emerald-900 text-white font-bold text-xs py-3 px-6 rounded-2xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-plus"></i> Tambah Kelompok
                </button>
            <? } ?>
        </div>
        <? } ?>
    </div>
</body>
</html>
<? CloseDb(); ?>
