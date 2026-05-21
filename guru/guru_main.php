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
$id_pelajaran = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$aktif_view = isset($_REQUEST['aktif']) ? $_REQUEST['aktif'] : 0; // 1: filtered by pelajaran, 0: all in departemen
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : ''; // 'view' to show content

$urut = isset($_REQUEST['urut']) ? $_REQUEST['urut'] : "p.nama";	
$urutan = isset($_REQUEST['urutan']) ? $_REQUEST['urutan'] : "ASC";

// =========================================================================
// PROSES AKSI (HAPUS)
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
if ($op == "xm8r389xemx23xb2378e23") {
    $sql = "DELETE FROM guru WHERE replid = '$_REQUEST[replid]'";
    QueryDb($sql);
    // Redirect or refresh to maintain state
    echo "<script>window.location.href='guru_main.php?action=view&departemen=$departemen&id=$id_pelajaran&aktif=$aktif_view&urut=$urut&urutan=$urutan';</script>";
    exit;
}

// Get Pelajaran Name if filtered
$guru_title = "Semua Pelajaran";
$query_filter = "AND j.departemen = '$departemen'";
if ($aktif_view == 1 && !empty($id_pelajaran)) {
    $sql_p = "SELECT nama FROM pelajaran WHERE replid = '$id_pelajaran'";
    $res_p = QueryDb($sql_p);
    $row_p = mysqli_fetch_array($res_p);
    $guru_title = $row_p['nama'];
    $query_filter = "AND g.idpelajaran = $id_pelajaran";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Guru</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script type="text/javascript">
        function change_dep() {
            var dep = document.getElementById("departemen").value;
            window.location.href = "guru_main.php?departemen=" + encodeURIComponent(dep);
        }

        function show_all() {
            var dep = document.getElementById("departemen").value;
            window.location.href = "guru_main.php?action=view&aktif=0&departemen=" + encodeURIComponent(dep);
        }

        function filter_pelajaran(id) {
            var dep = document.getElementById("departemen").value;
            window.location.href = "guru_main.php?action=view&aktif=1&id=" + id + "&departemen=" + encodeURIComponent(dep);
        }

        function tambah() {
            var dep = "<?=$departemen?>";
            var id = "<?=$id_pelajaran?>";
            var aktif = "<?=$aktif_view?>";
            var guru = "<?=$guru_title?>";
            window.open('guru_add.php?departemen='+dep+'&guru='+guru+'&aktif='+aktif+'&id='+id, 'TambahGuru', 'width=500,height=340,resizable=1,scrollbars=1');
        }

        function edit(replid) {
            var aktif = "<?=$aktif_view?>";
            window.open('guru_edit.php?replid='+replid+'&aktif='+aktif, 'UbahGuru', 'width=500,height=340,resizable=1,scrollbars=1');
        }

        function hapus(replid) {
            if (confirm("Apakah anda yakin akan menghapus status guru ini?")) {
                window.location.href = "guru_main.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen=<?=$departemen?>&aktif=<?=$aktif_view?>&id=<?=$id_pelajaran?>&urut=<?=$urut?>&urutan=<?=$urutan?>";
            }
        }

        function change_urut(new_urut) {
            var urutan = "<?=$urutan?>";
            var new_urutan = (urutan == "ASC") ? "DESC" : "ASC";
            window.location.href = "guru_main.php?action=view&departemen=<?=$departemen?>&id=<?=$id_pelajaran?>&aktif=<?=$aktif_view?>&urut="+new_urut+"&urutan="+new_urutan;
        }

        function cetak() {
            window.open('guru_cetak.php?departemen=<?=$departemen?>&aktif=<?=$aktif_view?>&guru=<?=$guru_title?>&id=<?=$id_pelajaran?>&urut=<?=$urut?>&urutan=<?=$urutan?>', 'CetakGuru', 'width=790,height=650,resizable=1,scrollbars=1');
        }
    </script>
</head>
<body class="bg-gray-100 font-sans p-4" onload="document.getElementById('departemen').focus()">

<div class="max-w-7xl mx-auto space-y-4">

    <!-- ========================================================================= -->
    <!-- FILTER & NAVIGATION                                                       -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-lg shadow-sm border border-emerald-100 p-5">
        <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
            <h2 class="text-xl font-bold text-emerald-900 flex items-center gap-2">
                <i class="fas fa-chalkboard-teacher text-emerald-500"></i> Pendataan Guru
            </h2>
            <div class="text-sm text-gray-500 hidden sm:block">
                Guru & Pelajaran <i class="fas fa-chevron-right text-xs mx-1"></i> Guru
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Departemen</label>
                <select name="departemen" id="departemen" onchange="change_dep()" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
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
            <div class="md:col-span-4">
                <button type="button" onclick="show_all()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition flex items-center justify-center gap-2">
                    <i class="fas fa-users"></i> Tampilkan Semua Guru
                </button>
            </div>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-4">
        
        <!-- ========================================================================= -->
        <!-- LEFT COLUMN: PELAJARAN LIST                                               -->
        <!-- ========================================================================= -->
        <div class="lg:w-1/3 bg-white rounded-lg shadow-sm border border-emerald-100 p-5 h-fit">
            <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wider flex items-center gap-2">
                <i class="fas fa-book text-emerald-500"></i> Pilih Pelajaran
            </h3>
            
            <?php 
            $sql_pel = "SELECT replid,nama,aktif,kode FROM pelajaran WHERE departemen = '$departemen' ORDER BY nama ASC, aktif DESC";
            $res_pel = QueryDb($sql_pel);
            if (mysqli_num_rows($res_pel) > 0) {
            ?>
            <div class="overflow-hidden rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Kode</th>
                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-600">Pelajaran</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php while ($row_pel = mysqli_fetch_array($res_pel)) { 
                            $is_active = ($aktif_view == 1 && $id_pelajaran == $row_pel['replid']);
                        ?>
                        <tr class="hover:bg-emerald-50 cursor-pointer transition <?= $is_active ? 'bg-emerald-50' : '' ?>" onclick="filter_pelajaran(<?=$row_pel['replid']?>)">
                            <td class="px-3 py-2 text-gray-600 font-mono text-xs"><?=$row_pel['kode']?></td>
                            <td class="px-3 py-2 <?= $is_active ? 'font-bold text-emerald-700' : 'text-gray-800' ?>">
                                <?=$row_pel['nama']?>
                                <?php if ($row_pel['aktif'] == 0) echo ' <span class="text-[10px] bg-gray-100 text-gray-400 px-1 rounded">Non-Aktif</span>'; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
                <div class="p-4 text-center text-sm text-red-500 bg-red-50 rounded-lg border border-red-100">
                    Tidak ditemukan data pelajaran pada departemen <?=$departemen?>.
                </div>
            <?php } ?>
        </div>

        <!-- ========================================================================= -->
        <!-- RIGHT COLUMN: TEACHER LIST                                                -->
        <!-- ========================================================================= -->
        <div class="lg:w-2/3 bg-white rounded-lg shadow-sm border border-emerald-100 p-5">
            <?php if ($action == 'view') { ?>
                
                <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-3">
                    <h3 class="text-lg font-bold text-emerald-900">
                        Guru: <span class="text-emerald-600"><?=$guru_title?></span>
                    </h3>
                    <div class="flex gap-2">
                        <button onclick="cetak()" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-1.5 px-3 rounded shadow-sm transition flex items-center gap-2">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                        <button onclick="tambah()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-1.5 px-3 rounded shadow-sm transition flex items-center gap-2">
                            <i class="fas fa-plus"></i> Tambah Guru
                        </button>
                    </div>
                </div>

                <?php
                $sql_guru = "SELECT g.replid, g.nip, p.nama, s.status, g.keterangan, j.nama as pelajaran 
                             FROM guru g, pegawai p, pelajaran j, statusguru s 
                             WHERE g.nip=p.nip AND g.idpelajaran = j.replid AND g.statusguru = s.status 
                             $query_filter 
                             ORDER BY $urut $urutan";
                $res_guru = QueryDb($sql_guru);
                if (mysqli_num_rows($res_guru) > 0) {
                ?>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-emerald-50">
                            <tr>
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-800 uppercase w-12">No</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase cursor-pointer hover:bg-emerald-100 transition" onclick="change_urut('nip')">NIP</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase cursor-pointer hover:bg-emerald-100 transition" onclick="change_urut('p.nama')">Nama Guru</th>
                                <?php if ($aktif_view == 0) { ?>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase cursor-pointer hover:bg-emerald-100 transition" onclick="change_urut('j.nama')">Pelajaran</th>
                                <?php } ?>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase cursor-pointer hover:bg-emerald-100 transition" onclick="change_urut('statusguru')">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase">Keterangan</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-800 uppercase w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php 
                            $cnt = 0;
                            while ($row = mysqli_fetch_array($res_guru)) { 
                            ?>
                            <tr class="hover:bg-emerald-50 transition">
                                <td class="px-4 py-2 text-center text-gray-500"><?=++$cnt?></td>
                                <td class="px-4 py-2 text-gray-800 font-mono text-xs"><?=$row['nip']?></td>
                                <td class="px-4 py-2 text-gray-900 font-bold"><?=$row['nama']?></td>
                                <?php if ($aktif_view == 0) { ?>
                                <td class="px-4 py-2 text-gray-600"><?=$row['pelajaran']?></td>
                                <?php } ?>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?=$row['status']?>
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-gray-600 italic text-xs"><?=$row['keterangan']?></td>
                                <td class="px-4 py-2 text-center flex justify-center gap-2">
                                    <button onclick="edit(<?=$row['replid']?>)" class="text-amber-500 hover:text-amber-700 transition" title="Ubah">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button onclick="hapus(<?=$row['replid']?>)" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php } else { ?>
                    <div class="flex flex-col items-center justify-center p-10 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
                        <p class="text-lg font-medium text-gray-600">Tidak ditemukan data guru.</p>
                        <button onclick="tambah()" class="mt-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded shadow transition">
                            <i class="fas fa-plus mr-1"></i> Isi Data Baru
                        </button>
                    </div>
                <?php } ?>

            <?php } else { ?>
                <!-- BLANK STATE -->
                <div class="flex flex-col items-center justify-center p-16 text-center bg-emerald-50 rounded-lg border border-emerald-100">
                    <i class="fas fa-chalkboard-teacher text-6xl text-emerald-200 mb-4"></i>
                    <h3 class="text-xl font-bold text-emerald-800 mb-2">Kelola Data Guru</h3>
                    <p class="text-emerald-600 max-w-md">
                        Klik pada tombol <strong>Tampilkan Semua Guru</strong> atau pilih salah satu <strong>Pelajaran</strong> di panel kiri untuk mengelola pendataan guru.
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>

</div>

<?php CloseDb(); ?>
</body>
</html>