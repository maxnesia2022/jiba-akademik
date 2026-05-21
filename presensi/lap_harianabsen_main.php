<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$th1 = date("Y");
if (isset($_REQUEST['th1']))
	$th1 = $_REQUEST['th1'];
$tgl1 = date("j");
if (isset($_REQUEST['tgl1']))
	$tgl1 = $_REQUEST['tgl1'];
$bln1 = date("n");
if (isset($_REQUEST['bln1']))
	$bln1 = $_REQUEST['bln1'];
$th2 = date("Y");
if (isset($_REQUEST['th2']))
	$th2 = $_REQUEST['th2'];
$bln2 = date("n");
if (isset($_REQUEST['bln2']))
	$bln2 = $_REQUEST['bln2'];

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
$tingkat = -1;
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
$semester = "";
if (isset($_REQUEST['semester']))
	$semester = $_REQUEST['semester'];
$kelas = -1;
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];
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
    $row = @mysqli_fetch_array($result);	
    $tahunajaran = $row['replid'];
}

if ($semester == "") {
    $sql = "SELECT replid FROM semester where departemen='$departemen' AND aktif = 1 ORDER BY replid DESC LIMIT 1";
    $result = QueryDb($sql);
    $row = @mysqli_fetch_array($result);
    $semester = $row['replid'];
}

$n1 = JmlHari($bln1,$th1);
$n2 = JmlHari($bln2,$th2);

if (!isset($_REQUEST['tgl2']))
    $tgl2 = $n1;
else
    $tgl2 = $_REQUEST['tgl2'];

