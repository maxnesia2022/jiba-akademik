<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

OpenDb();
$op = "";
if (isset($_REQUEST['op']))
	$op = $_REQUEST['op'];

if ($op=="gu7jkds894h98uj32uhi9d8"){
	$sql_hapus="DELETE FROM jenismutasi WHERE replid='$_REQUEST[replid]'";
	$result_hapus=QueryDb($sql_hapus);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis-Jenis Mutasi Siswa</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
    function tambah() {
        newWindow('tambah_jenis_mutasi.php','TambahJenisMutasi','400','260','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function edit(replid) {
        newWindow('ubah_jenis_mutasi.php?replid='+replid, 'UbahJenisMutasi','400','260','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function hapus(replid){
        if (confirm('Anda yakin akan menghapus jenis mutasi ini?'))
            document.location.href="jenis_mutasi_siswa.php?op=gu7jkds894h98uj32uhi9d8&replid="+replid;
    }

    function cetak() {
        newWindow('jenis_mutasi_cetak.php', 'CetakJenisMutasi','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }
    </script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-tags text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Mutasi Siswa</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">JENIS-JENIS MUTASI</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../mutasi.php" target="content" class="text-emerald-700 hover:underline font-semibold">Mutasi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Jenis Mutasi</span>
            </div>
        </div>

        <!-- Action Controls Row -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-2.5">
                <button onClick="tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-plus"></i> Tambah Jenis Mutasi
                </button>
            </div>
            <div class="flex items-center gap-3">
                <button onClick="document.location.reload()" class="flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all">
                    <i class="fa-solid fa-rotate-right text-emerald-600"></i> Refresh
                </button>
                <button onClick="cetak()" class="flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all">
                    <i class="fa-solid fa-print text-emerald-600"></i> Cetak
                </button>
            </div>
        </div>

        <!-- Content Area (Table) -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <?	
            $queryJenis="SELECT * FROM jenismutasi ORDER BY jenismutasi";
            $resultJenis=queryDb($queryJenis);
            if (@mysqli_num_rows($resultJenis) > 0){ ?>
                <div class="overflow-y-auto flex-1 p-1">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-slate-50 sticky top-0 z-10">
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 rounded-tl-2xl">No</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Jenis Mutasi</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Keterangan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 rounded-tr-2xl text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?	
                            $a=0;
                            while($fetchJenis=mysqli_fetch_array($resultJenis)){ ?>
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4 text-xs font-bold text-slate-400"><?=$a+1; ?></td>
                                    <td class="px-6 py-4 text-xs font-bold text-slate-900"><?=$fetchJenis['jenismutasi']; ?></td>
                                    <td class="px-6 py-4 text-xs text-slate-600"><?=$fetchJenis['keterangan']; ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onClick="edit(<?=$fetchJenis['replid'] ?>)" class="p-2 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition-colors" title="Ubah">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button onClick="hapus(<?=$fetchJenis['replid'] ?>)" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <? $a++; } ?>
                        </tbody>
                    </table>
                </div>
            <? } else { ?>
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mb-6 text-red-600">
                        <i class="fa-solid fa-folder-open text-4xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Data Kosong</h2>
                    <p class="text-slate-500 text-sm max-w-md leading-relaxed">
                        Tidak ditemukan adanya data jenis mutasi. Silakan klik tombol "Tambah Jenis Mutasi" untuk membuat data baru.
                    </p>
                </div>
            <? } ?>
        </div>

    </div>
</body>
</html>
<? CloseDb();?>
