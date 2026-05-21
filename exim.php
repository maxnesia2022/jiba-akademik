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
    <title>Ekspor Impor JIBAS</title>
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
                <!-- Icon background menggunakan emerald-900 -->
                <div class="bg-emerald-900 text-white p-4 rounded-[1.25rem] shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-file-import text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Aplikasi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">EKSPOR & IMPOR</h1>
                </div>
            </div>
        </div>

        <!-- Main Cards Grid -->
        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
            
            <!-- Ekspor Form Nilai -->
            <a href="penilaian/expnilai.php" class="group bg-white p-8 rounded-[2.5rem] border border-slate-150/80 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-64 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                <div class="z-10">
                    <div class="w-14 h-14 bg-emerald-900 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-6 group-hover:scale-105 transition-all shadow-lg shadow-emerald-900/20">
                        <i class="fa-solid fa-file-excel text-emerald-300"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-lg mb-2">Ekspor Form Nilai</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Unduh dokumen Excel berisi formulir pengisian data nilai akademik siswa secara kolektif per kelas.</p>
                </div>
                <span class="text-xs font-bold text-emerald-800 flex items-center gap-1.5 group-hover:translate-x-1.5 transition-transform duration-200">
                    Mulai Ekspor <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>

            <!-- Impor Nilai -->
            <a href="penilaian/impnilai.php" class="group bg-white p-8 rounded-[2.5rem] border border-slate-150/80 hover:border-green-500/30 hover:shadow-2xl hover:shadow-green-500/10 transition-all duration-300 flex flex-col justify-between h-64 relative overflow-hidden">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-emerald-50/40 rounded-[40%_60%_70%_30%] group-hover:scale-110 transition-transform duration-300"></div>
                <div class="z-10">
                    <div class="w-14 h-14 bg-emerald-900 text-white rounded-[1.5rem] flex items-center justify-center text-2xl mb-6 group-hover:scale-105 transition-all shadow-lg shadow-emerald-900/20">
                        <i class="fa-solid fa-file-arrow-up text-emerald-300"></i>
                    </div>
                    <h3 class="font-extrabold text-slate-800 text-lg mb-2">Impor Data Nilai</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">Unggah dan impor kembali data nilai siswa secara otomatis ke sistem dari file Excel yang telah diisi.</p>
                </div>
                <span class="text-xs font-bold text-emerald-800 flex items-center gap-1.5 group-hover:translate-x-1.5 transition-transform duration-200">
                    Mulai Impor <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>

        </div>

    </div>

</body>
</html>