<?
include('cek.php');
require_once('include/sessioninfo.php');

$page='p';
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelajaran & Manajemen Guru JIBAS</title>
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
        document.getElementById('slice_p').style.display = 'none';
        document.getElementById('slice_g').style.display = 'none';
        
        // Show current slice
        document.getElementById('slice_' + id).style.display = '';

        // Update Tab Classes dynamically
        const tabs = ['p', 'g'];
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
        <button id="tab_btn_p" onclick="show('p')" class="flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 rounded-2xl transition-all">
            <i class="fa-solid fa-book-bookmark mr-1.5"></i> Pelajaran & Aturan
        </button>
        <button id="tab_btn_g" onclick="show('g')" class="flex-1 md:flex-none py-3 px-6 text-sm font-semibold text-emerald-200 rounded-2xl transition-all">
            <i class="fa-solid fa-chalkboard-user mr-1.5"></i> Manajemen Guru
        </button>
    </div>

    <!-- FLOATING CANVAS (KONTEN UTAMA) -->
    <div class="max-w-6xl mx-auto min-h-[calc(100vh-8rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- SECTION 1: PELAJARAN (slice_p) -->
        <div id="slice_p" style="display:none">
            <!-- Header -->
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 mb-8">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-book text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">MANAJEMEN PELAJARAN</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left Grid Modules -->
                <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Pendataan Pelajaran -->
                    <a href="guru/pelajaran.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                                <i class="fa-solid fa-book-bookmark"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Daftar Pelajaran</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Pendataan daftar mata pelajaran wajib, muatan lokal, dan tambahan.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- RPP -->
                    <a href="guru/rpp_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                                <i class="fa-solid fa-file-signature"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Data RPP</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Manajemen Rencana Program Pembelajaran serta silabus mengajar.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Jenis Pengujian -->
                    <a href="guru/jenis_pengujian.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                                <i class="fa-solid fa-vial"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Jenis Pengujian</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Kategori jenis pengujian siswa (tertulis, lisan, atau praktik).</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Perhitungan Rapor -->
                    <a href="guru/perhitungan_rapor.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                                <i class="fa-solid fa-calculator"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Perhitungan Rapor</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Formula pembobotan nilai harian dan ujian untuk akumulasi rapor.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>

                    <!-- Aturan Grading Nilai -->
                    <a href="guru/aturannilai_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden sm:col-span-2 md:col-span-1">
                        <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                        <div class="z-10">
                            <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                                <i class="fa-solid fa-arrow-up-a-z"></i>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Aturan Grading</h3>
                            <p class="text-xs text-slate-500 line-clamp-2">Pengaturan batas interval konversi nilai angka ke huruf mutu.</p>
                        </div>
                        <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                            Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </a>
                </div>

                <!-- Right Configuration Panel (Merger Sidebar) -->
                <div class="flex flex-col gap-6">
                    <a href="guru/aspeknilai.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-emerald-900 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-900/30">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-sm mb-1">Aspek Penilaian</h3>
                        <p class="text-xs text-slate-400">Atur kriteria penilaian (Kognitif, Afektif, Psikomotorik).</p>
                    </a>

                    <a href="guru/kelompokpelajaran.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-xl transition-all duration-300 flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-emerald-900 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-emerald-900/30">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-sm mb-1">Kelompok Pelajaran</h3>
                        <p class="text-xs text-slate-400">Kelompokkan mata pelajaran (Umum, Kejuruan, Agama).</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- SECTION 2: GURU (slice_g) -->
        <div id="slice_g" style="display:none">
            <!-- Header -->
            <div class="flex items-center gap-4 bg-white p-5 rounded-[2rem] border border-green-100 shadow-md shadow-green-500/5 mb-8">
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-chalkboard-user text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">MANAJEMEN KETENAGAAN GURU</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Status Guru -->
                <a href="guru/statusguru.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-user-shield"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Status Guru</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pendataan tipe kepegawaian (Guru Tetap Yayasan, GTT, Honorer).</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Pendataan Guru -->
                <a href="guru/guru_main.php" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-emerald-900 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-id-card-clip"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Pendataan Guru</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Registrasi penugasan guru pengampu dan penentuan beban mengajar.</p>
                    </div>
                    <span class="text-xs font-semibold text-emerald-800 flex items-center gap-1 group-hover:translate-x-1 transition-transform duration-200">
                        Masuk Modul <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </a>

                <!-- Alert Pelajaran -->
                <div onclick="alert('Gunakan Pendataan Pelajaran di menu Pelajaran untuk mendata pelajaran');" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-amber-500/30 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-amber-50 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-amber-500 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Pelajaran Pendukung</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pemberitahuan panduan korelasi guru dengan mata pelajaran akademik.</p>
                    </div>
                    <span class="text-xs font-bold text-amber-600 flex items-center gap-1.5">
                        Info Modul <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                    </span>
                </div>

                <!-- Alert Pegawai -->
                <div onclick="alert('Gunakan menu Pegawai di bagian referensi untuk mendata pegawai');" class="group bg-white p-6 rounded-[2rem] border border-slate-100 hover:border-amber-500/30 hover:shadow-2xl hover:shadow-amber-500/10 transition-all duration-300 flex flex-col justify-between h-52 relative overflow-hidden cursor-pointer">
                    <div class="absolute -right-4 -top-4 w-28 h-28 bg-amber-50 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                    <div class="z-10">
                        <div class="w-12 h-12 bg-amber-500 text-white rounded-[1.25rem] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition-all shadow-md">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-base mb-1">Koneksi Biodata</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">Pemberitahuan bahwa data induk pegawai dikelola pada menu referensi pegawai.</p>
                    </div>
                    <span class="text-xs font-bold text-amber-600 flex items-center gap-1.5">
                        Info Modul <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                    </span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>