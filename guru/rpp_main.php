<?php
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
$semester = isset($_REQUEST['semester']) ? $_REQUEST['semester'] : '';
$pelajaran = isset($_REQUEST['pelajaran']) ? $_REQUEST['pelajaran'] : '';
$tingkat = isset($_REQUEST['tingkat']) ? $_REQUEST['tingkat'] : '';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : ''; // 'view' to show list

// Pagination & Sorting
$varbaris = isset($_REQUEST['varbaris']) ? $_REQUEST['varbaris'] : 20;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
$hal = isset($_REQUEST['hal']) ? $_REQUEST['hal'] : 0;
$urut = isset($_REQUEST['urut']) ? $_REQUEST['urut'] : "koderpp";	
$urutan = isset($_REQUEST['urutan']) ? $_REQUEST['urutan'] : "ASC";

// =========================================================================
// PROSES AKSI (HAPUS & AKTIF)
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
if ($op == "dw8dxn8w9ms8zs22") {
    $replid = $_REQUEST['replid'];
    $newaktif = $_REQUEST['newaktif'];
	$sql = "UPDATE rpp SET aktif = $newaktif WHERE replid = '$replid' ";
	QueryDb($sql);
    echo "<script>window.location.href='rpp_main.php?action=view&departemen=$departemen&semester=$semester&tingkat=$tingkat&pelajaran=$pelajaran&page=$page&hal=$hal&varbaris=$varbaris&urut=$urut&urutan=$urutan';</script>";
    exit;
} else if ($op == "xm8r389xemx23xb2378e23") {
    $replid = $_REQUEST['replid'];
	$sql = "DELETE FROM rpp WHERE replid = '$replid'";
	QueryDb($sql);
    echo "<script>window.location.href='rpp_main.php?action=view&departemen=$departemen&semester=$semester&tingkat=$tingkat&pelajaran=$pelajaran';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rencana Program Pembelajaran</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function change_dep() {
        var dep = document.getElementById("departemen").value;
        window.location.href = "rpp_main.php?departemen=" + encodeURIComponent(dep);
    }

    function change_filter() {
        var dep = document.getElementById("departemen").value;	
        var sem = document.getElementById("semester").value;
        var tkt = document.getElementById("tingkat").value;
        var pel = document.getElementById("pelajaran").value;
        window.location.href = "rpp_main.php?departemen="+encodeURIComponent(dep)+"&semester="+sem+"&tingkat="+tkt+"&pelajaran="+pel;
    }

    function show_rpp() {
        var dep = document.getElementById("departemen").value;
        var sem = document.getElementById("semester").value;
        var tkt = document.getElementById("tingkat").value;	
        var pel = document.getElementById("pelajaran").value;
        
        if (dep == "" || sem == "" || tkt == "" || pel == "") {
            alert('Silakan lengkapi semua filter!');
            return false;
        }	
        window.location.href = "rpp_main.php?action=view&departemen="+encodeURIComponent(dep)+"&semester="+sem+"&tingkat="+tkt+"&pelajaran="+pel;
    }

    function tambah() {	
        var sem = "<?=$semester?>";
        var tkt = "<?=$tingkat?>";
        var pel = "<?=$pelajaran?>";
        window.open('rpp_add.php?tingkat='+tkt+'&semester='+sem+'&pelajaran='+pel, 'TambahRPP','660','568','resizable=1,scrollbars=1');
    }

    function edit(replid) {
        window.open('rpp_edit.php?replid='+replid, 'UbahRPP','660','568','resizable=1,scrollbars=1');
    }

    function hapus(replid) {
        if (confirm("Apakah anda yakin akan menghapus rencana program pembelajaran ini?")) {
            window.location.href = "rpp_main.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen=<?=urlencode($departemen)?>&semester=<?=$semester?>&tingkat=<?=$tingkat?>&pelajaran=<?=$pelajaran?>";
        }
    }

    function setaktif(replid, aktif) {
        var msg = (aktif == 1) ? "Non-Aktifkan RPP ini?" : "Aktifkan RPP ini?";
        var newaktif = (aktif == 1) ? 0 : 1;
        if (confirm(msg)) {
            window.location.href = "rpp_main.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&departemen=<?=urlencode($departemen)?>&semester=<?=$semester?>&tingkat=<?=$tingkat?>&pelajaran=<?=$pelajaran?>&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>&urut=<?=$urut?>&urutan=<?=$urutan?>";
        }
    }

    function change_urut(new_urut) {
        var urutan = "<?=$urutan?>";
        var new_urutan = (urutan == "ASC") ? "DESC" : "ASC";
        window.location.href = "rpp_main.php?action=view&departemen=<?=urlencode($departemen)?>&semester=<?=$semester?>&tingkat=<?=$tingkat?>&pelajaran=<?=$pelajaran?>&urut="+new_urut+"&urutan="+new_urutan+"&varbaris=<?=$varbaris?>";
    }

    function change_hal() {
        var hal = document.getElementById("hal").value;
        var varb = document.getElementById("varbaris").value;
        window.location.href = "rpp_main.php?action=view&departemen=<?=urlencode($departemen)?>&semester=<?=$semester?>&tingkat=<?=$tingkat?>&pelajaran=<?=$pelajaran?>&page="+hal+"&hal="+hal+"&varbaris="+varb+"&urut=<?=$urut?>&urutan=<?=$urutan?>";
    }

    function change_baris() {
        var varb = document.getElementById("varbaris").value;
        window.location.href = "rpp_main.php?action=view&departemen=<?=urlencode($departemen)?>&semester=<?=$semester?>&tingkat=<?=$tingkat?>&pelajaran=<?=$pelajaran?>&varbaris="+varb+"&urut=<?=$urut?>&urutan=<?=$urutan?>";
    }

    function cetak() {
        var total = document.getElementById('total') ? document.getElementById('total').value : 0;
        window.open('rpp_cetak.php?tingkat=<?=$tingkat?>&semester=<?=$semester?>&pelajaran=<?=$pelajaran?>&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakRPP','790','650','resizable=1,scrollbars=1');
    }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-emerald-950 text-slate-800 min-h-screen p-4 md:p-6 overflow-x-hidden">

    <!-- MAIN CONTAINER -->
    <div class="w-full h-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-emerald-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-emerald-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-chalkboard-user text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Guru & Pelajaran</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">RPP</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Guru & Pelajaran</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">RPP</span>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <!-- Departemen -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Departemen</label>
                    <select id="departemen" onChange="change_dep()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php 
                        $dep_list = getDepartemen(SI_USER_ACCESS());    
                        foreach($dep_list as $value) {
                            if ($departemen == "") $departemen = $value; 
                            $selected = ($value == $departemen) ? "selected" : "";
                        ?>
                            <option value="<?=$value?>" <?=$selected?>><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Tingkat -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Tingkat</label>
                    <select id="tingkat" onChange="change_filter()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php 
                        $sql_t = "SELECT replid,tingkat FROM tingkat WHERE aktif=1 AND departemen='$departemen' ORDER BY urutan";	
                        $res_t = QueryDb($sql_t);
                        while($row_t = mysqli_fetch_array($res_t)) {
                            if ($tingkat == "") $tingkat = $row_t['replid'];
                            $selected = ($row_t['replid'] == $tingkat) ? "selected" : "";
                        ?>
                            <option value="<?=$row_t['replid']?>" <?=$selected?>><?=$row_t['tingkat']?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Semester -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Semester</label>
                    <select id="semester" onChange="change_filter()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php
                        $sql_s = "SELECT replid,semester,aktif FROM semester where departemen='$departemen' ORDER BY aktif DESC";
                        $res_s = QueryDb($sql_s);
                        while ($row_s = @mysqli_fetch_array($res_s)) {
                            if ($semester == "") $semester = $row_s['replid'];
                            $selected = ($row_s['replid'] == $semester) ? "selected" : "";
                            $ada = $row_s['aktif'] ? " (Aktif)" : "";
                        ?>            
                            <option value="<?=$row_s['replid']?>" <?=$selected?>><?=$row_s['semester'].$ada?></option>                 
                        <?php } ?>
                    </select>
                </div>

                <!-- Pelajaran -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Pelajaran</label>
                    <select id="pelajaran" onChange="change_filter()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php
                        $sql_p = "SELECT replid,nama FROM pelajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY nama";
                        $res_p = QueryDb($sql_p);
                        while ($row_p = @mysqli_fetch_array($res_p)) {
                            if ($pelajaran == "") $pelajaran = $row_p['replid'];
                            $selected = ($row_p['replid'] == $pelajaran) ? "selected" : "";
                        ?>
                            <option value="<?=$row_p['replid']?>" <?=$selected?>><?=$row_p['nama']?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Tombol Tampilkan -->
                <div>
                    <button onclick="show_rpp()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-eye"></i> TAMPILKAN
                    </button>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
            <?php if ($action == 'view' && !empty($pelajaran)) { ?>
                
                <div class="p-6 md:p-8 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-emerald-600"></i> Daftar Materi RPP
                    </h3>
                    <div class="flex gap-2">
                        <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <button onclick="cetak()" class="bg-blue-500 text-white px-5 py-2.5 rounded-2xl hover:bg-blue-600 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-print"></i> CETAK
                        </button>
                        <button onclick="tambah()" class="bg-emerald-900 text-white px-5 py-2.5 rounded-2xl hover:bg-emerald-800 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-plus"></i> TAMBAH RPP
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-6 md:p-8">
                    <?php
                    $sql_tot = "SELECT replid FROM rpp WHERE idtingkat='$tingkat' AND idsemester='$semester' AND idpelajaran='$pelajaran'";
                    $res_tot = QueryDb($sql_tot);
                    $jumlah = mysqli_num_rows($res_tot);
                    $total_hal = ceil($jumlah / $varbaris);

                    $sql_rpp = "SELECT replid, koderpp, rpp, deskripsi, aktif FROM rpp 
                                WHERE idtingkat='$tingkat' AND idsemester='$semester' AND idpelajaran='$pelajaran' 
                                ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
                    $res_rpp = QueryDb($sql_rpp);

                    if (mysqli_num_rows($res_rpp) > 0) {
                    ?>
                        <input type="hidden" id="total" value="<?=$total_hal?>">
                        <div class="overflow-hidden rounded-2xl border border-slate-100">
                            <table class="min-w-full divide-y divide-slate-100 text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-12">No</th>
                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24 cursor-pointer hover:text-emerald-700" onclick="change_urut('koderpp')">Kode</th>
                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest w-48 cursor-pointer hover:text-emerald-700" onclick="change_urut('rpp')">Materi</th>
                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Deskripsi</th>
                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24 cursor-pointer hover:text-emerald-700" onclick="change_urut('aktif')">Status</th>
                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 bg-white">
                                    <?php 
                                    $cnt = ($page * $varbaris) + 1;
                                    while ($row = mysqli_fetch_array($res_rpp)) { 
                                    ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-4 py-4 text-center text-slate-400 font-bold"><?=$cnt++?></td>
                                            <td class="px-4 py-4 font-mono text-xs font-bold text-emerald-700"><?=$row['koderpp']?></td>
                                            <td class="px-4 py-4 font-bold text-slate-800"><?=$row['rpp']?></td>
                                            <td class="px-4 py-4 text-xs text-slate-500"><?=$row['deskripsi']?></td>
                                            <td class="px-4 py-4 text-center">
                                                <button onclick="setaktif(<?=$row['replid']?>, <?=$row['aktif']?>)" class="transition-opacity hover:opacity-80">
                                                    <i class="fa-solid <?= $row['aktif'] == 1 ? 'fa-circle-check text-emerald-500' : 'fa-circle-xmark text-slate-300' ?> text-lg"></i>
                                                </button>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <button onclick="edit(<?=$row['replid']?>)" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Ubah">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </button>
                                                    <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                                    <button onclick="hapus(<?=$row['replid']?>)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </button>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION -->
                        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs font-bold text-slate-500">
                            <div class="flex items-center gap-2">
                                <span>Halaman</span>
                                <select id="hal" onChange="change_hal()" class="bg-white border border-slate-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-emerald-500">
                                    <?php for ($m=0; $m<$total_hal; $m++) {?>
                                        <option value="<?=$m?>" <?=IntIsSelected($hal,$m)?>><?=$m+1?></option>
                                    <?php } ?>
                                </select>
                                <span>dari <?=$total_hal?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>Tampilkan</span>
                                <select id="varbaris" onChange="change_baris()" class="bg-white border border-slate-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-emerald-500">
                                    <?php for ($m=10; $m <= 50; $m+=10) { ?>
                                        <option value="<?=$m?>" <?=IntIsSelected($varbaris,$m)?>><?=$m?></option>
                                    <?php } ?>
                                </select>
                                <span>per halaman</span>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="flex flex-col items-center justify-center p-16 text-center space-y-4 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                            <i class="fa-solid fa-folder-open text-5xl text-slate-200"></i>
                            <p class="text-slate-500 font-medium">Belum ada data RPP untuk filter ini.</p>
                            <button onclick="tambah()" class="bg-emerald-900 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-emerald-800 transition-colors">
                                <i class="fa-solid fa-plus mr-1"></i> Tambah RPP Baru
                            </button>
                        </div>
                    <?php } ?>
                </div>

            <?php } else { ?>
                <!-- BLANK STATE -->
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                    <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-chalkboard-user text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Rencana Program Pembelajaran</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Silakan tentukan <strong>Departemen, Tingkat, Semester,</strong> dan <strong>Pelajaran</strong> pada filter di atas, lalu klik tombol <strong>Tampilkan RPP</strong>.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>