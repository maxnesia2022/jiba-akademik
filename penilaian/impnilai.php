<?
require_once('../cek.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impor Nilai Pelajaran</title>
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

    <script language="JavaScript" src="../script/jquery-1.9.1.js"></script>
    <script language="JavaScript" src="../script/tools.js"></script>
    <script language="JavaScript">
    <? require_once("impnilai.js.php"); ?>
    </script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-file-import text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Ekspor & Impor</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">IMPOR NILAI</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../exim.php" target="content" class="text-emerald-700 hover:underline font-semibold">Ekspor & Impor</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Impor Nilai</span>
            </div>
        </div>

        <!-- Filter/Action Row -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="flex-1 w-full">
                    <label for="fexcel" class="block text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 ml-1">File Form Nilai (*.xlsx)</label>
                    <div class="relative group">
                        <input type="file" name="fexcel" id="fexcel" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-all cursor-pointer bg-slate-50 border border-slate-200 rounded-xl px-2 py-1" />
                    </div>
                </div>
                <div class="pt-6">
                    <button id="btProses" onClick="uploadFile()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-3 px-10 rounded-xl shadow-md transition-all duration-200 active:scale-95 whitespace-nowrap">
                        <i class="fa-solid fa-cloud-arrow-up"></i> PROSES IMPOR
                    </button>
                </div>
            </div>
        </div>

        <!-- Reader Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="bg-slate-50 p-4 border-b border-slate-100 flex items-center justify-between">
                <span class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest">Status Log / Pembacaan File</span>
                <div class="flex gap-2">
                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                    <div class="w-2 h-2 rounded-full bg-slate-300"></div>
                </div>
            </div>
            <div id="divReader" class="flex-1 p-6 overflow-auto text-xs font-mono leading-relaxed text-slate-600 bg-slate-50/30">
                <!-- Log output will appear here -->
                <div class="flex flex-col items-center justify-center h-full text-slate-300">
                    <i class="fa-solid fa-terminal text-4xl mb-4 opacity-20"></i>
                    <p class="font-sans italic">Siap memproses file...</p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
