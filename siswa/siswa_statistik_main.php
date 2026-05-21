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

$angkatan = -1;
if (isset($_REQUEST['angkatan']))
	$angkatan = $_REQUEST['angkatan'];

$iddasar = 1;
if (isset($_REQUEST['iddasar']))
	$iddasar = $_REQUEST['iddasar'];

OpenDb();
// Get default values if not set
if ($departemen == "") {
    if (SI_USER_LEVEL() != $SI_USER_STAFF) {
        $departemen = "-1";
    } else {
        $dep = getDepartemen(SI_USER_ACCESS());
        $departemen = $dep[0];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Kesiswaan</title>
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

    <script language="javascript">
    function change_departemen() {
        var departemen = document.getElementById("departemen").value;
        var angkatan = document.getElementById("angkatan").value;
        var iddasar = document.getElementById("iddasar").value;		
        document.location.href = "siswa_statistik_main.php?departemen="+departemen+"&angkatan="+angkatan+"&iddasar="+iddasar;	
    }

    function tampil_statistik() {
        var departemen = document.getElementById("departemen").value;
        var idangkatan = document.getElementById("angkatan").value;
        var iddasar = document.getElementById("iddasar").value;	
        document.getElementById('footer_frame').src = "siswa_statistik_footer.php?departemen="+departemen+"&idangkatan="+idangkatan+"&iddasar="+iddasar;
    }

    function blank() {
        var departemen = document.getElementById("departemen").value;
        var angkatan = document.getElementById("angkatan").value;
        var iddasar = document.getElementById("iddasar").value;		
        document.location.href = "siswa_statistik_main.php?departemen="+departemen+"&angkatan="+angkatan+"&iddasar="+iddasar;	
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            if (elemName == 'tabel') {
                tampil_statistik();
            } else {
                document.getElementById(elemName).focus();
            }
            return false;
        }
        return true;
    }
    </script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-chart-line text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Kesiswaan</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">STATISTIK KESISWAAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../siswa.php" target="content" class="text-emerald-700 hover:underline font-semibold">Kesiswaan</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Statistik Kesiswaan</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Departemen -->
                <div class="flex items-center gap-3">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="change_departemen()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) {	?>
                                <option value="-1" <?=StringIsSelected("-1", $departemen) ?>>(Semua Departemen)</option>
                                <?
                                $sql = "SELECT * FROM departemen where aktif=1 ORDER BY urutan";
                                $result = QueryDb($sql);
                                while($row = mysqli_fetch_array($result)) { ?>
                                    <option value="<?=urlencode($row['departemen'])?>" <?=StringIsSelected($row['departemen'], $departemen) ?>><?=$row['departemen']?></option>
                                <? } ?>
                            <? } else {	
                                $dep = getDepartemen(SI_USER_ACCESS());    
                                foreach($dep as $value) { ?>
                                    <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                                <? } ?>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Angkatan -->
                <div class="flex items-center gap-3">
                    <label for="angkatan" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Angkatan</label>
                    <div class="relative">
                        <?
                        $disable = "";
                        $dep_filter = "";
                        if ($departemen == "-1" || $departemen == "")  {
                            $disable = 'disabled';
                            $angkatan = -1;
                        } else	{
                            $dep_filter = "AND departemen = '$departemen'";
                        }
                        ?>
                        <select name="angkatan" id="angkatan" onChange="blank()" <?=$disable?> class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer disabled:bg-slate-100 disabled:text-slate-400">
                            <option value="-1" <?=IntIsSelected("-1", $angkatan) ?>>(Semua Angkatan Aktif)</option>
                            <? 	
                            if ($departemen != "-1" && $departemen != "") {
                                $sql_angkatan = "SELECT replid,angkatan FROM angkatan where aktif = 1 $dep_filter ORDER BY replid DESC";
                                $result_angkatan = QueryDb($sql_angkatan);
                                while ($row_angkatan = mysqli_fetch_array($result_angkatan)) { ?>
                                    <option value="<?=urlencode($row_angkatan['replid'])?>" <?=IntIsSelected($row_angkatan['replid'], $angkatan) ?>><?=$row_angkatan['angkatan']?></option>
                                <? }
                            } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Berdasarkan -->
                <div class="flex items-center gap-3">
                    <label for="iddasar" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Berdasarkan</label>
                    <div class="relative">
                        <select name="iddasar" id="iddasar" onChange="blank()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                            <? for ($i=1;$i<=17;$i++) { ?>
                                <option value ="<?=$i?>" <?=IntIsSelected($i, $iddasar) ?>><?=$kriteria[$i] ?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5">
                <button id="tabel" onClick="tampil_statistik()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass"></i> Tampilkan
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative">
            <iframe name="footer" id="footer_frame" src="blank_statistik.php" class="w-full h-full border-none"></iframe>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
