<?
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
$semester = "";
if (isset($_REQUEST['semester']))
	$semester = $_REQUEST['semester'];
$tingkat = "";
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
$kelas = "";
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];

$ERROR_MSG = "";

OpenDb();

// Get default values if not set
if ($departemen == "") {
    $dep = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep[0];
}

if ($tahunajaran == "") {
    $sql = "SELECT replid FROM tahunajaran where departemen='$departemen' AND aktif = 1";
    $result = QueryDb($sql);
    $row = mysqli_fetch_array($result);
    $tahunajaran = $row['replid'];
}

if ($semester == "") {
    $sql = "SELECT replid FROM semester where departemen='$departemen' AND aktif = 1";
    $result = QueryDb($sql);
    $row = @mysqli_fetch_array($result);
    $semester = $row['replid'];
}

if ($tingkat == "") {
    $sql = "SELECT replid FROM tingkat WHERE aktif=1 AND departemen='$departemen' ORDER BY urutan LIMIT 1";	
    $result = QueryDb($sql);
    $row = mysqli_fetch_array($result);
    $tingkat = $row['replid'];
}

if ($kelas == "" && $tahunajaran != "" && $tingkat != "") {
    $sql = "SELECT replid FROM kelas WHERE aktif=1 AND idtahunajaran = '$tahunajaran' AND idtingkat = '$tingkat' ORDER BY kelas LIMIT 1";	
    $result = QueryDb($sql);
    $row = mysqli_fetch_array($result);
    $kelas = $row['replid'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Form Presensi Harian</title>
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
    function change_dep() {
        var departemen = document.getElementById("departemen").value;
        document.location.href = "formpresensi_harian.php?departemen="+departemen;
    }

    function change_tingkat() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var semester = document.getElementById("semester").value;
        var tingkat = document.getElementById("tingkat").value;
        document.location.href = "formpresensi_harian.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&semester="+semester+"&tingkat="+tingkat;
    }

    function change_kelas() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var semester = document.getElementById("semester").value;
        var tingkat = document.getElementById("tingkat").value;
        var kelas = document.getElementById("kelas").value;
        document.location.href = "formpresensi_harian.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&semester="+semester+"&tingkat="+tingkat+"&kelas="+kelas;
    }

    function cetaklah() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var semester = document.getElementById("semester").value;
        var kelas = document.getElementById("kelas").value;
        
        if (kelas == "") {
            alert('Kelas tidak boleh kosong');
            return false;
        }
        newWindow('formpresensi_harian_cetak.php?departemen='+departemen+'&tahunajaran='+tahunajaran+'&semester='+semester+'&kelas='+kelas,'CetakFormPresensiHarian','790','850','resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            if (elemName == 'cetak') {
                cetaklah();
            } else {
                document.getElementById(elemName).focus();
            }
            return false;
        }
        return true;
    }
    </script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" onload="document.getElementById('departemen').focus()">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-print text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Presensi</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">CETAK FORM PRESENSI HARIAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../presensi.php?page=ph" target="content" class="text-emerald-700 hover:underline font-semibold">Presensi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Cetak Form Presensi Harian</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Departemen -->
                <div class="flex flex-col gap-2">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="change_dep()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-2xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm transition-colors cursor-pointer">
                            <? $dep = getDepartemen(SI_USER_ACCESS());    
                            foreach($dep as $value) { ?>
                                <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Tahun Ajaran -->
                <div class="flex flex-col gap-2">
                    <label for="tahun" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Tahun Ajaran</label>
                    <? 
                    $sql = "SELECT replid,tahunajaran FROM tahunajaran where departemen='$departemen' AND aktif = 1";
                    $result = QueryDb($sql);
                    $row = mysqli_fetch_array($result);
                    ?>
                    <input type="text" name="tahun" id="tahun" readonly class="bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-2xl px-4 py-3 w-full shadow-sm" value="<?=$row['tahunajaran']?>" />
                    <input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$row['replid']?>">
                </div>

                <!-- Semester -->
                <div class="flex flex-col gap-2">
                    <label for="sem" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Semester</label>
                    <? 
                    $sql = "SELECT replid,semester FROM semester where departemen='$departemen' AND aktif = 1";
                    $result = QueryDb($sql);
                    $row = @mysqli_fetch_array($result);
                    ?>
                    <input type="text" name="sem" id="sem" readonly class="bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-2xl px-4 py-3 w-full shadow-sm" value="<?=$row['semester']?>" />
                    <input type="hidden" name="semester" id="semester" value="<?=$row['replid']?>">
                </div>

                <!-- Tingkat -->
                <div class="flex flex-col gap-2">
                    <label for="tingkat" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Tingkat</label>
                    <div class="relative">
                        <select name="tingkat" id="tingkat" onChange="change_tingkat()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-2xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm transition-colors cursor-pointer">
                            <? 
                            $sql = "SELECT replid,tingkat FROM tingkat WHERE aktif=1 AND departemen='$departemen' ORDER BY urutan";	
                            $result = QueryDb($sql);
                            while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tingkat) ?>><?=$row['tingkat']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Kelas -->
                <div class="flex flex-col gap-2">
                    <label for="kelas" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Kelas</label>
                    <div class="relative">
                        <select name="kelas" id="kelas" onChange="change_kelas()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-2xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm transition-colors cursor-pointer">
                            <? 
                            $sql = "SELECT replid,kelas FROM kelas WHERE aktif=1 AND idtahunajaran = '$tahunajaran' AND idtingkat = '$tingkat' ORDER BY kelas";	
                            $result = QueryDb($sql);
                            while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $kelas) ?>><?=$row['kelas']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Action Button Container -->
                <div class="flex items-end">
                    <?
                    $sql = "SELECT nis FROM siswa WHERE idkelas = '$kelas' ORDER BY nama";
                    $result = QueryDb($sql);
                    if (mysqli_num_rows($result) > 0) { ?>
                        <button id="cetak" onClick="cetaklah()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-3.5 px-6 rounded-2xl shadow-lg shadow-emerald-900/20 transition-all duration-200 active:scale-95">
                            <i class="fa-solid fa-print"></i> CETAK FORM
                        </button>
                    <? } else { ?>
                        <div class="w-full p-3 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-[10px] font-bold text-center uppercase tracking-wider">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i> Belum ada data siswa
                        </div>
                    <? } ?>
                </div>
            </div>
        </div>

        <!-- Legend / Info Area -->
        <div class="flex-1 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center justify-center p-10 text-center">
            <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-6 text-emerald-900">
                <i class="fa-solid fa-info-circle text-4xl"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-900 mb-2">Instruksi Pencetakan</h2>
            <p class="text-slate-500 text-sm max-w-md leading-relaxed">
                Pilih Departemen, Tingkat, dan Kelas untuk mencetak form presensi harian. Pastikan data siswa sudah terdaftar pada kelas yang dipilih sebelum melakukan pencetakan.
            </p>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
