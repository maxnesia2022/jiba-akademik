<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : "";
$tahunajaran = isset($_REQUEST['tahunajaran']) ? (int)$_REQUEST['tahunajaran'] : 0;
$tingkat = isset($_REQUEST['tingkat']) ? (int)$_REQUEST['tingkat'] : 0;
$kelas = isset($_REQUEST['kelas']) ? (int)$_REQUEST['kelas'] : 0;
$semester = isset($_REQUEST['semester']) ? (int)$_REQUEST['semester'] : 0;

OpenDb();

// Get default values if not set
if ($departemen == "") {
    $dep = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep[0];
}

if ($tahunajaran == 0) {
    $sql = "SELECT replid FROM tahunajaran WHERE departemen = '$departemen' ORDER BY replid DESC LIMIT 1";
    $result = QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $tahunajaran = $row['replid'];
    }
}

if ($semester == 0) {
    $sql = "SELECT replid FROM semester WHERE departemen = '$departemen' ORDER BY replid DESC LIMIT 1";
    $result = QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $semester = $row['replid'];
    }
}

if ($tingkat == 0) {
    $sql = "SELECT replid FROM tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan LIMIT 1";
    $result = QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $tingkat = $row['replid'];
    }
}

if ($kelas == 0 && $tahunajaran != 0 && $tingkat != 0) {
    $sql ="SELECT replid FROM kelas WHERE idtahunajaran='$tahunajaran' AND idtingkat='$tingkat' AND aktif = 1 ORDER BY kelas LIMIT 1";
    $result=QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $kelas = $row['replid'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legger Rapor Per Pelajaran</title>
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
    <script language="javascript" src="legger.rapor.header.js"></script>
    <script language="javascript">
    function change_dept() {
        var departemen = document.getElementById("departemen").value;
        document.location.href = "legger.rapor.php?departemen="+departemen;
    }

    function change_ta() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        document.location.href = "legger.rapor.php?departemen="+departemen+"&tahunajaran="+tahunajaran;
    }

    function change_tingkat() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var tingkat = document.getElementById("tingkat").value;
        document.location.href = "legger.rapor.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat;
    }

    function change_kelas() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var tingkat = document.getElementById("tingkat").value;
        var kelas = document.getElementById("kelas").value;
        document.location.href = "legger.rapor.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&kelas="+kelas;
    }

    function change_semester() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var tingkat = document.getElementById("tingkat").value;
        var kelas = document.getElementById("kelas").value;
        var semester = document.getElementById("semester").value;
        document.location.href = "legger.rapor.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&kelas="+kelas+"&semester="+semester;
    }

    function show() {
        var kelas = document.getElementById("kelas").value;
        var semester = document.getElementById("semester").value;
        var pelajaran = document.getElementById("pelajaran").value;
        
        if (kelas == 0) {
            alert("Kelas tidak boleh kosong!");
            return false;
        }
        if (semester == 0) {
            alert("Semester tidak boleh kosong!");
            return false;
        }
        
        if (pelajaran == 0) {
            document.getElementById('footer_frame').src = "legger.rapor.content.all.php?idkelas="+kelas+"&idsemester="+semester;
        } else {
            document.getElementById('footer_frame').src = "legger.rapor.content.php?idkelas="+kelas+"&idsemester="+semester+"&idpelajaran="+pelajaran;
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
                    <i class="fa-solid fa-table-columns text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Laporan Penilaian</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">LEGGER RAPOR PER PELAJARAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../penilaian.php" target="content" class="text-emerald-700 hover:underline font-semibold">Penilaian</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Legger Rapor</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Departemen -->
                <div class="flex flex-col gap-1.5">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="change_dept()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                            <? $dep = getDepartemen(SI_USER_ACCESS());    
                            foreach($dep as $value) { ?>
                                <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Tahun Ajaran -->
                <div class="flex flex-col gap-1.5">
                    <label for="tahunajaran" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Tahun Ajaran</label>
                    <div class="relative">
                        <select name="tahunajaran" id="tahunajaran" onChange="change_ta()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                            <?
                            $sql = "SELECT replid, tahunajaran, aktif FROM tahunajaran WHERE departemen = '$departemen' ORDER BY replid DESC";
                            $result = QueryDb($sql);
                            while($row = @mysqli_fetch_array($result)) {
                                $act = ($row['aktif'] == 1) ? "(Aktif)" : ""; ?>
                                <option value='<?=$row['replid']?>' <?=IntIsSelected($row['replid'], $tahunajaran)?>><?=$row['tahunajaran'] . " $act"?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Semester -->
                <div class="flex flex-col gap-1.5">
                    <label for="semester" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Semester</label>
                    <div class="relative">
                        <select name="semester" id="semester" onChange="change_semester()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                            <?
                            $sql = "SELECT replid, semester, aktif FROM semester WHERE departemen = '$departemen' ORDER BY replid DESC";
                            $result = QueryDb($sql);
                            while($row = @mysqli_fetch_array($result)) {
                                $act = ($row["aktif"] == 1) ? "(Aktif)" : ""; ?>
                                <option value="<?=$row['replid']?>" <?=IntIsSelected($row['replid'], $semester)?>><?=$row['semester'] . " $act"?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Kelas -->
                <div class="flex flex-col gap-1.5">
                    <label for="tingkat" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Kelas</label>
                    <div class="flex gap-2">
                        <div class="relative">
                            <select name="tingkat" id="tingkat" onChange="change_tingkat()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-20 pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                                <?
                                $sql = "SELECT * FROM tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan";
                                $result = QueryDb($sql);
                                while ($row = @mysqli_fetch_array($result)) { ?> 
                                    <option value="<?=$row['replid']?>" <?=IntIsSelected($row['replid'], $tingkat)?>><?=$row['tingkat']?></option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="kelas" id="kelas" onChange="change_kelas()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-32 pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                                <?
                                $sql="SELECT * FROM kelas WHERE idtahunajaran='$tahunajaran' AND idtingkat='$tingkat' AND aktif = 1 ORDER BY kelas";
                                $result=QueryDb($sql);
                                while ($row = @mysqli_fetch_array($result)) { ?> 
                                    <option value="<?=$row['replid']?>" <?=IntIsSelected($row['replid'], $kelas)?>><?=$row['kelas']?></option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pelajaran -->
                <div class="flex flex-col gap-1.5">
                    <label for="pelajaran" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Pelajaran</label>
                    <div class="relative">
                        <select name="pelajaran" id="pelajaran" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                            <option value="0">(Semua Pelajaran)</option>
                            <?
                            $sql = "SELECT DISTINCT u.idpelajaran, p.nama FROM ujian u, pelajaran p WHERE u.idpelajaran = p.replid AND u.idkelas = '$kelas' AND u.idsemester = '$semester'";
                            $result = QueryDb($sql);
                            while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?=$row['idpelajaran']?>"><?=$row['nama']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-2.5 mt-4">
                <button id="tabel" onClick="show()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-8 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass"></i> Tampilkan Legger Rapor
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative">
            <iframe name="footer" id="footer_frame" src="legger.rapor.blank.php" class="w-full h-full border-none"></iframe>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
