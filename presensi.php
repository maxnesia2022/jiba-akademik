<?
include('cek.php');
require_once('include/sessioninfo.php');
$page='ph';
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kehadiran JIBAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/tooltips.css">
    <script type="text/javascript" src="script/tooltips.js"></script>
    <script type="text/javascript">
    function show(id) {
        // Update input status
        document.getElementById('actmenu').value = id;
        
        // Hide all slices
        document.getElementById('slice_pp').style.display = 'none';
        document.getElementById('slice_ph').style.display = 'none';
        document.getElementById('slice_pk').style.display = 'none';
        
        // Show current slice
        document.getElementById('slice_' + id).style.display = '';

        // Update Tab Classes dynamically
        const tabs = ['ph', 'pp', 'pk'];
        tabs.forEach(t => {
            const btn = document.getElementById('tab_btn_' + t);
            if (t === id) {
                btn.className = "flex-1 md:flex-none py-3 px-6 text-sm font-bold bg-white text-emerald-900 rounded-2xl shadow-sm border border-emerald-100/30 transition-all duration-200 active:scale-95";
            } else {
                btn.className = "flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 hover:text-white hover:bg-emerald-900/40 rounded-2xl transition-all duration-200 active:scale-95";
            }
        });
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" onload="show('<?=$page?>')">

    <input type="hidden" id="actmenu" name="actmenu" value="<?=$page?>" />  

    <!-- TAB CONTAINER BAR (MENYATU DENGAN TEMA EMERALD-900) -->
    <div class="max-w-6xl mx-auto mb-6 bg-emerald-950 border border-emerald-800/40 p-2 rounded-[1.75rem] shadow-inner flex flex-wrap gap-2">
        <button id="tab_btn_ph" onclick="show('ph')" class="flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 rounded-2xl transition-all">
            <i class="fa-solid fa-clock-rotate-left mr-1.5"></i> Presensi Harian
        </button>
        <button id="tab_btn_pp" onclick="show('pp')" class="flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 rounded-2xl transition-all">
            <i class="fa-solid fa-book mr-1.5"></i> Presensi Pelajaran
        </button>
        <button id="tab_btn_pk" onclick="show('pk')" class="flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 rounded-2xl transition-all">
            <i class="fa-solid fa-circle-nodes mr-1.5"></i> Presensi Kegiatan
        </button>
    </div>

    <!-- FLOATING CANVAS (KONTEN UTAMA) -->
    <div class="max-w-6xl mx-auto min-h-[calc(100vh-8rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- SECTION 1: PRESENSI PELAJARAN (pp) -->
        <div id="slice_pp" style="display:none">
            <!-- Header -->
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 mb-8">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-book-open text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PRESENSI PELAJARAN</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Cetak Form Presensi -->
                <a href="presensi/formpresensi_pelajaran.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-print"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Cetak Form Presensi</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Unduh & cetak format form lembaran presensi pelajaran fisik.</p>
                    </div>
                </a>

                <!-- Pengisian Presensi -->
                <a href="presensi/presensi_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Pengisian Presensi</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Kelola & input jurnal data kehadiran harian per jam pelajaran.</p>
                    </div>
                </a>

                <!-- Panel Laporan (Merger 5 Links Bawaan) -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-md flex flex-col justify-between h-auto">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-emerald-900 text-white rounded-xl flex items-center justify-center text-base shadow-md">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Laporan Pelajaran</h3>
                        </div>
                        <ul class="space-y-2 text-xs font-semibold text-slate-600">
                            <li><a href="presensi/lap_siswa_main.php" class="hover:text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px] text-emerald-600"></i> Laporan Presensi Siswa</a></li>
                            <li><a href="presensi/lap_kelas_main.php" class="hover:text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px] text-emerald-600"></i> Laporan Presensi per Kelas</a></li>
                            <li><a href="presensi/lap_pengajar_main.php" class="hover:text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px] text-emerald-600"></i> Laporan Presensi Pengajar</a></li>
                            <li><a href="presensi/lap_absen_main.php" class="hover:text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px] text-emerald-600"></i> Laporan Siswa Tidak Hadir</a></li>
                            <li><a href="presensi/lap_refleksi_main.php" class="hover:text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px] text-emerald-600"></i> Laporan Refleksi Mengajar</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Statistik (Merger 2 Links Bawaan) -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-md flex flex-col justify-between h-auto sm:col-span-2 lg:col-span-3">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-emerald-900 text-white rounded-xl flex items-center justify-center text-base shadow-md">
                                <i class="fa-solid fa-pie-chart"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Statistik Kehadiran</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="presensi/statistik_siswa_main.php" class="bg-slate-50 hover:bg-emerald-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3 transition-colors duration-200">
                                <i class="fa-solid fa-chart-user text-emerald-600 text-lg"></i>
                                <span class="text-xs font-bold text-slate-800">Statistik Kehadiran Siswa</span>
                            </a>
                            <a href="presensi/statistik_kelas_main.php" class="bg-slate-50 hover:bg-emerald-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3 transition-colors duration-200">
                                <i class="fa-solid fa-diagram-project text-emerald-600 text-lg"></i>
                                <span class="text-xs font-bold text-slate-800">Statistik Kehadiran Setiap Kelas</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 2: PRESENSI HARIAN (ph) -->
        <div id="slice_ph" style="display:none">
            <!-- Header -->
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 mb-8">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PRESENSI HARIAN</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Cetak Form Presensi Harian -->
                <a href="presensi/formpresensi_harian.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Cetak Form Harian</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Unduh format cetak lembaran absensi kehadiran harian kelas.</p>
                    </div>
                </a>

                <!-- Input Presensi Harian -->
                <a href="presensi/input_presensi_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-48 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Input Presensi Harian</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pencatatan real-time kehadiran (Hadir, Sakit, Izin, Alpha) harian.</p>
                    </div>
                </a>

                <!-- Panel Laporan (Merger 3 Links Bawaan) -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-md flex flex-col justify-between h-auto">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-emerald-900 text-white rounded-xl flex items-center justify-center text-base shadow-md">
                                <i class="fa-solid fa-file-signature"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Laporan Harian</h3>
                        </div>
                        <ul class="space-y-3 text-xs font-semibold text-slate-600">
                            <li><a href="presensi/lap_hariansiswa_main.php" class="hover:text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px] text-emerald-600"></i> Laporan Presensi Harian Siswa</a></li>
                            <li><a href="presensi/lap_hariankelas_main.php" class="hover:text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px] text-emerald-600"></i> Laporan Presensi Harian per Kelas</a></li>
                            <li><a href="presensi/lap_harianabsen_main.php" class="hover:text-emerald-700 flex items-center gap-1"><i class="fa-solid fa-chevron-right text-[8px] text-emerald-600"></i> Laporan Harian Siswa Tidak Hadir</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Statistik (Merger 2 Links Bawaan) -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-md flex flex-col justify-between h-auto sm:col-span-2 lg:col-span-3">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-emerald-900 text-white rounded-xl flex items-center justify-center text-base shadow-md">
                                <i class="fa-solid fa-chart-column"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Statistik Kehadiran Harian</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="presensi/statistik_hariansiswa_main.php" class="bg-slate-50 hover:bg-emerald-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3 transition-colors duration-200">
                                <i class="fa-solid fa-user-check text-emerald-600 text-lg"></i>
                                <span class="text-xs font-bold text-slate-800">Statistik Kehadiran Siswa</span>
                            </a>
                            <a href="presensi/statistik_hariankelas_main.php" class="bg-slate-50 hover:bg-emerald-50 border border-slate-100 p-4 rounded-2xl flex items-center gap-3 transition-colors duration-200">
                                <i class="fa-solid fa-chart-line text-emerald-600 text-lg"></i>
                                <span class="text-xs font-bold text-slate-800">Statistik Kehadiran per Kelas</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: PRESENSI KEGIATAN (pk) -->
        <div id="slice_pk" style="display:none">
            <!-- Header -->
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 mb-8">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-circle-nodes text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PRESENSI KEGIATAN</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- JIBAS Portal Link (External Card) -->
                <a href="http://www.jibas.net/content/sptfgr/sptfgr.php" target="_blank" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-emerald-500/30 hover:shadow-2xl hover:shadow-emerald-500/10 transition-all duration-300 flex flex-col justify-between h-56 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Informasi JIBAS Portal</h3>
                        <p class="text-xs text-slate-500 line-clamp-3">Hubungkan modul presensi kegiatan dengan portal JIBAS resmi di internet.</p>
                    </div>
                </a>

                <!-- Panel Links (Siswa & Guru) -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-md flex flex-col justify-between h-auto">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-emerald-900 text-white rounded-xl flex items-center justify-center text-base shadow-md">
                                <i class="fa-solid fa-network-wired"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base">Kelola Agenda Kegiatan</h3>
                        </div>
                        <div class="grid grid-cols-1 gap-2.5 text-xs font-bold text-slate-700">
                            <a href="presensi/presensikeg.siswa2.php" class="p-3 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-2.5 transition-colors">
                                <i class="fa-solid fa-user-graduate text-emerald-600"></i> Presensi Kegiatan Siswa
                            </a>
                            <a href="presensi/presensikeg.rekapsiswa.php" class="p-3 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-2.5 transition-colors">
                                <i class="fa-solid fa-clipboard-list text-emerald-600"></i> Rekapitulasi Kegiatan Siswa
                            </a>
                            <a href="presensi/presensikeg.guru.php" class="p-3 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-2.5 transition-colors">
                                <i class="fa-solid fa-chalkboard-user text-emerald-600"></i> Presensi Kegiatan Guru
                            </a>
                            <a href="presensi/presensikeg.rekapguru.php" class="p-3 bg-slate-50 hover:bg-emerald-50 hover:text-emerald-800 border border-slate-100 rounded-xl flex items-center gap-2.5 transition-colors">
                                <i class="fa-solid fa-list-check text-emerald-600"></i> Rekapitulasi Kegiatan Guru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>