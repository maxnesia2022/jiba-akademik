<?
include('cek.php');
require_once('include/sessioninfo.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kenaikan & Kelulusan JIBAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Modern Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/tooltips.css">
    <script type="text/javascript" src="script/tooltips.js"></script>
    <script type="text/javascript">
    function get_fresh(){
        document.location.reload();
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
                <!-- Icon background emerald-900 -->
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-award text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">KENAIKAN & KELULUSAN</h1>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Grid (Main Menu Cards) -->
            <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Kenaikan Kelas -->
                <a href="siswa/siswa_kenaikan_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-arrow-up-right-dots"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Kenaikan Kelas</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Proses kenaikan jenjang kelas paralel secara massal.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Kelulusan Siswa -->
                <a href="siswa/siswa_lulus_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Kelulusan Siswa</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pendataan status kelulusan akhir bagi siswa tingkat akhir.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Tidak Naik Kelas -->
                <a href="siswa/siswa_tidak_naik_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-user-slash"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Tinggal Kelas</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Manajemen registrasi ulang siswa yang tidak memenuhi syarat kenaikan.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Referensi Alert Link -->
                <div onClick="alert('Untuk mendata Departemen Baru, Tahun Ajaran Baru, Angkatan Baru, dan Kelas Baru \nSilakan lakukan di Bagian Referensi');" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-amber-500/30 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden cursor-pointer sm:col-span-2 md:col-span-3">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-amber-50 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-amber-500 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-circle-exclamation"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Panduan Pengaturan Kelas & Angkatan</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pemberitahuan panduan alur pendataan struktur kelas baru untuk proses kenaikan kelas.</p>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 flex items-center gap-1">
                        Pemberitahuan Sistem <i class="fa-solid fa-circle-info text-[10px]"></i>
                    </span>
                </div>
            </div>

            <!-- Right Grid (Alumni Links Panel) -->
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-md flex flex-col justify-between h-auto">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <!-- Icon background emerald-900 -->
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1rem] flex items-center justify-center text-xl shadow-lg shadow-emerald-900/30">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-base">Portal Alumni</h3>
                    </div>
                    <div class="flex flex-col gap-3 font-bold text-xs text-slate-700">
                        <a href="siswa/alumni_main.php" class="p-3.5 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-3 transition-colors">
                            <i class="fa-solid fa-user-pen text-emerald-600 text-base"></i> Pendataan Alumni
                        </a>
                        <a href="siswa/alumni.php" class="p-3.5 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-3 transition-colors">
                            <i class="fa-solid fa-address-book text-emerald-600 text-base"></i> Daftar Alumni
                        </a>
                        <a href="siswa/alumni_cari.php" class="p-3.5 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-3 transition-colors">
                            <i class="fa-solid fa-magnifying-glass text-emerald-600 text-base"></i> Pencarian Alumni
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>