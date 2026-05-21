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
$id_pelajaran = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

// =========================================================================
// PROSES AKSI (HAPUS)
// =========================================================================
if ($op == "xm8r389xemx23xb2378e23") {
    $replid = $_REQUEST['replid'];
    $sql = "DELETE FROM jenisujian WHERE replid = '$replid'";
    QueryDb($sql);
    // Redirect to maintain state
    echo "<script>window.location.href='jenis_pengujian.php?departemen=$departemen&id=$id_pelajaran';</script>";
    exit;
}

// Data Pelajaran (Jika dipilih)
$pelajaran_name = "";
if (!empty($id_pelajaran)) {
    $sql_p = "SELECT nama FROM pelajaran WHERE replid = '$id_pelajaran'";
    $res_p = QueryDb($sql_p);
    if ($row_p = mysqli_fetch_array($res_p)) {
        $pelajaran_name = $row_p['nama'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Pengujian</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function change_dep() {
        var dep = document.getElementById('departemen').value;
        window.location.href = "jenis_pengujian.php?departemen=" + encodeURIComponent(dep);
    }

    function pilih_pelajaran(id) {
        var dep = "<?=$departemen?>";
        window.location.href = "jenis_pengujian.php?departemen=" + encodeURIComponent(dep) + "&id=" + id;
    }

    function tambah() {
        var id = "<?=$id_pelajaran?>";
        var pel = "<?=urlencode($pelajaran_name)?>";
        var dep = "<?=urlencode($departemen)?>";
        window.open('jenis_pengujian_add.php?preplid='+id+'&nama_pel='+pel+'&nama_dep='+dep, 'TambahJenisPengujian','550','400','resizable=1,scrollbars=1');
    }

    function edit(replid) {
        window.open('jenis_pengujian_edit.php?replid='+replid, 'UbahJenisPengujian','550','400','resizable=1,scrollbars=1');
    }

    function hapus(replid) {
        if (confirm("Apakah anda yakin akan menghapus jenis pengujian ini?")) {
            window.location.href = "jenis_pengujian.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&id=<?=$id_pelajaran?>&departemen=<?=$departemen?>";
        }
    }

    function cetak() {
        window.open('jenis_pengujian_cetak.php?id=<?=$id_pelajaran?>', 'CetakJenisPengujian','790','650','resizable=1,scrollbars=1');
    }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-emerald-950 text-slate-800 min-h-screen p-4 md:p-6 overflow-x-hidden">

    <!-- MAIN CONTAINER -->
    <div class="w-full h-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-emerald-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-emerald-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-vial-circle-check text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Guru & Pelajaran</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">JENIS PENGUJIAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Guru & Pelajaran</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Jenis Pengujian</span>
            </div>
        </div>

        <div class="flex-1 flex flex-col lg:flex-row gap-6 overflow-hidden">
            
            <!-- SIDEBAR: LESSON SELECTION -->
            <div class="lg:w-80 flex flex-col gap-6 flex-shrink-0">
                
                <!-- DEPARTEMEN FILTER -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 block">Departemen</label>
                    <select id="departemen" onChange="change_dep()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-colors cursor-pointer">
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

                <!-- LESSON LIST -->
                <div class="flex-1 bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="text-xs font-bold text-slate-600 uppercase tracking-widest px-2">Daftar Pelajaran</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-2">
                        <?php
                        $sql_pel = "SELECT replid, nama, departemen, kode FROM pelajaran WHERE departemen = '$departemen' ORDER BY nama";
                        $res_pel = QueryDb($sql_pel);
                        if (mysqli_num_rows($res_pel) > 0) {
                            while ($row_pel = mysqli_fetch_array($res_pel)) {
                                $is_active = ($id_pelajaran == $row_pel['replid']);
                        ?>
                                <button onclick="pilih_pelajaran('<?=$row_pel['replid']?>')" class="group w-full flex items-center gap-3 p-3 rounded-2xl border border-transparent transition-all <?= $is_active ? 'bg-emerald-900 text-white shadow-md' : 'hover:bg-slate-50 text-slate-600' ?>">
                                    <div class="w-10 h-10 flex items-center justify-center rounded-xl font-bold text-xs transition-colors uppercase <?= $is_active ? 'bg-emerald-800 text-white' : 'bg-slate-100 text-emerald-700' ?>">
                                        <?=$row_pel['kode']?>
                                    </div>
                                    <div class="flex-1 text-left overflow-hidden">
                                        <p class="text-xs font-bold truncate"><?=$row_pel['nama']?></p>
                                        <p class="text-[9px] uppercase tracking-tighter italic <?= $is_active ? 'text-emerald-300' : 'text-slate-400' ?>"><?=$row_pel['departemen']?></p>
                                    </div>
                                    <div class="<?= $is_active ? 'text-emerald-300' : 'text-slate-300 group-hover:text-emerald-500' ?>">
                                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </div>
                                </button>
                        <?php 
                            }
                        } else {
                            echo '<div class="p-8 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200"><p class="text-[10px] font-bold text-slate-400 uppercase leading-tight">Tidak ada pelajaran</p></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT: TEST TYPES -->
            <div class="flex-1 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
                <?php if (!empty($id_pelajaran)) { ?>
                    
                    <div class="p-6 md:p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900"><?=$pelajaran_name?></h3>
                            <p class="text-xs text-emerald-600 font-semibold uppercase tracking-widest mt-1"><?=$departemen?></p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                                <i class="fa-solid fa-rotate"></i>
                            </button>
                            <button onclick="cetak()" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-2.5 rounded-2xl hover:bg-emerald-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                                <i class="fa-solid fa-print"></i> CETAK
                            </button>
                            <button onclick="tambah()" class="bg-emerald-900 text-white px-5 py-2.5 rounded-2xl hover:bg-emerald-800 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                                <i class="fa-solid fa-plus"></i> TAMBAH JENIS PENGUJIAN
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6 md:p-8">
                        <?php
                        $sql_j = "SELECT j.replid, j.jenisujian, j.idpelajaran, j.keterangan, p.replid, p.nama, p.departemen, j.info1 
                                  FROM jenisujian j, pelajaran p 
                                  WHERE j.idpelajaran = '$id_pelajaran' AND j.idpelajaran = p.replid 
                                  ORDER BY j.jenisujian";   
                        $res_j = QueryDb($sql_j);
                        if (mysqli_num_rows($res_j) > 0) {
                        ?>
                            <div class="overflow-hidden rounded-2xl border border-slate-100">
                                <table class="min-w-full divide-y divide-slate-100 text-sm">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-12">No</th>
                                            <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest w-32">Singkatan</th>
                                            <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jenis Pengujian</th>
                                            <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Keterangan</th>
                                            <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        <?php 
                                        $cnt = 0;
                                        while ($row = mysqli_fetch_array($res_j)) { 
                                        ?>
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-4 py-4 text-center text-slate-400 font-bold"><?=++$cnt?></td>
                                                <td class="px-4 py-4 font-mono text-xs font-bold text-emerald-700"><?=$row['info1']?></td>
                                                <td class="px-4 py-4 font-bold text-slate-800"><?=$row['jenisujian']?></td>
                                                <td class="px-4 py-4 text-xs text-slate-500 italic"><?=$row['keterangan']?></td>
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
                        <?php } else { ?>
                            <div class="flex flex-col items-center justify-center p-16 text-center space-y-4 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                                <i class="fa-solid fa-vial-circle-check text-5xl text-slate-200"></i>
                                <p class="text-slate-500 font-medium">Belum ada jenis pengujian untuk pelajaran ini.</p>
                                <button onclick="tambah()" class="bg-emerald-900 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-emerald-800 transition-colors">
                                    <i class="fa-solid fa-plus mr-1"></i> Tambah Data Baru
                                </button>
                            </div>
                        <?php } ?>
                    </div>

                <?php } else { ?>
                    <!-- BLANK STATE CONTENT -->
                    <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                        <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-vial text-5xl text-emerald-200"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-800">Manajemen Jenis Pengujian</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                            Pilih salah satu <strong>Pelajaran</strong> pada panel kiri untuk menampilkan atau mengelola daftar jenis pengujian yang tersedia.
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php CloseDb(); ?>