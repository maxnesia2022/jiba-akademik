<?php
// =========================================================================
// INIT & INCLUDE FILES
// =========================================================================
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

OpenDb();

// =========================================================================
// PENANGKAPAN PARAMETER
// =========================================================================
$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$proses     = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : 0;
$action     = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// =========================================================================
// PROSES AKSI (SIMPAN)
// =========================================================================
if (isset($_REQUEST['Simpan'])) {
    $sql = "SELECT COUNT(replid) FROM settingpsb WHERE idproses = '$proses'";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $ndata = $row[0];
    
    $set = "";
    for($i = 1; $i <= 2; $i++) {
        if ($set != "") $set .= ", ";
        $fkd = "kdsum$i"; $fnm = "nmsum$i";
        $kd = str_replace("'", "`", $_REQUEST[$fkd]);
        $nm = str_replace("'", "`", $_REQUEST[$fnm]);
        $set .= "$fkd = '$kd', $fnm = '$nm'";
    }
    for($i = 1; $i <= 10; $i++) {
        if ($set != "") $set .= ", ";
        $fkd = "kdujian$i"; $fnm = "nmujian$i";
        $kd = str_replace("'", "`", $_REQUEST[$fkd]);
        $nm = str_replace("'", "`", $_REQUEST[$fnm]);
        $set .= "$fkd = '$kd', $fnm = '$nm'";
    }
    
    if ($ndata == 0)
        $sql = "INSERT INTO settingpsb SET idproses = '$proses', $set";
    else
        $sql = "UPDATE settingpsb SET $set WHERE idproses = '$proses'";
    
    QueryDb($sql);
    $action = 'view'; // Re-show the view after saving
}

// Get default values if not set
if ($departemen == "") {
    $dep_list = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep_list[0];
}

if ($proses == 0) {
    $sql = "SELECT replid FROM prosespenerimaansiswa WHERE aktif=1 AND departemen='$departemen' LIMIT 1";
    $res = QueryDb($sql);
    if ($row = mysqli_fetch_array($res)) $proses = $row['replid'];
}

// Get labels for display
$nama_proses = "";
if ($proses != 0) {
    $row = @mysqli_fetch_row(QueryDb("SELECT proses FROM prosespenerimaansiswa WHERE replid='$proses'"));
    $nama_proses = $row[0];
}

