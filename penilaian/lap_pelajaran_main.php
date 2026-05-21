<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

$nis = "";
if (isset($_REQUEST['nis'])) $nis = $_REQUEST['nis'];
$nama = "";
if (isset($_REQUEST['nama'])) $nama = $_REQUEST['nama'];

OpenDb();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penilaian Pelajaran</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
    function carisiswa() {
        document.getElementById('footer_frame').src = "../blank2.php";
        document.getElementById('isi_frame').src = "blank_lap_pelajaran.php";
        newWindow('../library/siswa.php?flag=0', 'CariSiswa','600','500','resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function acceptSiswa(nis, nama, flag) {
        document.getElementById('nis').value = nis;
        document.getElementById('nama').value = nama;
        document.getElementById('footer_frame').src = "../penilaian/lap_pelajaran_menu.php?nis_awal="+nis;
        document.getElementById('isi_frame').src = "../penilaian/blank_lap_pelajaran.php";	
    }
    </script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-user-tag text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Laporan Nilai</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">LAPORAN NILAI PELAJARAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../penilaian.php" target="content" class="text-emerald-700 hover:underline font-semibold">Penilaian</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Laporan Pelajaran</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Siswa Selection -->
                <div class="flex items-center gap-3">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Siswa</label>
                    <div class="flex gap-2">
                        <input name="nis" type="text" id="nis" value="<?=$nis?>" class="bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-32 shadow-sm cursor-pointer" readonly onclick="carisiswa()" placeholder="NIS" />
                        <input name="nama" type="text" id="nama" value="<?=$nama?>" class="bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-64 shadow-sm cursor-pointer" readonly onclick="carisiswa()" placeholder="Nama Siswa" />
                        <button onClick="carisiswa()" class="bg-emerald-100 text-emerald-700 p-2.5 rounded-xl hover:bg-emerald-200 transition-colors">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5 text-slate-400 text-[10px] font-bold uppercase tracking-widest italic">
                <i class="fa-solid fa-info-circle text-emerald-600"></i> Pilih siswa untuk melihat laporan
            </div>
        </div>

        <!-- Split Content Area -->
        <div class="flex-1 flex gap-6 overflow-hidden">
            <!-- Sidebar Navigation (Footer Frame) -->
            <div class="w-72 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                <div class="bg-slate-50 p-4 border-b border-slate-100 text-[10px] font-extrabold text-slate-500 uppercase tracking-widest text-center">
                    Pelajaran
                </div>
                <iframe name="footer" id="footer_frame" src="../blank2.php" class="flex-1 w-full border-none"></iframe>
            </div>

            <!-- Main Display (Isi Frame) -->
            <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
                <iframe name="isi" id="isi_frame" src="blank_lap_pelajaran.php" class="flex-1 w-full border-none"></iframe>
            </div>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