$tahun1 = date('Y') - 5;
$tahun2 = date('Y') + 1;
if ($tahunajaran != "") {
    $sql = "SELECT YEAR(tglmulai) AS tahun1, YEAR(tglakhir) AS tahun2 FROM tahunajaran WHERE replid='$tahunajaran'";
    $result = QueryDb($sql);
    if ($row = mysqli_fetch_row($result)) {
        $tahun1 = $row[0];
        $tahun2 = $row[1];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Siswa Tidak Hadir</title>
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
    <script language="javascript" src="../script/validasi.js"></script>
    <script language="javascript" src="../script/ajax.js"></script>
    <script language="javascript">
    function tampil() {
        var th2 = parseInt(document.getElementById('th2').value);
        var bln2 = parseInt(document.getElementById('bln2').value);
        var tgl2 = parseInt(document.getElementById('tgl2').value);
        var th1 = parseInt(document.getElementById('th1').value);
        var bln1 = parseInt(document.getElementById('bln1').value);
        var tgl1 = parseInt(document.getElementById('tgl1').value);
        var tahunajaran = document.getElementById('tahunajaran').value;
        var semester = document.getElementById('semester').value;
        var tingkat = document.getElementById('tingkat').value;
        var kelas = document.getElementById('kelas').value;
        var departemen = document.getElementById('departemen').value;
        
        var validasi = validateTgl(tgl1,bln1,th1,tgl2,bln2,th2);
        if (validasi)		
            document.getElementById('footer_frame').src = "lap_harianabsen_footer.php?tahunajaran="+tahunajaran+"&tgl1="+tgl1+"&bln1="+bln1+"&th1="+th1+"&tgl2="+tgl2+"&bln2="+bln2+"&th2="+th2+"&semester="+semester+"&kelas="+kelas+"&tingkat="+tingkat+"&departemen="+departemen;
    }

    function change() {
        var th2 = document.getElementById('th2').value;
        var bln2 = document.getElementById('bln2').value;
        var tgl2 = document.getElementById('tgl2').value;
        var th1 = document.getElementById('th1').value;
        var bln1 = document.getElementById('bln1').value;
        var tgl1 = document.getElementById('tgl1').value;	
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var semester = document.getElementById("semester").value;
        var tingkat = document.getElementById("tingkat").value;
        var kelas = document.getElementById("kelas").value;
        
        document.location.href = "lap_harianabsen_main.php?tgl1="+tgl1+"&bln1="+bln1+"&th1="+th1+"&tgl2="+tgl2+"&bln2="+bln2+"&th2="+th2+"&departemen="+departemen+"&semester="+semester+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&kelas="+kelas;	
    }

    function change_tgl1() {
        var th = parseInt(document.getElementById('th1').value);
        var bln = parseInt(document.getElementById('bln1').value);
        var tgl = parseInt(document.getElementById('tgl1').value);
        var namatgl = "tgl1";
        var namabln = "bln1";	
        sendRequestText("../library/gettanggal.php", show1, "tahun="+th+"&bulan="+bln+"&tgl="+tgl+"&namatgl="+namatgl+"&namabln="+namabln);	
    }

    function change_tgl2() {
        var th = parseInt(document.getElementById('th2').value);
        var bln = parseInt(document.getElementById('bln2').value);
        var tgl = parseInt(document.getElementById('tgl2').value);
        var namatgl = "tgl2";
        var namabln = "bln2";	
        sendRequestText("../library/gettanggal.php", show2, "tahun="+th+"&bulan="+bln+"&tgl="+tgl+"&namatgl="+namatgl+"&namabln="+namabln);	
    }

    function show1(x) {
        document.getElementById("InfoTgl1").innerHTML = x;
    }

    function show2(x) {
        document.getElementById("InfoTgl2").innerHTML = x;
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            if (elemName == 'tabel') {
                tampil();
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
                    <i class="fa-solid fa-user-slash text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Presensi</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">LAPORAN SISWA TIDAK HADIR</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../presensi.php?page=ph" target="content" class="text-emerald-700 hover:underline font-semibold">Presensi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Siswa Tidak Hadir</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Departemen -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
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
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Tahun Ajaran</label>
                    <div class="relative">
                        <select name="tahunajaran" id="tahunajaran" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                            <?
                            $sql = "SELECT replid,tahunajaran,aktif FROM tahunajaran WHERE departemen='$departemen' ORDER BY aktif DESC, tahunajaran DESC";
                            $result = QueryDb($sql);
                            while ($row = @mysqli_fetch_array($result)) {
                                $ada = $row['aktif'] ? "(Aktif)" : ""; ?>
                                <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tahunajaran)?> ><?=$row['tahunajaran'].' '.$ada?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Semester -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Semester</label>
                    <div class="relative">
                        <select name="semester" id="semester" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                            <?
                            $sql = "SELECT replid,semester,aktif FROM semester where departemen='$departemen' ORDER BY aktif DESC, replid DESC";
                            $result = QueryDb($sql);
                            while ($row = @mysqli_fetch_array($result)) {
                                $ada = $row['aktif'] ? "(Aktif)" : ""; ?>
                                <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $semester)?> ><?=$row['semester'].' '.$ada?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Tingkat -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Tingkat</label>
                    <div class="relative">
                        <select name="tingkat" id="tingkat" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                            <option value="-1" <?=IntIsSelected("-1", $tingkat)?>>(Semua Tingkat)</option>
                            <?
                            $sql = "SELECT replid,tingkat FROM tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan";	
                            $result = QueryDb($sql);
                            while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tingkat) ?>><?=$row['tingkat']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Kelas -->
                <div class="flex flex-col gap-1.5">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Kelas</label>
                    <div class="relative">
                        <? $disable = ($tingkat == -1) ? "disabled" : ""; ?>
                        <select name="kelas" id="kelas" onChange="change()" <?=$disable?> class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm cursor-pointer disabled:bg-slate-100 disabled:text-slate-400">
                            <option value="-1" <?=IntIsSelected("-1", $kelas)?>>(Semua Kelas)</option>
                            <?
                            if ($tingkat != -1) {
                                $sql = "SELECT replid,kelas FROM kelas WHERE aktif=1 AND idtahunajaran = '$tahunajaran' AND idtingkat = '$tingkat' ORDER BY kelas";	
                                $result = QueryDb($sql);
                                while($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $kelas) ?>><?=$row['kelas']?></option>
                                <? }
                            } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date Range Controls -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mt-6">
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex items-center gap-3">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Mulai</label>
                        <div class="flex gap-1.5">
                            <div id="InfoTgl1" class="relative">
                                <select name="tgl1" id="tgl1" onChange="change_tgl1()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-16 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                    <? for($i=1;$i<=$n1;$i++){ ?>
                                        <option value="<?=$i?>" <?=IntIsSelected($tgl1, $i)?>><?=$i?></option>
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select name="bln1" id="bln1" onChange="change_tgl1()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-24 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                    <? for ($i=1;$i<=12;$i++) { ?>
                                        <option value="<?=$i?>" <?=IntIsSelected($bln1, $i)?>><?=$bulan[$i]?></option>	
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select name="th1" id="th1" onChange="change_tgl1()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-24 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                    <? for ($i = $tahun1; $i <= $tahun2; $i++) { ?>
                                        <option value="<?=$i?>" <?=IntIsSelected($th1, $i)?>><?=$i?></option>	   
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Sampai</label>
                        <div class="flex gap-1.5">
                            <div id="InfoTgl2" class="relative">
                                <select name="tgl2" id="tgl2" onChange="change_tgl2()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-16 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                    <? for($i=1;$i<=$n2;$i++){ ?>
                                        <option value="<?=$i?>" <?=IntIsSelected($tgl2, $i)?>><?=$i?></option>
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select name="bln2" id="bln2" onChange="change_tgl2()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-24 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                    <? for ($i=1;$i<=12;$i++) { ?>
                                        <option value="<?=$i?>" <?=IntIsSelected($bln2, $i)?>><?=$bulan[$i]?></option>	
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select name="th2" id="th2" onChange="change_tgl2()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-24 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                    <? for ($i = $tahun1; $i <= $tahun2; $i++) { ?>
                                        <option value="<?=$i?>" <?=IntIsSelected($th2, $i)?>><?=$i?></option>	   
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2.5">
                    <button id="tabel" onClick="tampil()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-magnifying-glass"></i> Tampilkan
                    </button>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative">
            <iframe name="footer" id="footer_frame" src="blank_presensi_siswa_tidak_hadir.php?tipe=harian" class="w-full h-full border-none"></iframe>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