// Fetch current settings
$data = array();
if ($proses != 0) {
    $sql = "SELECT * FROM settingpsb WHERE idproses = '$proses'";
    $res = QueryDb($sql);
    if ($row = mysqli_fetch_assoc($res)) {
        $data = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfigurasi Pendataan PSB</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script type="text/javascript">
        function change_dep() {
            var departemen = document.getElementById("departemen").value;
            window.location.href = "settingpsb_main.php?departemen=" + encodeURIComponent(departemen);
        }

        function change_proses() {
            var departemen = document.getElementById("departemen").value;
            var proses = document.getElementById("proses_select").value;
            window.location.href = "settingpsb_main.php?departemen=" + encodeURIComponent(departemen) + "&proses=" + proses;
        }

        function show_config() {
            var departemen = document.getElementById("departemen").value;
            var proses = document.getElementById("proses_select").value;
            if (proses == 0) {
                alert('Proses Penerimaan tidak boleh kosong!');
                return false;
            }
            window.location.href = "settingpsb_main.php?action=view&departemen=" + encodeURIComponent(departemen) + "&proses=" + proses;
        }

        function validate() {
            return confirm("Simpan konfigurasi pendataan PSB ini?");
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-emerald-950 text-slate-800 min-h-screen p-4 md:p-6 overflow-x-hidden">

    <div class="w-full h-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-emerald-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-emerald-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-gears text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Penerimaan Siswa Baru</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">KONFIGURASI PENDATAAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">PSB</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Konfigurasi Pendataan</span>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Departemen</label>
                    <select id="departemen" onChange="change_dep()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php 
                        $dep_list = getDepartemen(SI_USER_ACCESS());    
                        foreach($dep_list as $value) {
                            $selected = ($value == $departemen) ? "selected" : "";
                            echo "<option value=\"$value\" $selected>$value</option>";
                        } ?>
                    </select>
                </div>

                <div class="lg:col-span-2">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Proses Penerimaan</label>
                    <select id="proses_select" onChange="change_proses()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php
                        $sql_p = "SELECT replid, proses, aktif FROM prosespenerimaansiswa WHERE departemen='$departemen'";
                        $res_p = QueryDb($sql_p);
                        while ($row_p = mysqli_fetch_array($res_p)) {
                            $tag = ($row_p['aktif'] == 1) ? " (Aktif)" : "";
                            $selected = ($row_p['replid'] == $proses) ? "selected" : "";
                            echo "<option value=\"{$row_p['replid']}\" $selected>{$row_p['proses']}$tag</option>";
                        } ?>
                    </select>
                </div>

                <div>
                    <button onclick="show_config()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-eye"></i> TAMPILKAN KONFIGURASI
                    </button>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
            <?php if ($action == 'view' && !empty($proses)) { ?>
                
                <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Setting Field Pendataan</h3>
                        <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest"><?=$departemen?> &bull; <?=$nama_proses?></p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-6 md:p-10">
                    <form name="main" method="post" onsubmit="return validate()" class="max-w-4xl mx-auto">
                        <input type="hidden" name="departemen" value="<?=$departemen?>" />
                        <input type="hidden" name="proses" value="<?=$proses?>" />
                        
                        <div class="overflow-hidden rounded-2xl border border-slate-100 shadow-sm">
                            <table class="w-full text-left border-collapse text-sm">
                                <thead class="bg-slate-50">
                                    <tr class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        <th class="px-6 py-4">Jenis Data</th>
                                        <th class="px-6 py-4 w-32">Kode Kolom</th>
                                        <th class="px-6 py-4">Label Nama Kolom</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php 
                                    // Sumbangan Rows
                                    for($i=1;$i<=2;$i++) { ?>
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="px-6 py-4 font-bold text-slate-700">Sumbangan #<?=$i?></td>
                                            <td class="px-6 py-4">
                                                <input type="text" name="kdsum<?=$i?>" value="<?= @$data['kdsum'.$i] ?>" maxlength="5" class="w-full bg-slate-50 border border-slate-200 text-slate-800 font-mono font-bold rounded-lg px-2 py-1.5 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="text" name="nmsum<?=$i?>" value="<?= @$data['nmsum'.$i] ?>" maxlength="50" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg px-3 py-1.5 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                            </td>
                                        </tr>
                                    <?php } 
                                    // Ujian Rows
                                    for($i=1;$i<=10;$i++) { ?>
                                        <tr class="hover:bg-slate-50/50">
                                            <td class="px-6 py-4 font-bold text-slate-700">Hasil Ujian #<?=$i?></td>
                                            <td class="px-6 py-4">
                                                <input type="text" name="kdujian<?=$i?>" value="<?= @$data['kdujian'.$i] ?>" maxlength="5" class="w-full bg-slate-50 border border-slate-200 text-slate-800 font-mono font-bold rounded-lg px-2 py-1.5 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                            </td>
                                            <td class="px-6 py-4">
                                                <input type="text" name="nmujian<?=$i?>" value="<?= @$data['nmujian'.$i] ?>" maxlength="50" class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-lg px-3 py-1.5 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-center">
                            <button type="submit" name="Simpan" class="bg-emerald-900 hover:bg-emerald-800 text-white font-extrabold text-sm py-3 px-12 rounded-2xl shadow-xl shadow-emerald-900/20 transition-all active:scale-95 uppercase tracking-widest">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> SIMPAN KONFIGURASI
                            </button>
                        </div>
                    </form>
                </div>

            <?php } else { ?>
                <!-- BLANK STATE -->
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                    <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-gears text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Konfigurasi Field Pendataan PSB</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Silakan tentukan <strong>Departemen</strong> dan <strong>Proses Penerimaan</strong> pada filter di atas untuk mengatur label kolom sumbangan dan hasil ujian.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>
