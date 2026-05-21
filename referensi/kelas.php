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
$departemen  = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$tahunajaran = isset($_REQUEST['tahunajaran']) ? $_REQUEST['tahunajaran'] : '';
$tingkat     = isset($_REQUEST['tingkat']) ? $_REQUEST['tingkat'] : '';
$action      = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// Parameter paginasi dan sorting
$varbaris = isset($_REQUEST['varbaris']) ? $_REQUEST['varbaris'] : 10;
$page     = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
$hal      = isset($_REQUEST['hal']) ? $_REQUEST['hal'] : 0;
$urut     = isset($_REQUEST['urut']) ? $_REQUEST['urut'] : "kelas";    
$urutan   = isset($_REQUEST['urutan']) ? $_REQUEST['urutan'] : "ASC";    

// =========================================================================
// PROSES AKSI (HAPUS & UBAH STATUS AKTIF)
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

if ($op == "dw8dxn8w9ms8zs22") {
    $sql = "UPDATE kelas SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
    QueryDb($sql);
} 
else if ($op == "xm8r389xemx23xb2378e23") {
    $sql = "DELETE FROM kelas WHERE replid = '$_REQUEST[replid]'";
    QueryDb($sql);
    
    // Redirect setelah hapus
    echo "<script>window.location.href='kelas.php?action=view&departemen=".urlencode($departemen)."&tahunajaran=$tahunajaran&tingkat=$tingkat&page=$page&hal=$hal&varbaris=$varbaris';</script>";
    exit;
}

