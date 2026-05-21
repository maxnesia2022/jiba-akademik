<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$nip = "";
if (isset($_REQUEST['nip'])) $nip = $_REQUEST['nip'];
$nama = "";
if (isset($_REQUEST['nama'])) $nama = $_REQUEST['nama'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aturan Perhitungan Nilai Rapor</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript" src="../script/validasi.js"></script>
    <script language="javascript">
    function caripegawai() {
        document.getElementById('footer_frame').src = "../blank2.php";
        document.getElementById('content_frame').src = "blank_rapor.php";
        newWindow('../library/guru.php?flag=0', 'CariPegawai','600','590','resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function acceptPegawai(nip, nama, flag) {
        document.getElementById('nip_display').value = nip;	
        document.getElementById('nama_display').value = nama;	
        document.getElementById('footer_frame').src = "perhitungan_rapor_footer.php?nip="+nip+"&nama="+nama;
        document.getElementById('content_frame').src = "blank_rapor.php";
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar */
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
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <!-- Background icon emerald-900 -->
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-calculator text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Guru & Pelajaran</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PERHITUNGAN RAPOR</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../guru.php?page=p" target="content" class="text-emerald-700 hover:underline font-semibold">Guru & Pelajaran</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Perhitungan Rapor</span>
            </div>
        </div>

        <div class="flex-1 flex gap-6 overflow-hidden">
            <!-- Sidebar Selection -->
            <div class="w-80 flex flex-col gap-6 h-full">
                <!-- Guru Selection Box -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-emerald-600"></i> Pilih Guru
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">NIP</label>
                            <div class="flex gap-2">
                                <input type="text" id="nip_display" readonly class="bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-full cursor-pointer" placeholder="Klik Cari..." onClick="caripegawai()" value="<?=$nip?>">
                                <button onClick="caripegawai()" class="bg-emerald-50 text-emerald-700 p-2.5 rounded-xl hover:bg-emerald-100 transition-colors">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Nama Guru</label>
                            <input type="text" id="nama_display" readonly class="bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-full cursor-pointer" placeholder="Nama Guru..." onClick="caripegawai()" value="<?=$nama?>">
                        </div>
                    </div>
                </div>

                <!-- Menu Sidebar Iframe -->
                <div class="flex-1 bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                    <iframe name="perhitungan_rapor_footer" id="footer_frame" src="../blank2.php" class="w-full h-full border-none"></iframe>
                </div>
            </div>

            <!-- Content Area Iframe -->
            <div class="flex-1 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden relative">
                <iframe name="perhitungan_rapor_content" id="content_frame" src="blank_rapor.php" class="w-full h-full border-none"></iframe>
            </div>
        </div>
    </div>
</body>
</html>
