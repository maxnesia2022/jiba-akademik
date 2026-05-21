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
$tahunajaran = isset($_REQUEST['tahunajaran']) ? $_REQUEST['tahunajaran'] : '';
$info_jadwal = isset($_REQUEST['info_jadwal']) ? $_REQUEST['info_jadwal'] : '';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// Data Info Jadwal Details
$info_deskripsi = "";
$periode = "";
if (!empty($info_jadwal)) {
    $sql_i = "SELECT i.deskripsi, t.tglmulai, t.tglakhir FROM infojadwal i, tahunajaran t WHERE i.replid = '$info_jadwal' AND t.replid = i.idtahunajaran";
    $res_i = QueryDb($sql_i);
    if ($row_i = mysqli_fetch_array($res_i)) {
        $info_deskripsi = $row_i['deskripsi'];
        $periode = format_tgl($row_i['tglmulai']).' s/d '. format_tgl($row_i['tglakhir']);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Jadwal Guru</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function change_dep() {
        var dep = document.getElementById("departemen").value;
        window.location.href = "rekap_jadwal_main.php?departemen=" + encodeURIComponent(dep);
    }

    function change_tahunajaran() {
        var dep = document.getElementById("departemen").value;
        var ta = document.getElementById("tahunajaran").value;
        window.location.href = "rekap_jadwal_main.php?departemen=" + encodeURIComponent(dep) + "&tahunajaran=" + ta;
    }

    function change_info() {
        var dep = document.getElementById("departemen").value;
        var ta = document.getElementById("tahunajaran").value;
        var info = document.getElementById("info_jadwal").value;
        window.location.href = "rekap_jadwal_main.php?departemen=" + encodeURIComponent(dep) + "&tahunajaran=" + ta + "&info_jadwal=" + info;
    }

    function show_rekap() {
        var dep = document.getElementById("departemen").value;
        var ta = document.getElementById("tahunajaran").value;
        var info = document.getElementById("info_jadwal").value;
        if (info == "") { alert('Pilih Info Jadwal terlebih dahulu!'); return false; }
        window.location.href = "rekap_jadwal_main.php?action=view&departemen=" + encodeURIComponent(dep) + "&tahunajaran=" + ta + "&info_jadwal=" + info;
    }

    function cetak() {
        window.open('rekap_jadwal_cetak.php?info=<?=$info_jadwal?>', 'CetakRekap', '790', '650', 'resizable=1,scrollbars=1');
    }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-emerald-950 text-slate-800 min-h-screen p-4 md:p-6 overflow-x-hidden">

    <div class="w-full h-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-emerald-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-emerald-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-clipboard-list text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Jadwal & Kalender</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">REKAP JADWAL GURU</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Jadwal</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Rekap Jadwal</span>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                <!-- Departemen Selection -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Departemen</label>
                    <select id="departemen" onChange="change_dep()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                        <?php 
                        $dep_list = getDepartemen(SI_USER_ACCESS());    
                        foreach($dep_list as $value) {
                            if ($departemen == "") $departemen = $value; 
                            $selected = ($value == $departemen) ? "selected" : "";
                            echo "<option value=\"$value\" $selected>$value</option>";
                        } ?>
                    </select>
                </div>

                <!-- Tahun Ajaran Selection -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Tahun Ajaran</label>
                    <select id="tahunajaran" onChange="change_tahunajaran()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                        <?php
                        $sql_ta = "SELECT replid, tahunajaran, aktif FROM tahunajaran WHERE departemen='$departemen' ORDER BY aktif DESC, replid DESC";
                        $res_ta = QueryDb($sql_ta);
                        while ($row_ta = mysqli_fetch_array($res_ta)) {
                            if ($tahunajaran == "") $tahunajaran = $row_ta['replid'];
                            $ada = $row_ta['aktif'] ? " (Aktif)" : "";
                            $selected = ($row_ta['replid'] == $tahunajaran) ? "selected" : "";
                            echo "<option value=\"{$row_ta['replid']}\" $selected>{$row_ta['tahunajaran']}$ada</option>";
                        } ?>
                    </select>
                </div>

                <!-- Info Jadwal Selection -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Info Jadwal</label>
                    <select id="info_jadwal" onChange="change_info()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                        <?php
                        $sql_ij = "SELECT i.replid, i.deskripsi, i.aktif FROM infojadwal i WHERE i.idtahunajaran = '$tahunajaran' AND i.aktif=1 ORDER BY i.aktif DESC";
                        $res_ij = QueryDb($sql_ij);
                        while ($row_ij = mysqli_fetch_array($res_ij)) {
                            if ($info_jadwal == "") $info_jadwal = $row_ij['replid'];
                            $selected = ($row_ij['replid'] == $info_jadwal) ? "selected" : "";
                            $ada = $row_ij['aktif'] ? " (Aktif)" : "";
                            echo "<option value=\"{$row_ij['replid']}\" $selected>{$row_ij['deskripsi']}$ada</option>";
                        } ?>
                    </select>
                </div>

                <!-- Action Button -->
                <div>
                    <button onclick="show_rekap()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-eye"></i> TAMPILKAN REKAP
                    </button>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
            <?php if ($action == 'view' && !empty($info_jadwal)) { ?>
                
                <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800"><?=$info_deskripsi?></h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Periode: <span class="text-emerald-600"><?=$periode?></span></p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <button onclick="cetak()" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-2.5 rounded-2xl hover:bg-emerald-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-print"></i> CETAK
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-auto p-6">
                    <?php
                    $sql_rekap = "SELECT p.nip, p.nama, 
                                        SUM(IF(j.status = 0, 1, 0)) as mengajar, 
                                        SUM(IF(j.status = 1, 1, 0)) as asistensi, 
                                        SUM(IF(j.status = 2, 1, 0)) as tambahan, 
                                        SUM(j.njam) as total_jam, 
                                        COUNT(DISTINCT(j.idkelas)) as jml_kelas, 
                                        COUNT(DISTINCT(j.hari)) as jml_hari 
                                 FROM jadwal j, pegawai p 
                                 WHERE j.nipguru = p.nip AND j.infojadwal = '$info_jadwal' 
                                 GROUP BY j.nipguru ORDER BY p.nama";
                    $res_rekap = QueryDb($sql_rekap);
                    if (mysqli_num_rows($res_rekap) > 0) {
                    ?>
                        <div class="overflow-hidden rounded-2xl border border-slate-100">
                            <table class="min-w-full divide-y divide-slate-100 text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th rowspan="2" class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-12">No</th>
                                        <th rowspan="2" class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest w-32">NIP</th>
                                        <th rowspan="2" class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Nama Guru</th>
                                        <th colspan="6" class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-100/50">Jumlah</th>
                                    </tr>
                                    <tr class="bg-slate-50/50">
                                        <th class="px-4 py-2 text-center text-[9px] font-bold text-slate-500 uppercase">Mengajar</th>
                                        <th class="px-4 py-2 text-center text-[9px] font-bold text-slate-500 uppercase">Asistensi</th>
                                        <th class="px-4 py-2 text-center text-[9px] font-bold text-slate-500 uppercase">Tambahan</th>
                                        <th class="px-4 py-2 text-center text-[9px] font-bold text-slate-500 uppercase">Jam</th>
                                        <th class="px-4 py-2 text-center text-[9px] font-bold text-slate-500 uppercase">Kelas</th>
                                        <th class="px-4 py-2 text-center text-[9px] font-bold text-slate-500 uppercase border-r-0">Hari</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 bg-white">
                                    <?php 
                                    $cnt = 0;
                                    while ($row = mysqli_fetch_array($res_rekap)) { 
                                    ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-4 py-4 text-center text-slate-400 font-bold"><?=++$cnt?></td>
                                            <td class="px-4 py-4 font-mono text-xs text-slate-500"><?=$row['nip']?></td>
                                            <td class="px-4 py-4 font-bold text-slate-800"><?=$row['nama']?></td>
                                            <td class="px-4 py-4 text-center">
                                                <span class="inline-flex px-2 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-xs"><?=$row['mengajar']?></span>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <span class="inline-flex px-2 py-1 rounded-lg bg-blue-50 text-blue-700 font-bold text-xs"><?=$row['asistensi']?></span>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <span class="inline-flex px-2 py-1 rounded-lg bg-amber-50 text-amber-700 font-bold text-xs"><?=$row['tambahan']?></span>
                                            </td>
                                            <td class="px-4 py-4 text-center font-extrabold text-slate-900"><?=$row['total_jam']?></td>
                                            <td class="px-4 py-4 text-center text-slate-600 font-semibold"><?=$row['jml_kelas']?></td>
                                            <td class="px-4 py-4 text-center text-slate-600 font-semibold"><?=$row['jml_hari']?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="flex flex-col items-center justify-center p-16 text-center space-y-4 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                            <i class="fa-solid fa-folder-open text-5xl text-slate-200"></i>
                            <p class="text-slate-500 font-medium">Tidak ditemukan data jadwal untuk info jadwal ini.</p>
                        </div>
                    <?php } ?>
                </div>

            <?php } else { ?>
                <!-- BLANK STATE -->
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                    <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-clipboard-list text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Rekapitulasi Jadwal Guru</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Pilih <strong>Departemen, Tahun Ajaran</strong> dan <strong>Info Jadwal</strong> untuk melihat ringkasan beban mengajar setiap guru.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>