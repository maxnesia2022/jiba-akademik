<? 
require_once("include/theme.php"); 
require_once("include/errorhandler.php");
require_once("include/sessioninfo.php");
require_once("include/common.php");
require_once("include/config.php");
require_once("include/db_functions.php");
require_once("include/sessioninfo.php");

$menu="";
if (isset($_REQUEST['menu']))
	$menu=$_REQUEST['menu'];
$content="";
if (isset($_REQUEST['content']))
	$content=$_REQUEST['content'];	
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIBAS Akademik - Top Frame</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script type="text/javascript" language="JavaScript1.2" src="design/dhtml/stmenu.js"></script>
    <script type="text/javascript" language="JavaScript1.2" src="script/ajax.js"></script>
    <script type="text/javascript" language="JavaScript1.2" src="script/tools.js"></script>
    <script type="text/javascript" language="JavaScript1.2">
    function get_fresh(){
        document.location.reload();
    }
    function chating_euy(){
        newWindow('buletin/chat/chat.php','ChattingYuk',626,565,'resizable=0,scrollbars=0,status=0,toolbar=0');
    }
    function home(){
        document.location.reload();
        parent.framecenter.location.href="home.php";
    }
    function akademik(){
        sendRequestText("get_content.php", show_content, "menu=akademik");
        parent.framecenter.location.href="home.php";
    }
    function buletin(){
        sendRequestText("get_content.php", show_content, "menu=buletin");
        parent.framecenter.location.href="home.php";
    }
    function pengaturan(){
        sendRequestText("get_content.php", show_content, "menu=pengaturan");
        parent.framecenter.location.href="home.php";
    }
    function dotnet(){
        sendRequestText("get_content.php", show_content, "menu=dotnet");
        parent.framecenter.location.href="home.php";
    }
    function logout() {
        if (confirm("Anda yakin akan menutup Aplikasi Manajemen Akademik ini?"))
            document.location.href="logout.php";
    }
    function show_content(x) {
        document.getElementById("vscroll0").innerHTML = x;
    }
    function show_wait(areaId) {
        var x = document.getElementById("waitBox").innerHTML;
        document.getElementById(areaId).innerHTML = x;
    }
    function ganti() {
        var login=document.getElementById('login').value;
        var addr="pengaturan/ganti_password2.php";
        if (login=="LANDLORD" || login=="landlord"){
            alert ('Maaf, Administrator tidak dapat mengganti password !');
            parent.framecenter.location.href="center.php";
        } else {
            newWindow(addr,'GantiPasswordUser','419','200','resizeable=0,scrollbars=0,status=0,toolbar=0');
        }
    }
    function show_info(){
        document.getElementById('menu').style.display='none';
        document.getElementById('tentang').style.display='';
        parent.content.location.href="jibasinfo.php";
    }
    function hide_info(){
        document.getElementById('menu').style.display='';
        document.getElementById('tentang').style.display='none';
        parent.content.location.href="referensi.php";
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar hide for cleaner header look */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-green-950 text-white select-none overflow-hidden m-0 p-0">
    <!-- Menggunakan background dominan green-950 ke green-950 untuk keselarasan penuh -->
    <div class="w-full bg-gradient-to-r from-green-950 via-green-950 to-green-950 border-b border-green-800/40 shadow-lg px-4 py-2 flex flex-col justify-between h-[100px]">
        <!-- Top Accessory Info Bar -->
        <div class="flex justify-between items-center text-[10px] text-green-300 font-semibold uppercase tracking-wider pb-1 border-b border-green-800/20">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Sistem Informasi Manajemen Akademik</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="javascript:void(0)" onClick="home()" class="hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-house-chimney mr-1"></i> Beranda Utama
                </a>
            </div>
        </div>

        <!-- Navigation Menu Row -->
        <div class="flex items-center justify-between overflow-x-auto no-scrollbar py-1">
            <div class="flex items-center gap-2" id="menu">
                <!-- Referensi (Background aktif/hover menggunakan emerald-900) -->
                <a href="referensi.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/40 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/30 hover:border-emerald-600">
                    <i class="fa-solid fa-book-bookmark text-amber-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1">Referensi</span>
                </a>

                <!-- PSB -->
                <a href="siswa_baru.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-user-plus text-sky-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1">P S B</span>
                </a>

                <!-- Guru -->
                <a href="guru.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-chalkboard-user text-emerald-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1 leading-tight">Guru & Mapel</span>
                </a>

                <!-- Jadwal -->
                <a href="jadwal.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-calendar-days text-rose-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1 leading-tight">Jadwal & Kal</span>
                </a>

                <!-- Kesiswaan -->
                <a href="siswa.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-users text-cyan-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1">Kesiswaan</span>
                </a>

                <!-- Presensi -->
                <a href="presensi.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-clipboard-user text-violet-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1">Presensi</span>
                </a>

                <!-- Penilaian -->
                <a href="penilaian.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-graduation-cap text-yellow-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1">Penilaian</span>
                </a>

                <!-- Ekspor Impor -->
                <a href="exim.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-file-import text-orange-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1 leading-tight">Ekspor Impor</span>
                </a>

                <!-- Kenaikan & Kelulusan -->
                <a href="kelulusan.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-award text-lime-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1 leading-tight">Kelulusan</span>
                </a>

                <!-- Mutasi -->
                <a href="mutasi.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-arrows-spin text-pink-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1">Mutasi</span>
                </a>

                <!-- Pelaporan -->
                <a href="pelaporanmenu.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-chart-pie text-teal-300 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1">Pelaporan</span>
                </a>

                <!-- Pengaturan -->
                <a href="usermenu.php" target="content" class="group flex flex-col items-center justify-center bg-emerald-900/20 hover:bg-emerald-900 active:scale-95 transition-all duration-200 rounded-lg px-2 py-1 min-w-[72px] text-center border border-emerald-800/10 hover:border-emerald-600">
                    <i class="fa-solid fa-sliders text-slate-300 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-medium text-slate-100 mt-1">Pengaturan</span>
                </a>
            </div>

            <!-- Keluar -->
            <div class="pl-4">
                <a href="javascript:logout();" class="group flex flex-col items-center justify-center bg-rose-950/40 hover:bg-rose-600/30 active:scale-95 transition-all duration-200 rounded-lg px-3 py-1 min-w-[72px] text-center border border-rose-800/40 hover:border-rose-500">
                    <i class="fa-solid fa-power-off text-rose-400 text-lg group-hover:scale-110 transition-transform duration-200"></i>
                    <span class="text-[11px] font-bold text-rose-200 mt-1">Keluar</span>
                </a>
            </div>
        </div>
    </div>
</body>
</html>