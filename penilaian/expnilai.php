<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

require_once('expnilai.header.func.php');

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
$tingkat = "";
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];	
$kelas = "";
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];
$semester = "";
if (isset($_REQUEST['semester']))
	$semester = $_REQUEST['semester'];
$tahunajaran = "";
if (isset($_REQUEST['tahunajaran']))
    $tahunajaran = $_REQUEST['tahunajaran'];

OpenDb();

// Get default values if not set
if ($departemen == "") {
    $dep = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep[0];
}

if ($tahunajaran == "") {
    $sql = "SELECT replid FROM tahunajaran WHERE departemen='$departemen' AND aktif=1 ORDER BY replid DESC LIMIT 1";
    $result = QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $tahunajaran = $row['replid'];
    }
}

if ($semester == "") {
    $sql = "SELECT replid FROM semester where departemen='$departemen' AND aktif = 1 ORDER BY replid DESC LIMIT 1";
    $result = QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $semester = $row['replid'];
    }
}

if ($tingkat == "") {
    $sql="SELECT replid FROM tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan LIMIT 1";
    $result=QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $tingkat = $row['replid'];
    }
}

if ($kelas == "" && $tahunajaran != "" && $tingkat != "") {
    $sql="SELECT replid FROM kelas WHERE idtahunajaran='$tahunajaran' AND idtingkat='$tingkat' AND aktif = 1 ORDER BY kelas LIMIT 1";
    $result=QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $kelas = $row['replid'];
    }
}

ReadParams();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ekspor Nilai Pelajaran</title>
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
    <? require_once("expnilai.header.js.php"); ?>
    
    function change_sel(){
        var departemen = document.getElementById('departemen').value;
        document.location.href="expnilai.php?departemen="+departemen;
    }

    function change_sel2() {
        var departemen = document.getElementById('departemen').value;
        var tingkat = document.getElementById('tingkat').value;
        document.location.href="expnilai.php?tingkat="+tingkat+"&departemen="+departemen;
    }

    function change() {
        var departemen = document.getElementById('departemen').value;
        var tingkat = document.getElementById('tingkat').value;
        var kelas = document.getElementById('kelas').value;
        document.location.href="expnilai.php?tingkat="+tingkat+"&departemen="+departemen+"&kelas="+kelas;
    }

    function show(){
        var departemen = document.getElementById('departemen').value;
        var tingkat = document.getElementById('tingkat').value;
        var tahun = document.getElementById('tahunajaran').value;
        var semester = document.getElementById('semester').value;
        var kelas = document.getElementById('kelas').value;
        
        if(departemen.length == 0) {
            alert("Departemen tidak boleh kosong!");
            return false;
        } else if(tingkat.length == 0) {
            alert("Tingkat tidak boleh kosong!");
            return false;
        } else if(tahun.length == 0) {
            alert("Tahun Ajaran tidak boleh kosong!");
            return false;
        } else if(semester.length == 0) {
            alert("Semester tidak boleh kosong!");
            return false;
        } else if(kelas.length == 0) {
            alert("Kelas tidak boleh kosong!");
            return false;
        } else {	
            document.getElementById('footer_frame').src="expnilai.content.php?departemen="+departemen+"&tingkat="+tingkat+"&semester="+semester+"&kelas="+kelas;
        }
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            if (elemName == 'tabel') {
                show();
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
                    <i class="fa-solid fa-file-export text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Ekspor & Impor</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">EKSPOR FORM NILAI</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../exim.php" target="content" class="text-emerald-700 hover:underline font-semibold">Ekspor & Impor</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Ekspor Form Nilai</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Departemen -->
                <div class="flex items-center gap-3">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="change_sel()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                            <? $dep = getDepartemen(SI_USER_ACCESS());    
                            foreach($dep as $value) { ?>
                                <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Tahun & Semester -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">TA</label>
                        <? 
                        $sql_ta = "SELECT tahunajaran FROM tahunajaran WHERE replid = '$tahunajaran'";
                        $result_ta = QueryDb($sql_ta);
                        $row_ta = @mysqli_fetch_array($result_ta);
                        ?>
                        <input type="text" value="<?=$row_ta['tahunajaran']?>" readonly class="bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-xl px-4 py-2.5 w-32 shadow-sm" />
                        <input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran?>">
                    </div>
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Semester</label>
                        <? 
                        $sql_sem = "SELECT semester FROM semester WHERE replid = '$semester'";
                        $result_sem = QueryDb($sql_sem);
                        $row_sem = @mysqli_fetch_array($result_sem);
                        ?>
                        <input type="text" value="<?=$row_sem['semester']?>" readonly class="bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-xl px-4 py-2.5 w-32 shadow-sm" />
                        <input type="hidden" name="semester" id="semester" value="<?=$semester?>">
                    </div>
                </div>

                <!-- Kelas (Tingkat + Kelas) -->
                <div class="flex items-center gap-3">
                    <label for="tingkat" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Kelas</label>
                    <div class="flex gap-2">
                        <div class="relative">
                            <select name="tingkat" id="tingkat" onChange="change_sel2()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-20 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                                <? 
                                $sql_t="SELECT * FROM tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan";
                                $result_t=QueryDb($sql_t);
                                while ($row_t=@mysqli_fetch_array($result_t)){ ?> 
                                    <option value="<?=$row_t['replid']?>" <?=IntIsSelected($row_t['replid'], $tingkat)?>><?=$row_t['tingkat']?></option>
                                <? } ?> 
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="kelas" id="kelas" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-32 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                                <?
                                $sql_k="SELECT * FROM kelas WHERE idtahunajaran='$tahunajaran' AND idtingkat='$tingkat' AND aktif = 1 ORDER BY kelas";
                                $result_k=QueryDb($sql_k);
                                while ($row_k=@mysqli_fetch_array($result_k)){ ?> 
                                    <option value="<?=$row_k['replid']?>" <?=IntIsSelected($row_k['replid'], $kelas)?>><?=$row_k['kelas']?></option>
                                <? } ?> 
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5">
                <button id="tabel" onClick="show()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass"></i> Tampilkan
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative">
            <iframe name="content" id="footer_frame" src="expnilai.blank.php" class="w-full h-full border-none"></iframe>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
