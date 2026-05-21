<?
include('cek.php');
require_once('include/sessioninfo.php');
$middle="0";
if (isset($_REQUEST['flag'])){
	$middle="1";
} else {
	$middle="0";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Akademik JIBAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/tooltips.css">
    <script type="text/javascript" src="script/tooltips.js"></script>
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
    function scrollMiddle() {
        var myHeight = window.innerHeight / 0.5;
        window.scrollTo(0, myHeight);
    }
    function scrollTop() {
        window.scrollTo(0, 0);
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" <? if ($middle=="1") { ?>onload="scrollMiddle()" <? } else { ?> onLoad="scrollTop()"  <? } ?>>

    <!-- FLOATING CANVAS -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- Header Section -->
        <div class="max-w-6xl mx-auto mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">MANAJEMEN PENILAIAN</h1>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Grid (Main Menu Modules) -->
            <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Cetak Form Penilaian -->
                <a href="penilaian/formpenilaian.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-print"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Cetak Form Penilaian</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Cetak lembar fisik penilaian untuk guru secara kolektif.</p>
                    </div>
                </a>

                <!-- Nilai RPP per Kelas -->
                <a href="penilaian/ujian_rpp_kelas.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-users-rectangle"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Nilai RPP per Kelas</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Kelola daftar nilai tugas/RPP siswa berdasar kelompok kelas.</p>
                    </div>
                </a>

                <!-- Nilai RPP per Siswa -->
                <a href="penilaian/ujian_rpp_siswa.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-user-pen"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Nilai RPP per Siswa</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pencarian dan peninjauan riwayat tugas RPP per individu siswa.</p>
                    </div>
                </a>

                <!-- Laporan Nilai Pelajaran -->
                <a href="penilaian/lap_pelajaran_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-file-invoice-with-usdollar"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Laporan Nilai Pelajaran</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Rekapitulasi laporan hasil evaluasi belajar setiap mata pelajaran.</p>
                    </div>
                </a>

                <!-- Pendataan Nilai Pelajaran -->
                <a href="penilaian/lihat_nilai_pelajaran.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-chart-bar"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Input Nilai Harian</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pengisian data nilai ujian harian, UTS, dan UAS per pelajaran.</p>
                    </div>
                </a>

                <!-- Rata-rata Ujian Sekolah -->
                <a href="penilaian/rataus.main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Rata-rata US</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Lihat performa rata-rata kumulatif nilai ujian sekolah.</p>
                    </div>
                </a>

                <!-- Nilai Rapor Siswa -->
                <a href="penilaian/lihat_penentuan.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-award"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Nilai Rapor Siswa</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Penyusunan penentuan konversi nilai UTS/UAS menjadi nilai rapor akhir.</p>
                    </div>
                </a>

                <!-- Komentar Rapor -->
                <a href="penilaian/komentar_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-comment-dots"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Komentar Rapor</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pemberian deskripsi narasi catatan perkembangan wali kelas di rapor.</p>
                    </div>
                </a>

                <!-- Laporan Akhir Belajar (Rapor) -->
                <a href="penilaian/lap_rapor_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-book-open-reader"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Laporan Rapor</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Unduh, cetak, dan kelola buku rapor belajar per siswa.</p>
                    </div>
                </a>
            </div>

            <!-- Right Grid (Legger List Control Menu) -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-md flex flex-col justify-between h-auto">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1rem] flex items-center justify-center text-xl shadow-lg shadow-emerald-900/30">
                            <i class="fa-solid fa-table"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base">Modul Legger</h3>
                    </div>
                    <div class="flex flex-col gap-3 font-bold text-xs text-slate-700">
                        <a href="penilaian/lap_legger.php" class="p-3.5 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-3 transition-colors">
                            <i class="fa-solid fa-table-list text-emerald-600 text-base"></i> Laporan Legger Nilai
                        </a>
                        <a href="penilaian/legger.rapor.php" class="p-3.5 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-3 transition-colors">
                            <i class="fa-solid fa-book text-emerald-600 text-base"></i> Legger per Pelajaran
                        </a>
                        <a href="penilaian/legger.kelas.php" class="p-3.5 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-3 transition-colors">
                            <i class="fa-solid fa-school text-emerald-600 text-base"></i> Legger per Kelas
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>