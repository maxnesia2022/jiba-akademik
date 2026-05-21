<?
include('cek.php');
require_once('include/sessioninfo.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSB - Penerimaan Siswa Baru</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Modern Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/tooltips.css">
    <script type="text/javascript" src="script/tooltips.js"></script>
    <script type="text/javascript">
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
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-user-plus text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PENERIMAAN SISWA BARU (PSB)</h1>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Grid (Main Menu Cards) -->
            <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Proses Penerimaan -->
                <a href="siswa_baru/proses.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-arrows-spin"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Proses Penerimaan</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Atur & lihat semua tahapan serta proses pendaftaran PSB.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Kelompok Pendaftaran -->
                <a href="siswa_baru/kelompok.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-users-viewfinder"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Kelompok Pendaftaran</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pengelompokan jalur masuk dan kriteria calon siswa.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Pendataan Calon Siswa -->
                <a href="siswa_baru/calon_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Data Calon Siswa</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pendaftaran profil data diri lengkap calon siswa baru.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Tahun Ajaran Alert Link -->
                <div onClick="alert('Gunakan menu Tahun Ajaran di bagian referensi \nuntuk mendata Tahun Ajaran');" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-amber-500/30 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-amber-50 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-amber-500 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-calendar-days"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Tahun Ajaran</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pemberitahuan konfigurasi agenda tahun ajaran aktif.</p>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 flex items-center gap-1">
                        Pemberitahuan Penting <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                    </span>
                </div>

                <!-- Pencarian Calon Siswa -->
                <a href="siswa_baru/cari_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Pencarian Calon</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Cari data calon pendaftar berdasarkan nomor atau nama.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Penempatan Calon Siswa -->
                <a href="siswa_baru/penempatan_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Penempatan Kelas</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Alokasi siswa baru yang diterima ke ruang kelas.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Statistik Calon Siswa -->
                <a href="siswa_baru/statistik_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden sm:col-span-2 md:col-span-3">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-chart-simple"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Statistik Calon Siswa</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Analisis data statistik pendaftar dan grafik laporan kelulusan PSB.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>
            </div>

            <!-- Right Grid (Config Panel) -->
            <div class="flex flex-col gap-6">
                <!-- Konfigurasi PSB -->
                <a href="siswa_baru/settingpsb_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-emerald-900 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-900/30">
                        <i class="fa-solid fa-gears"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-sm mb-1">Konfigurasi PSB</h3>
                    <p class="text-xs text-slate-400">Atur syarat, biaya, formulir, dan parameter penerimaan.</p>
                </a>

                <!-- PIN Calon Siswa -->
                <a href="siswa_baru/pincs.main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-emerald-900 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-900/30">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-sm mb-1">PIN Calon Siswa</h3>
                    <p class="text-xs text-slate-400">Kelola dan generate kode keamanan PIN akun calon siswa baru.</p>
                </a>

                <!-- Kolom Tambahan Data -->
                <a href="referensi/tambahandata.php?from=Penerimaan%20Siswa%20Baru" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                    <div class="w-16 h-16 bg-emerald-900 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-900/30">
                        <i class="fa-solid fa-circle-plus"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-sm mb-1">Kolom Tambahan Calon</h3>
                    <p class="text-xs text-slate-400">Kostumisasi field isian tambahan formulir calon siswa baru.</p>
                </a>
            </div>
        </div>

    </div>

</body>
</html>