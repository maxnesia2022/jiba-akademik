<?php
require_once('../include/config.php');
require_once('../cek.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Query Error Log</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Pengaturan Sistem</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">QUERY ERROR LOG</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../usermenu.php" target="content" class="text-emerald-700 hover:underline font-semibold">Pengaturan</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Query Error Log</span>
            </div>
        </div>

        <!-- Info Bar -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></div>
                <span class="text-xs font-bold text-slate-600 uppercase tracking-wider">System Error Journal</span>
            </div>
            <button onClick="document.location.reload()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                <i class="fa-solid fa-arrows-rotate text-emerald-600"></i> Refresh Log
            </button>
        </div>

        <!-- Log Area -->
        <div class="flex-1 bg-slate-900 rounded-3xl border border-slate-800 shadow-inner overflow-hidden flex flex-col p-1">
            <?php
            $logFile = realpath(dirname(__FILE__)) . "/../../log/akademik-error.log";
            $logFile = str_replace("\\", "/", $logFile);
            if (!file_exists($logFile)) {
                $logFileUrl = ""; 
            } else {
                $r = rand(1, 30000);
                $docRoot = $_SERVER['DOCUMENT_ROOT'];
                $logFileUrl = "http://" . $_SERVER['SERVER_ADDR'] . str_replace($docRoot, "", $logFile) . "?$r";
            } 
            
            if ($logFileUrl != "") { ?>
                <iframe name="logContent" id="logContent" 
                        class="w-full h-full border-none rounded-2xl bg-slate-950 text-emerald-400 font-mono text-xs"
                        src="<?=$logFileUrl?>"></iframe>
            <?php } else { ?>
                <div class="flex-1 flex flex-col items-center justify-center text-center p-10">
                    <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mb-6 text-slate-600">
                        <i class="fa-solid fa-file-circle-check text-4xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-slate-400 mb-2">Tidak Ada Log Error</h2>
                    <p class="text-slate-500 text-sm max-w-md leading-relaxed">
                        Sistem berjalan dengan normal. Belum ditemukan adanya catatan kesalahan query pada file log.
                    </p>
                </div>
            <?php } ?>
        </div>

        <p class="mt-4 text-[10px] text-slate-400 font-bold text-center uppercase tracking-widest italic">
            File log berlokasi di: <span class="text-slate-500"><?=$logFile?></span>
        </p>

    </div>

    <script>
    function scrollToBottom() {
        var logFrame = document.getElementById("logContent");
        if (logFrame) {
            var dh = logFrame.contentWindow.document.body.scrollHeight;
            var fh = logFrame.height;
            if (dh > fh) {
                var movelen = dh - fh;
                logFrame.contentWindow.scrollTo(0, movelen);
            }
        }
    }
    setTimeout(scrollToBottom, 1000);
    </script>

</body>
</html>
