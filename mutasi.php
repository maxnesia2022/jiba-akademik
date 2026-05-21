<?
include('cek.php');
require_once('include/sessioninfo.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Siswa JIBAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Modern Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/tooltips.css">
    <script type="text/javascript" src="script/tooltips.js"></script>
    <script type="text/javascript" language="JavaScript1.2" src="design/dhtml/stmenu.js"></script>
    <script type="text/javascript">
    function get_fresh(){
        document.location.reload();
    }
    function change_theme(theme){
        parent.topcenter.location.href="topcenter.php?theme="+theme;
        parent.topleft.location.href="topleft.php?theme="+theme;
        parent.topright.location.href="topright.php?theme="+theme;
        parent.midleft.location.href="midleft.php?theme="+theme;
        get_fresh();
        parent.midright.location.href="midright.php?theme="+theme;
        parent.bottomleft.location.href="bottomleft.php?theme="+theme;
        parent.bottomcenter.location.href="bottomcenter.php?theme="+theme;
        parent.bottomright.location.href="bottomright.php?theme="+theme;
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">

    <!-- FLOATING CANVAS -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- Header Section -->
        <div class="max-w-6xl mx-auto mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-arrows-spin text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">MUTASI SISWA</h1>
                </div>
            </div>
        </div>

        <!-- Main Cards Grid -->
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Jenis Mutasi Siswa -->
            <a href="mutasi/jenis_mutasi_siswa.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                <div class="z-10">
                    <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Jenis Mutasi</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">Pendataan kategori jenis keluar siswa (Lulus, Keluar, Drop Out, Pindah).</p>
                </div>
                <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                    Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            <!-- Pendataan Mutasi -->
            <a href="mutasi/mutasi_siswa.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                <div class="z-10">
                    <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Eksekusi Mutasi</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">Proses pengeluaran atau pemindahan data status keanggotaan siswa.</p>
                </div>
                <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                    Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            <!-- Daftar Mutasi -->
            <a href="mutasi/daftar_mutasi.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                <div class="z-10">
                    <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                        <i class="fa-solid fa-users-slash"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Daftar Mutasi</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">Arsip daftar pencarian siswa yang tercatat telah dimutasi.</p>
                </div>
                <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                    Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            <!-- Statistik Mutasi -->
            <a href="mutasi/statistik_mutasi_siswa.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                <div class="z-10">
                    <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Statistik Mutasi</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">Laporan grafik rekapitulasi siswa pindah dan keluar per tahun.</p>
                </div>
                <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                    Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>
        </div>

    </div>

</body>
</html>