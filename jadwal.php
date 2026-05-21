<?
include('cek.php');
require_once('include/sessioninfo.php');
$page='j';
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal & Kalender Akademik JIBAS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style/tooltips.css">
    <script type="text/javascript" src="script/tooltips.js"></script>
    <script type="text/javascript">
    function show(id){
        document.getElementById('actmenu').value = id;
        
        // Hide all slices
        document.getElementById('slice_j').style.display = 'none';
        document.getElementById('slice_k').style.display = 'none';
        
        // Show current slice
        document.getElementById('slice_' + id).style.display = '';

        // Update Tab Classes dynamically
        const tabs = ['j', 'k'];
        tabs.forEach(t => {
            const btn = document.getElementById('tab_btn_' + t);
            if (btn) {
                if (t === id) {
                    btn.className = "flex-1 md:flex-none py-3 px-6 text-sm font-bold bg-white text-emerald-900 rounded-2xl shadow-sm border border-emerald-100/30 transition-all duration-200 active:scale-95";
                } else {
                    btn.className = "flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 hover:text-white hover:bg-emerald-900/40 rounded-2xl transition-all duration-200 active:scale-95";
                }
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
        <button id="tab_btn_j" onclick="show('j')" class="flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 rounded-2xl transition-all">
            <i class="fa-solid fa-calendar-week mr-1.5"></i> Jadwal Pelajaran
        </button>
        <button id="tab_btn_k" onclick="show('k')" class="flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 rounded-2xl transition-all">
            <i class="fa-solid fa-calendar-days mr-1.5"></i> Kalender Akademik
        </button>
    </div>

    <!-- FLOATING CANVAS (KONTEN UTAMA) -->
    <div class="max-w-6xl mx-auto min-h-[calc(100vh-8rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- SECTION 1: JADWAL PELAJARAN (slice_j) -->
        <div id="slice_j" style="display:none">
            <!-- Header -->
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 mb-8">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-calendar-week text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">JADWAL PELAJARAN</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Definisi Jam Belajar -->
                <a href="jadwal/definisi_jam.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Jam Belajar</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pendefinisian durasi dan jadwal jam KBM harian sekolah.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Jadwal Guru -->
                <a href="jadwal/jadwal_guru_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Jadwal Guru</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Penyusunan alokasi jam mengajar bagi masing-masing guru.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Jadwal Kelas -->
                <a href="jadwal/jadwal_kelas_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Jadwal Kelas</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Penyusunan mata pelajaran aktif mingguan per ruang kelas.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Rekapitulasi Jadwal -->
                <a href="jadwal/rekap_jadwal_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Rekapitulasi</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Tinjauan rekap seluruh jadwal mata pelajaran di sekolah.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>
            </div>
        </div>

        <!-- SECTION 2: KALENDER AKADEMIK (slice_k) -->
        <div id="slice_k" style="display:none">
            <!-- Header -->
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 mb-8">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-calendar-days text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">KALENDER AKADEMIK</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <!-- Tahun Ajaran Alert Link -->
                <div onClick="alert('Untuk mendata Tahun Ajaran, \nSilakan masuk ke menu Tahun Ajaran di bagian Referensi');" class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 hover:border-amber-500/30 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-300 flex flex-col justify-between h-56 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 w-32 h-32 bg-amber-50 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-14 h-14 bg-amber-500 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-calendar-plus"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-lg mb-2">Tahun Ajaran</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Pemberitahuan panduan pengisian agenda kalender akademik melalui menu referensi.</p>
                    </div>
                    <span class="text-xs font-bold text-amber-600 flex items-center gap-1.5">
                        Info Pengisian <i class="fa-solid fa-circle-info text-[10px]"></i>
                    </span>
                </div>

                <!-- Pendataan Kalender Akademik -->
                <a href="jadwal/kalender_main.php" class="group bg-white p-8 rounded-[2.5rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-56 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-32 h-32 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-14 h-14 bg-emerald-900 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-lg mb-2">Pendataan Kalender</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Pengisian draf agenda libur, ujian sekolah, rapat dinas, dan upacara.</p>
                    </div>
                    <span class="text-xs font-bold text-emerald-800 flex items-center gap-1.5 group-hover:translate-x-1.5 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>
            </div>
        </div>

    </div>

</body>
</html>