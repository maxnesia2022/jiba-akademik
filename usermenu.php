<?
require_once('include/sessioninfo.php'); 
require_once('cek.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan JIBAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Modern Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script language="javascript" src="script/tables.js"></script>
    <script language="javascript" src="script/tools.js"></script>
    <script language="javascript">
    function ganti() {
        newWindow('user/user_ganti.php','GantiPasswordUser','500','280','resizable=1,scrollbars=1,status=0,toolbar=0')
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
                    <i class="fa-solid fa-sliders text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">SISTEM PENGATURAN</h1>
                </div>
            </div>
        </div>

        <!-- Main Configuration Cards Grid -->
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Daftar Pengguna (Dengan Pengecekan Level Akses Bawaan) -->
            <? if (SI_USER_LEVEL() != "2") { ?>
                <a href="user/user.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Daftar Pengguna</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Kelola otorisasi akun pengguna, penentuan level hak akses operator.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Kelola Akun <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>
            <? } else { ?>
                <div onClick="alert('Maaf, Anda tidak berhak mengakses halaman ini !');" class="group bg-white/60 p-6 rounded-[2rem] border border-dashed border-slate-200 cursor-not-allowed flex flex-col justify-between h-52 relative overflow-hidden opacity-65">
                    <div class="z-10">
                        <div class="w-12 h-12 bg-slate-300 text-slate-500 rounded-[1.25rem] flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-users-slash"></i>
                        </div>
                        <h3 class="font-bold text-slate-400 text-base mb-1">Daftar Pengguna</h3>
                        <p class="text-xs text-slate-400 line-clamp-2">Akses terbatas. Anda tidak memiliki izin untuk mengedit pengguna lain.</p>
                    </div>
                </div>
            <? } ?>

            <!-- Ganti Password -->
            <a href="JavaScript:ganti()" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                <div class="z-10">
                    <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Ganti Password</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">Ubah kata sandi login keamanan sistem informasi akademik Anda.</p>
                </div>
                <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                    Ganti Sandi <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            <!-- Audit Perubahan Nilai -->
            <a href="referensi/auditnilai.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                <div class="z-10">
                    <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <h3 class="font-bold text-slate-800 text-base mb-1">Audit Perubahan Nilai</h3>
                    <p class="text-xs text-slate-500 line-clamp-2">Peninjauan log riwayat modifikasi atau manipulasi entri nilai siswa.</p>
                </div>
                <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                    Audit Log <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            <!-- Query Error Log -->
            <? if (SI_USER_LEVEL() != "2") { ?>
                <a href="referensi/queryerror.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Query Error Log</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Laporan galat penulisan database SQL untuk administrator server.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Lihat Log <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>
            <? } else { ?>
                <div onClick="alert('Maaf, Anda tidak berhak mengakses halaman ini !');" class="group bg-white/60 p-6 rounded-[2rem] border border-dashed border-slate-200 cursor-not-allowed flex flex-col justify-between h-52 relative overflow-hidden opacity-65">
                    <div class="z-10">
                        <div class="w-12 h-12 bg-slate-300 text-slate-500 rounded-[1.25rem] flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-ban"></i>
                        </div>
                        <h3 class="font-bold text-slate-400 text-base mb-1">Query Error Log</h3>
                        <p class="text-xs text-slate-400 line-clamp-2">Akses terbatas. Log hanya diizinkan untuk Operator tingkat Administrator.</p>
                    </div>
                </div>
            <? } ?>
        </div>

    </div>

</body>
</html>