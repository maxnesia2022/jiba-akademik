<?php
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blank Kelas</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: transparent;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen m-0 p-4 overflow-hidden select-none">
    
    <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-12 text-center max-w-xl mx-auto">
        <?php 
        OpenDb();		
        $sql = "SELECT * FROM departemen";    
        $result = QueryDb($sql);
        if (@mysqli_num_rows($result) > 0){
        ?>	
            <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner border border-emerald-100">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Pilih Filter Data</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Klik tombol <span class="inline-flex items-center gap-1.5 px-2 py-1 bg-emerald-900 text-white rounded-lg text-xs font-bold mx-1"><i class="fa-solid fa-search"></i> Tampilkan</span> di atas untuk melihat daftar kelas sesuai dengan Departemen, Tahun Ajaran, dan Tingkat yang terpilih.</p>
        <?php } else { ?>
            <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 shadow-inner border border-rose-100">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Data Departemen Kosong</h3>
            <p class="text-sm text-slate-500 leading-relaxed">Belum ada data Departemen yang tersedia. Silakan isi terlebih dahulu di menu <strong class="text-slate-700">Departemen</strong> pada bagian Referensi.</p>
        <?php } 
        CloseDb();
        ?>     
    </div>

</body>
</html>