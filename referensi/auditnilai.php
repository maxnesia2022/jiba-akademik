<?php
require_once('../include/errorhandler.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../cek.php');

$bulan = date('n');
if (isset($_REQUEST['bulan']))
    $bulan = (int)$_REQUEST['bulan'];
    
$tahun = date('Y');
if (isset($_REQUEST['tahun']))
    $tahun = (int)$_REQUEST['tahun'];

OpenDb();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Perubahan Data Nilai</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function change_date() {
        var bulan = document.getElementById('bulan').value;
        var tahun = document.getElementById('tahun').value;
        document.location.href = "auditnilai.php?bulan="+bulan+"&tahun="+tahun;
    }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Pengaturan Sistem</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">AUDIT PERUBAHAN NILAI</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../usermenu.php" target="content" class="text-emerald-700 hover:underline font-semibold">Pengaturan</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Audit Nilai</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <div class="flex items-center gap-3">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Periode</label>
                    <div class="flex gap-2">
                        <div class="relative">
                            <select name="bulan" id="bulan" onChange="change_date()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-40 pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?=$i?>" <?=IntIsSelected($i, $bulan)?> ><?=NamaBulan($i)?></option>
                                <?php } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="tahun" id="tahun" onChange="change_date()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-28 pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                                <?php for ($i = $G_START_YEAR; $i <= date('Y') + 1; $i++) { ?>
                                    <option value="<?=$i?>" <?=IntIsSelected($i, $tahun)?> ><?=$i?></option>
                                <?php } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <button onClick="document.location.reload()" class="p-2.5 bg-slate-50 text-slate-600 rounded-xl hover:bg-slate-100 border border-slate-200 transition-colors" title="Refresh">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <?php
            $sql = "SELECT jenisnilai, idnilai, nasli, nubah, DATE_FORMAT(tanggal, '%d-%m-%Y %H:%i') AS tgl, alasan, pengguna, informasi 
                    FROM auditnilai WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal DESC";
            $res = QueryDb($sql);
            if (mysqli_num_rows($res) > 0) { ?>
                <div class="overflow-y-auto flex-1">
                    <table class="w-full text-left border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-slate-50 sticky top-0 z-10">
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">No</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Waktu</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Informasi Objek</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">Sebelum</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 text-center">Sesudah</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Alasan Perubahan</th>
                                <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php 
                            $cnt = 0;
                            while ($row = mysqli_fetch_array($res)) { ?>
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-4 text-xs font-bold text-slate-400 text-center"><?=++$cnt?></td>
                                    <td class="px-6 py-4 text-xs text-slate-600 font-medium"><?=$row['tgl']?></td>
                                    <td class="px-6 py-4 text-xs text-slate-900 font-bold max-w-xs"><?=$row['informasi']?></td>
                                    <td class="px-6 py-4 text-xs text-rose-600 font-bold text-center bg-rose-50/30"><?=$row['nasli']?></td>
                                    <td class="px-6 py-4 text-xs text-emerald-700 font-bold text-center bg-emerald-50/30"><?=$row['nubah']?></td>
                                    <td class="px-6 py-4 text-xs text-slate-500 italic"><?=$row['alasan']?></td>
                                    <td class="px-6 py-4 text-xs font-semibold text-slate-700">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] text-slate-500">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                            <?= ($row['pengguna']=="landlord - landlord" ? "Administrator" : $row['pengguna']) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-slate-300">
                        <i class="fa-solid fa-clipboard-list text-4xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Tidak Ada Data Audit</h2>
                    <p class="text-slate-500 text-sm max-w-md leading-relaxed">
                        Belum ditemukan catatan perubahan data nilai untuk periode <?=NamaBulan($bulan)?> <?=$tahun?>.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>