// Get labels for display
$nama_tingkat = "";
$nama_tahunajaran = "";
if (!empty($tingkat)) {
    $row = @mysqli_fetch_row(QueryDb("SELECT tingkat FROM tingkat WHERE replid='$tingkat'"));
    $nama_tingkat = $row[0];
}
if (!empty($tahunajaran)) {
    $row = @mysqli_fetch_row(QueryDb("SELECT tahunajaran FROM tahunajaran WHERE replid='$tahunajaran'"));
    $nama_tahunajaran = $row[0];
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script type="text/javascript">
        function change_dep() {
            var departemen = document.getElementById("departemen").value;
            window.location.href = "kelas.php?departemen=" + encodeURIComponent(departemen);
        }

        function change_filter() {
            var departemen = document.getElementById("departemen").value;
            var tingkat = document.getElementById("tingkat").value;
            var tahunajaran = document.getElementById("tahunajaran").value;
            window.location.href = "kelas.php?departemen=" + encodeURIComponent(departemen) + "&tingkat=" + tingkat + "&tahunajaran=" + tahunajaran;
        }

        function show_kelas() {
            var departemen = document.getElementById("departemen").value;
            var tingkat = document.getElementById("tingkat").value;
            var tahunajaran = document.getElementById("tahunajaran").value;
            
            if (departemen == "" || tingkat == "" || tahunajaran == "") {
                alert('Silakan lengkapi semua filter!');
                return false;
            }    
            window.location.href = "kelas.php?action=view&departemen=" + encodeURIComponent(departemen) + "&tahunajaran=" + encodeURIComponent(tahunajaran) + "&tingkat=" + encodeURIComponent(tingkat);
        }

        function carisiswa(replid) {	
            window.open('../library/lihatsiswa.php?replid='+replid, 'LihatSiswa','width=790,height=650,resizable=1,scrollbars=1');
        }

        function tambah() {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            window.open('kelas_add.php?departemen='+departemen+'&tingkat='+tingkat+'&tahunajaran='+tahunajaran, 'TambahKelas', 'width=500,height=395,resizable=1,scrollbars=1');
        }

        function edit(replid) {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            window.open('kelas_edit.php?replid='+replid+'&departemen='+departemen+'&tingkat='+tingkat+'&tahunajaran='+tahunajaran, 'UbahKelas', 'width=500,height=395,resizable=1,scrollbars=1');
        }

        function hapus(replid) {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            if (confirm("Apakah anda yakin akan menghapus kelas ini?")) {
                window.location.href = "kelas.php?action=view&op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
            }
        }

        function setaktif(replid, aktif) {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            var msg = (aktif == 1) ? "Non-aktifkan kelas ini?" : "Aktifkan kelas ini?";
            var newaktif = (aktif == 1) ? 0 : 1;
            
            if (confirm(msg)) {
                window.location.href = "kelas.php?action=view&op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
            }
        }

        function change_urut(urut_baru, urutan_lama) {		
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            var urutan_baru = (urutan_lama == "ASC") ? "DESC" : "ASC";
            window.location.href = "kelas.php?action=view&departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&urut="+urut_baru+"&urutan="+urutan_baru+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
        }

        function cetak() {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            var total = document.getElementById("total") ? document.getElementById("total").value : 0;
            window.open('kelas_cetak.php?departemen='+departemen+'&tingkat='+tingkat+'&tahunajaran='+tahunajaran+'&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakKelas', 'width=790,height=650,resizable=1,scrollbars=1');
        }

        function change_hal() {
            var departemen = document.getElementById("departemen").value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            var hal = document.getElementById("hal").value;
            var varbaris = document.getElementById("varbaris").value;
            window.location.href = "kelas.php?action=view&departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
        }

        function change_baris() {
            var departemen = document.getElementById("departemen").value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            var varbaris = document.getElementById("varbaris").value;
            window.location.href = "kelas.php?action=view&departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
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
                    <i class="fa-solid fa-users-rectangle text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Referensi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">DATA KELAS</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Referensi</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Kelas</span>
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
                            if ($departemen == "") $departemen = $value; 
                            $selected = ($value == $departemen) ? "selected" : "";
                            echo "<option value=\"$value\" $selected>$value</option>";
                        } ?>
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Tahun Ajaran</label>
                    <select id="tahunajaran" onChange="change_filter()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php
                        $sql_ta = "SELECT * FROM tahunajaran where departemen='$departemen' ORDER BY aktif DESC, tglmulai DESC";
                        $res_ta = QueryDb($sql_ta);
                        while ($row_ta = mysqli_fetch_array($res_ta)) {
                            if ($tahunajaran == "") $tahunajaran = $row_ta['replid'];
                            $ada = $row_ta['aktif'] ? "(Aktif)" : "";
                            $selected = ($row_ta['replid'] == $tahunajaran) ? "selected" : "";
                            echo "<option value=\"{$row_ta['replid']}\" $selected>{$row_ta['tahunajaran']} $ada</option>";
                        } ?>
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Tingkat</label>
                    <select id="tingkat" onChange="change_filter()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php 
                        $sql_tkt = "SELECT * FROM tingkat where departemen='$departemen' AND aktif=1 ORDER BY urutan";
                        $res_tkt = QueryDb($sql_tkt);
                        while ($row_tkt = mysqli_fetch_array($res_tkt)) {
                            if ($tingkat == "") $tingkat = $row_tkt['replid'];
                            $selected = ($row_tkt['replid'] == $tingkat) ? "selected" : "";
                            echo "<option value=\"{$row_tkt['replid']}\" $selected>{$row_tkt['tingkat']}</option>";
                        } ?>
                    </select>
                </div>

                <div>
                    <button onclick="show_kelas()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-eye"></i> TAMPILKAN KELAS
                    </button>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
            <?php if ($action == 'view' && !empty($tingkat)) { ?>
                
                <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Kelas: <span class="text-emerald-700"><?=$nama_tingkat?></span></h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?=$departemen?> &bull; <?=$nama_tahunajaran?></p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <button onclick="cetak()" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-2.5 rounded-2xl hover:bg-emerald-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-print"></i> CETAK
                        </button>
                        <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                        <button onclick="tambah()" class="bg-emerald-900 text-white px-5 py-2.5 rounded-2xl hover:bg-emerald-800 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-plus"></i> TAMBAH KELAS
                        </button>
                        <?php } ?>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <?php
                    $sql_tot = "SELECT k.replid FROM kelas k WHERE k.idtahunajaran='$tahunajaran' AND k.idtingkat='$tingkat'";
                    $res_tot = QueryDb($sql_tot);
                    $jumlah = mysqli_num_rows($res_tot);
                    $total_hal = ceil($jumlah / $varbaris);

                    $sql_kelas = "SELECT k.replid, k.kelas, k.kapasitas, k.aktif, k.keterangan, p.nama as wali 
                                  FROM kelas k LEFT JOIN jbssdm.pegawai p ON k.nipwali = p.nip 
                                  WHERE k.idtahunajaran='$tahunajaran' AND k.idtingkat='$tingkat' 
                                  ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
                    $res_kelas = QueryDb($sql_kelas);

                    if (mysqli_num_rows($res_kelas) > 0) {
                    ?>
                        <input type="hidden" id="total" value="<?=$total_hal?>">
                        <div class="overflow-hidden rounded-2xl border border-slate-100">
                            <table class="min-w-full divide-y divide-slate-100 text-sm">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-12">No</th>
                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest cursor-pointer hover:text-emerald-700" onclick="change_urut('kelas','<?=$urutan?>')">Kelas</th>
                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest cursor-pointer hover:text-emerald-700" onclick="change_urut('p.nama','<?=$urutan?>')">Wali Kelas</th>
                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24" onclick="change_urut('kapasitas','<?=$urutan?>')">Kapasitas</th>
                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">Terisi</th>
                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Keterangan</th>
                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">Status</th>
                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 bg-white">
                                    <?php 
                                    $cnt = ($page * $varbaris) + 1;
                                    while ($row = mysqli_fetch_array($res_kelas)) { 
                                        $terisi = @mysqli_fetch_row(QueryDb("SELECT COUNT(*) FROM siswa WHERE idkelas='{$row['replid']}' AND aktif=1"))[0];
                                    ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-4 py-4 text-center text-slate-400 font-bold"><?=$cnt++?></td>
                                            <td class="px-4 py-4 font-bold text-emerald-800"><?=$row['kelas']?></td>
                                            <td class="px-4 py-4 text-slate-700 font-medium"><?=$row['wali']?></td>
                                            <td class="px-4 py-4 text-center font-bold text-slate-600"><?=$row['kapasitas']?></td>
                                            <td class="px-4 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <span class="font-bold <?=$terisi > 0 ? 'text-emerald-600' : 'text-slate-300'?>"><?=$terisi?></span>
                                                    <?php if ($terisi > 0) { ?>
                                                        <button onclick="carisiswa(<?=$row['replid']?>)" class="text-slate-400 hover:text-emerald-600"><i class="fa-solid fa-circle-info"></i></button>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-xs text-slate-500"><?=$row['keterangan']?></td>
                                            <td class="px-4 py-4 text-center">
                                                <button onclick="setaktif(<?=$row['replid']?>, <?=$row['aktif']?>)" class="transition-opacity hover:opacity-80">
                                                    <i class="fa-solid <?= $row['aktif'] == 1 ? 'fa-toggle-on text-emerald-600' : 'fa-toggle-off text-slate-300' ?> text-2xl"></i>
                                                </button>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <button onclick="edit(<?=$row['replid']?>)" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                                    <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                                    <button onclick="hapus(<?=$row['replid']?>)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
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
                                <span>Baris</span>
                                <select id="varbaris" onChange="change_baris()" class="bg-white border border-slate-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-emerald-500">
                                    <?php for ($m=5; $m <= 50; $m+=5) { ?>
                                        <option value="<?=$m?>" <?=IntIsSelected($varbaris,$m)?>><?=$m?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="flex flex-col items-center justify-center p-16 text-center space-y-4 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                            <i class="fa-solid fa-folder-open text-5xl text-slate-200"></i>
                            <p class="text-slate-500 font-medium">Belum ada data kelas untuk filter ini.</p>
                            <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                            <button onclick="tambah()" class="bg-emerald-900 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-emerald-800 transition-colors">
                                <i class="fa-solid fa-plus mr-1"></i> Tambah Kelas Baru
                            </button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

            <?php } else { ?>
                <!-- BLANK STATE -->
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                    <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-users-rectangle text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Manajemen Data Kelas</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Silakan tentukan <strong>Departemen, Tahun Ajaran,</strong> dan <strong>Tingkat</strong> pada filter di atas, lalu klik tombol <strong>Tampilkan Kelas</strong>.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>
