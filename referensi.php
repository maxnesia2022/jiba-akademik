<?
 ?>
<?
include('cek.php');
require_once('include/sessioninfo.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referensi Akademik JIBAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
        /* Efek scrollbar halus di dalam kartu konten */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #15803d;
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #166534;
        }
    </style>
</head>
<!-- 
  Mengatur margin dan padding body ke m-0 p-0 secara mutlak agar tidak ada sela putih 
  di tepi halaman browser dan memastikan warna bg-green-950 menyentuh ujung bingkai.
-->
<body class="bg-green-950 text-white select-none overflow-hidden m-0 p-0 select-none overflow-x-hidden">

    <!-- 
      KARTU KONTEN UTAMA (FLOATING CANVAS):
      - Menggunakan margin p-4 md:p-6 di div pembungkus ini sebagai jarak dalam yang aman.
      - Sudut melengkung oval (rounded-[2.5rem] atau rounded-[3rem]) membuat tampilan melayang di atas bg-green-950.
    -->
    <div class="p-4 md:p-6">
        <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 custom-scrollbar">

            <!-- Container Header di dalam kartu -->
            <div class="max-w-6xl mx-auto mb-10">
                <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5">
                    <!-- Pengecualian: Background ikon utama menggunakan emerald-900 -->
                    <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                        <i class="fa-solid fa-book-bookmark text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">MENU REFERENSI</h1>
                    </div>
                </div>
            </div>

            <!-- Main Navigation Grid -->
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    
                    <!-- Identitas Sekolah -->
                    <a href="referensi/identitas.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <!-- Pengecualian: Background ikon diganti menggunakan emerald-900 -->
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-850 group-hover:scale-105 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-school"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Identitas Sekolah</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Konfigurasi profile, alamat, instansi, dan visi misi sekolah.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Kelola Data <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Pendataan Departemen -->
                    <a href="referensi/departemen.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <!-- Pengecualian: Background ikon diganti menggunakan emerald-900 -->
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-850 group-hover:scale-105 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-building-user"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Pendataan Departemen</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Kelola unit kerja, divisi, dan struktur departemen sekolah.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Kelola Data <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Pendataan Pegawai -->
                    <a href="referensi/pegawai.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <!-- Pengecualian: Background ikon diganti menggunakan emerald-900 -->
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-850 group-hover:scale-105 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-users-gear"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Pendataan Pegawai</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Manajemen data profil guru, staf, beserta bio data lengkap.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Kelola Data <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Pendataan Angkatan -->
                    <a href="referensi/angkatan.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <!-- Pengecualian: Background ikon diganti menggunakan emerald-900 -->
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-850 group-hover:scale-105 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Pendataan Angkatan</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Kelompokan data siswa berdasarkan tahun masuk/angkatan.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Kelola Data <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Pendataan Tingkat -->
                    <a href="referensi/tingkat.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <!-- Pengecualian: Background ikon diganti menggunakan emerald-900 -->
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-850 group-hover:scale-105 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Pendataan Tingkat</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Konfigurasi jenjang kelas atau tingkat pengajaran.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Kelola Data <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Pendataan Tahun Ajaran -->
                    <a href="referensi/tahunajaran.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <!-- Pengecualian: Background ikon diganti menggunakan emerald-900 -->
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-850 group-hover:scale-105 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Tahun Ajaran</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Penyusunan agenda tahun akademik aktif dan arsip.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Kelola Data <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Pendataan Semester -->
                    <a href="referensi/semester.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <!-- Pengecualian: Background ikon diganti menggunakan emerald-900 -->
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-850 group-hover:scale-105 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-circle-half-stroke"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Pendataan Semester</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Pengaturan semester aktif (Ganjil / Genap) per tahun ajaran.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Kelola Data <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Pendataan Kelas -->
                    <a href="referensi/kelas.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <!-- Pengecualian: Background ikon diganti menggunakan emerald-900 -->
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:bg-emerald-850 group-hover:scale-105 transition-all duration-300 shadow-md">
                                <i class="fa-solid fa-chalkboard"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Pendataan Kelas</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Pendaftaran ruang kelas beserta wali kelas dan kapasitasnya.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Kelola Data <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                </div>
            </div>
            
        </div>
    </div>

</body>
</html>