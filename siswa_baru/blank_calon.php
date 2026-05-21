<?
 ?>
<? 
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
    <title>Pendataan Calon Siswa - Placeholder</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<!-- Menggunakan m-0 p-0 dan bg-green-950 agar menyatu mulus dengan layout header atas -->
<body class="bg-green-950 text-slate-800 select-none overflow-hidden m-0 p-0">

    <!-- 
      KARTU BAWAH (BOTTOM SPLIT-CARD):
      - Menggunakan rounded-b-[2.5rem] md:rounded-b-[3rem] (hanya melengkung di sudut bawah).
      - Menghilangkan pembatas atas agar menyatu sempurna dengan kartu di atasnya.
    -->
    <div class="px-4 md:px-6 pb-4 md:pb-6 h-screen">
        <div class="bg-slate-50 rounded-b-[2.5rem] md:rounded-b-[3rem] border-b border-x border-green-800/30 p-10 shadow-2xl h-full flex flex-col items-center justify-center text-center">
            
            <? 	OpenDb();		
            $sql = "SELECT * FROM departemen";    
            $result = QueryDb($sql);
            if (@mysqli_num_rows($result) > 0){ ?>	
                <!-- Status OK State -->
                <div class="w-20 h-20 bg-emerald-50 text-emerald-800 rounded-full flex items-center justify-center text-3xl mb-6 shadow-inner animate-bounce">
                    <i class="fa-solid fa-arrows-to-eye"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-2">Siap Menampilkan Data</h3>
                <p class="text-sm text-slate-500 max-w-md leading-relaxed">
                    Silakan tentukan Departemen, Proses Penerimaan, dan Kelompok di panel atas, kemudian klik tombol <strong class="text-emerald-900 font-bold">Tampilkan Data</strong> untuk melihat daftar calon siswa.
                </p>
            <? } else { ?>
                <!-- No Departemen Warning State -->
                <div class="w-20 h-20 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-3xl mb-6 shadow-inner">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-xl font-extrabold text-slate-800 mb-2">Belum Ada Data Departemen</h3>
                <p class="text-sm text-slate-500 max-w-sm leading-relaxed">
                    Silakan isi dan konfigurasi data Departemen terlebih dahulu di dalam menu <strong class="text-rose-600 font-bold">Departemen</strong> pada bagian Referensi.
                </p>
            <? } ?>

        </div>
    </div>

</body>
</html>