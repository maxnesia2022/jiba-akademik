<?php
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
$tahunajaran = "";
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];
$tingkat = "";
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];

OpenDb();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    <script language="JavaScript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/ajax.js"></script>
    <script language="javascript">
    function change_departemen() {
        var departemen = document.getElementById("departemen").value;
        parent.topkelas.location.href = "topkelas.php?departemen="+departemen;
        parent.bottomkelas.location.href = "blank_kelas.php";
    }

    function change() {
        var departemen = document.getElementById("departemen").value;
        var tingkat = document.getElementById("tingkat").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        parent.topkelas.location.href = "topkelas.php?departemen="+departemen+"&tingkat="+tingkat+"&tahunajaran="+tahunajaran;
        parent.bottomkelas.location.href = "blank_kelas.php";
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            document.getElementById(elemName).focus();
            if (elemName == 'tabel') {
                show_kelas();
            } 
            return false;
        } 
        return true;
    }

    function show_kelas() {
        var departemen = document.getElementById("departemen").value;
        var tingkat = document.getElementById("tingkat").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        if (departemen==""){
            alert ('Departemen tidak boleh kosong !');
            return false;
        }
        if (tingkat==""){
            alert ('Tingkat tidak boleh kosong !');
            return false;
        }
        if (tahunajaran==""){
            alert ('Tahun ajaran tidak boleh kosong !');
            return false;
        }
        
        parent.bottomkelas.location.href="bottomkelas.php?departemen="+departemen+"&tingkat="+tingkat+"&tahunajaran="+tahunajaran;
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 p-4 md:p-6 select-none overflow-hidden" onload="document.getElementById('departemen').focus()">

    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full bg-slate-50 rounded-[2rem] shadow-2xl border border-green-800/30 p-6">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-4 bg-white p-3 rounded-2xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-3 rounded-xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-users-rectangle text-xl"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-widest">Referensi Akademik</span>
                    <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">KELAS</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-4 py-2 rounded-xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../referensi.php" target="content" class="text-emerald-700 hover:underline font-semibold">Referensi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Kelas</span>
            </div>
        </div>

        <!-- Control Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col lg:flex-row lg:items-center justify-start gap-4">
            
            <div class="flex flex-col gap-1.5">
                <label for="departemen" class="text-xs font-bold text-slate-700">Departemen</label>
                <div class="relative">
                    <select name="departemen" id="departemen" onChange="change_departemen()" onKeyPress="return focusNext('tahunajaran', event)" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-48 pl-3 pr-8 py-2 shadow-sm transition-colors cursor-pointer">
                        <?php
                        $dep = getDepartemen(SI_USER_ACCESS());    
                        foreach($dep as $value) {
                            if ($departemen == "") $departemen = $value;
                            echo "<option value='$value' ".StringIsSelected($value, $departemen).">$value</option>";
                        }
                        ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="tahunajaran" class="text-xs font-bold text-slate-700">Tahun Ajaran</label>
                <div class="relative">
                    <select name="tahunajaran" id="tahunajaran" onChange="change()" onKeyPress="return focusNext('tingkat', event)" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-48 pl-3 pr-8 py-2 shadow-sm transition-colors cursor-pointer">
                        <?php
                        $sql_tahunajaran = "SELECT * FROM tahunajaran where departemen='$departemen' ORDER BY aktif DESC, tglmulai DESC";
                        $result_tahunajaran = QueryDb($sql_tahunajaran);
                        while ($row_tahunajaran = @mysqli_fetch_array($result_tahunajaran)) {
                            if ($tahunajaran == "") $tahunajaran = $row_tahunajaran['replid'];
                            $ada = $row_tahunajaran['aktif'] ? "(Aktif)" : "";	
                            echo "<option value='".urlencode($row_tahunajaran['replid'])."' ".IntIsSelected($row_tahunajaran['replid'], $tahunajaran).">".$row_tahunajaran['tahunajaran']." ".$ada."</option>";
                        }
                        ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="tingkat" class="text-xs font-bold text-slate-700">Tingkat</label>
                <div class="relative">
                    <select name="tingkat" id="tingkat" onChange="change()" onKeyPress="return focusNext('tabel', event)" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-48 pl-3 pr-8 py-2 shadow-sm transition-colors cursor-pointer">
                        <?php
                        $sql_tingkat = "SELECT * FROM tingkat where departemen='$departemen' AND aktif=1 ORDER BY urutan";
                        $result_tingkat = QueryDb($sql_tingkat);
                        while ($row_tingkat = @mysqli_fetch_array($result_tingkat)) {
                            if ($tingkat == "") $tingkat = $row_tingkat['replid'];
                            echo "<option value='".urlencode($row_tingkat['replid'])."' ".IntIsSelected($row_tingkat['replid'], $tingkat).">".$row_tingkat['tingkat']."</option>";
                        }
                        ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1.5 justify-end h-full mt-5">
                <button onClick="show_kelas()" id="tabel" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-sm py-2 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95 h-[38px]">
                    <i class="fa-solid fa-search"></i> Tampilkan
                </button>
            </div>

        </div>

    </div>

</body>
</html>
<?php CloseDb(); ?>