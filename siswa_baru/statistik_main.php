<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$departemen = -1;
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$proses = -1;
if (isset($_REQUEST['proses']))
	$proses = $_REQUEST['proses'];

$dasar = 1;
if (isset($_REQUEST['dasar']))
	$dasar = $_REQUEST['dasar'];

OpenDb();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Penerimaan Siswa Baru</title>
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
        /* Custom scrollbar for better aesthetics */
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
    function change() {
        var departemen = document.getElementById("departemen").value;	
        var proses = document.getElementById("proses").value;
        var dasar = document.getElementById("dasar").value;
        
        document.location.href = "statistik_main.php?departemen="+departemen+"&proses="+proses+"&dasar="+dasar;
    }

    function tampil_statistik() {
        var departemen = document.getElementById("departemen").value;
        var idproses = document.getElementById("proses").value;
        var iddasar = document.getElementById("dasar").value;	
        
        document.getElementById('footer_frame').src = "statistik_footer.php?departemen="+departemen+"&idproses="+idproses+"&iddasar="+iddasar;
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
                <!-- Background icon emerald-900 -->
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-chart-pie text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Penerimaan Siswa Baru</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">STATISTIK PENERIMAAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../siswa_baru.php" target="content" class="text-emerald-700 hover:underline font-semibold">PSB</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Statistik</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Departemen -->
                <div class="flex items-center gap-3">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer" onKeyPress="return focusNext('proses', event)">
                            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                <option value="-1" >(Semua Departemen)</option>
                                <?
                                $sql = "SELECT * FROM departemen where aktif=1 ORDER BY urutan";
                                $result_d = QueryDb($sql);
                                while($row_d = mysqli_fetch_array($result_d)) { ?>
                                    <option value="<?=urlencode($row_d['departemen'])?>" <?=StringIsSelected($row_d['departemen'], $departemen) ?>><?=$row_d['departemen']?></option>
                                <? } ?>
                            <? } else { 
                                $dep_list = getDepartemen(SI_USER_ACCESS());    
                                foreach($dep_list as $value) {
                                    if ($departemen == "") $departemen = $value; ?>
                                    <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                                <? } ?>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Proses Penerimaan -->
                <div class="flex items-center gap-3">
                    <label for="proses" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Proses</label>
                    <div class="relative">
                        <?
                        if ($departemen == -1) {
                            $disable = 'disabled';
                            $dep_query = "";
                        } else {
                            $disable = "";
                            $dep_query = "AND departemen = '$departemen'";
                        }
                        ?>
                        <select name="proses" id="proses" onChange="change()" <?=$disable?> class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-56 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer disabled:bg-slate-100 disabled:text-slate-400" onKeyPress="return focusNext('dasar', event)">
                            <option value="-1" >(Semua Penerimaan Aktif)</option>
                            <?
                            $sql_p = "SELECT replid,proses FROM prosespenerimaansiswa WHERE aktif = 1 $dep_query ";
                            $result_p = QueryDb($sql_p);
                            while ($row_p = mysqli_fetch_array($result_p)) { ?>
                                <option value="<?=urlencode($row_p['replid'])?>" <?=IntIsSelected($row_p['replid'], $proses) ?>><?=$row_p['proses']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Berdasarkan -->
                <div class="flex items-center gap-3">
                    <label for="dasar" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Berdasarkan</label>
                    <div class="relative">
                        <select name="dasar" id="dasar" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-56 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer" onKeyPress="return focusNext('tabel', event)">
                            <? for ($i=1;$i<=17;$i++) { ?>
                                <option value ="<?=$i?>" <?=IntIsSelected($i, $dasar) ?>><?=$kriteria[$i] ?></option>
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
                    <i class="fa-solid fa-chart-column"></i> Tampilkan Statistik
                </button>
            </div>
        </div>

        <!-- Content Area (Iframe as Footer) -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative">
            <iframe name="footer" id="footer_frame" src="blank_statistik.php" class="w-full h-full border-none"></iframe>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
