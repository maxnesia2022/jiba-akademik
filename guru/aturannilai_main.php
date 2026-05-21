<?php
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');
require_once('../library/dpupdate.php');

OpenDb();

// =========================================================================
// PENANGKAPAN PARAMETER
// =========================================================================
$nip = isset($_REQUEST['nip']) ? $_REQUEST['nip'] : '';
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : '';
$id_pelajaran = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

// =========================================================================
// PROSES AKSI (HAPUS)
// =========================================================================
if ($op == "xm8r389xemx23xb2378e23") {
    $idtingkat = $_REQUEST['idtingkat'];
    $aspek = $_REQUEST['aspek'];
	$sql = "DELETE FROM aturangrading WHERE idpelajaran = '$id_pelajaran' AND nipguru = '$nip' AND idtingkat = '$idtingkat' AND dasarpenilaian = '$aspek'"; 
	QueryDb($sql);	
    // Redirect to maintain state
    echo "<script>window.location.href='aturannilai_main.php?nip=$nip&nama=".urlencode($nama)."&id=$id_pelajaran';</script>";
    exit;
}

// Data Pelajaran & Guru (Jika Pelajaran dipilih)
$departemen_pel = "";
$pelajaran_name = "";
if (!empty($id_pelajaran) && !empty($nip)) {
    $sql_info = "SELECT j.departemen, j.nama FROM guru g, pelajaran j WHERE g.idpelajaran = j.replid AND j.replid = '$id_pelajaran' AND g.nip = '$nip'"; 
    $res_info = QueryDb($sql_info);
    if ($row_info = mysqli_fetch_array($res_info)) {
        $departemen_pel = $row_info['departemen'];
        $pelajaran_name = $row_info['nama'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aturan Penentuan Grading Nilai</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function caripegawai() {
        window.open('../library/guru.php?flag=0', 'CariPegawai','600','590','resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function acceptPegawai(nip, nama, flag) {
        window.location.href = "aturannilai_main.php?nip="+nip+"&nama="+encodeURIComponent(nama);
    }

    function pilih_pelajaran(id) {
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        window.location.href = "aturannilai_main.php?nip="+nip+"&nama="+nama+"&id="+id;
    }

    function edit_grading(idtingkat, aspek) {
        var id = "<?=$id_pelajaran?>";
        var nip = "<?=$nip?>";
        window.open('aturannilai_edit.php?idtingkat='+idtingkat+'&nip='+nip+'&aspek='+aspek+'&id='+id, 'UbahGrading','360','660','resizable=1,scrollbars=1');
    }

    function tambah_grading(tingkat) {
        var id = "<?=$id_pelajaran?>";
        var nip = "<?=$nip?>";
        window.open('aturannilai_add.php?idtingkat='+tingkat+'&id='+id+'&nip='+nip, 'TambahGrading','385','700','resizable=1,scrollbars=1');
    }

    function hapus_grading(idtingkat, aspek) {
        if (confirm("Apakah anda yakin akan menghapus aspek penilaian ini?")) {
            window.location.href = "aturannilai_main.php?op=xm8r389xemx23xb2378e23&nip=<?=$nip?>&nama=<?=urlencode($nama)?>&id=<?=$id_pelajaran?>&idtingkat="+idtingkat+"&aspek="+aspek;
        }
    }

    function cetak() {
        window.open('aturannilai_cetak.php?id=<?=$id_pelajaran?>&nip=<?=$nip?>', 'CetakGrading','790','650','resizable=1,scrollbars=1');
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
                    <i class="fa-solid fa-award text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Guru & Pelajaran</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">ATURAN GRADING NILAI</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Guru & Pelajaran</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Aturan Grading</span>
            </div>
        </div>

        <div class="flex-1 flex flex-col lg:flex-row gap-6 overflow-hidden">
            
            <!-- SIDEBAR: TEACHER & LESSON SELECTION -->
            <div class="lg:w-80 flex flex-col gap-6 flex-shrink-0">
                
                <!-- TEACHER SELECTION BOX -->
                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-emerald-600"></i> Pilih Guru
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">NIP</label>
                            <div class="flex gap-2">
                                <input type="text" id="nip_display" readonly class="bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-full cursor-pointer" placeholder="Klik Cari..." onClick="caripegawai()" value="<?=$nip?>">
                                <button onClick="caripegawai()" class="bg-emerald-50 text-emerald-700 p-2.5 rounded-xl hover:bg-emerald-100 transition-colors">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Nama Guru</label>
                            <input type="text" id="nama_display" readonly class="bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-full cursor-pointer" placeholder="Nama Guru..." onClick="caripegawai()" value="<?=$nama?>">
                        </div>
                    </div>
                </div>

                <!-- LESSON LIST (From aturannilai_menu.php) -->
                <div class="flex-1 bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="text-xs font-bold text-slate-600 uppercase tracking-widest">Pelajaran yang Diajar</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-4">
                        <?php
                        if (!empty($nip)) {
                            $sql_dep = "SELECT d.departemen FROM guru g, pelajaran p, departemen d WHERE g.idpelajaran = p.replid AND d.departemen = p.departemen AND g.nip ='$nip' GROUP BY d.departemen ORDER BY d.urutan";	
                            $res_dep = QueryDb($sql_dep);
                            if (mysqli_num_rows($res_dep) > 0) {
                                while ($row_dep = mysqli_fetch_row($res_dep)) {
                        ?>
                                <div class="space-y-2">
                                    <div class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest px-2"><?=$row_dep[0]?></div>
                                    <div class="space-y-1">
                                        <?php
                                        $sql_pel = "SELECT p.nama, p.replid FROM guru g, pelajaran p WHERE g.idpelajaran = p.replid AND g.nip='$nip' AND p.departemen = '$row_dep[0]' GROUP BY p.nama";	
                                        $res_pel = QueryDb($sql_pel);
                                        while ($row_pel = mysqli_fetch_array($res_pel)) {
                                            $is_active = ($id_pelajaran == $row_pel['replid']);
                                        ?>
                                        <button onclick="pilih_pelajaran('<?=$row_pel['replid']?>')" class="w-full text-left px-3 py-2.5 rounded-xl text-xs font-semibold transition-all <?= $is_active ? 'bg-emerald-900 text-white shadow-md' : 'text-slate-600 hover:bg-emerald-50 hover:text-emerald-700' ?>">
                                            <i class="fa-solid fa-book-bookmark mr-2 <?= $is_active ? 'text-emerald-300' : 'text-slate-300' ?>"></i>
                                            <?=$row_pel['nama']?>
                                        </button>
                                        <?php } ?>
                                    </div>
                                </div>
                        <?php 
                                }
                            } else {
                                echo '<div class="text-center py-10 px-4"><p class="text-xs text-slate-400 italic">Tidak ada pelajaran yang diajar oleh guru ini.</p></div>';
                            }
                        } else {
                            echo '<div class="text-center py-10 px-4"><i class="fa-solid fa-arrow-up text-emerald-100 text-3xl mb-2"></i><p class="text-xs text-slate-400 italic">Pilih guru terlebih dahulu untuk melihat daftar pelajaran.</p></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT: GRADING RULES (From aturannilai_content.php) -->
            <div class="flex-1 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
                <?php if (!empty($id_pelajaran) && !empty($nip)) { ?>
                    
                    <div class="p-6 md:p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                        <div>
                            <h3 class="text-xl font-extrabold text-slate-900"><?=$pelajaran_name?></h3>
                            <p class="text-xs text-emerald-600 font-semibold uppercase tracking-widest mt-1"><?=$departemen_pel?> &bull; <?=$nama?></p>
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

                    <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-8">
                        <?php
                        $sql_t = "SELECT tingkat, replid FROM tingkat WHERE departemen = '$departemen_pel' AND aktif=1 ORDER BY urutan";
                        $res_t = QueryDb($sql_t);
                        if (mysqli_num_rows($res_t) > 0) {
                            $has_data = false;
                            while ($row_t = mysqli_fetch_array($res_t)) {
                                $tingkat_id = $row_t['replid'];
                                $sql_aspek = "SELECT g.dasarpenilaian, dp.keterangan 
                                              FROM aturangrading g, tingkat t, dasarpenilaian dp
                                              WHERE t.replid = g.idtingkat AND t.departemen = '$departemen_pel' 
                                                AND g.dasarpenilaian = dp.dasarpenilaian AND dp.aktif = 1
                                                AND g.idpelajaran = '$id_pelajaran' AND g.idtingkat = '$tingkat_id' AND g.nipguru = '$nip' GROUP BY g.dasarpenilaian";
                                $res_aspek = QueryDb($sql_aspek);
                        ?>
                                <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
                                    <div class="flex justify-between items-center mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-900 text-white flex items-center justify-center font-bold shadow-lg shadow-emerald-900/20">
                                                <?=$row_t['tingkat']?>
                                            </div>
                                            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Tingkat <?=$row_t['tingkat']?></h4>
                                        </div>
                                        <button onclick="tambah_grading(<?=$tingkat_id?>)" class="bg-emerald-900 text-white px-4 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-emerald-800 transition-colors">
                                            <i class="fa-solid fa-plus mr-1"></i> Input Aturan
                                        </button>
                                    </div>

                                    <?php if (mysqli_num_rows($res_aspek) > 0) { $has_data = true; ?>
                                        <div class="overflow-hidden rounded-2xl border border-slate-100">
                                            <table class="min-w-full divide-y divide-slate-100 text-sm">
                                                <thead class="bg-slate-50">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aspek Penilaian</th>
                                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Grading (Skala Nilai)</th>
                                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-50">
                                                    <?php while ($row_a = mysqli_fetch_row($res_aspek)) { ?>
                                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                                            <td class="px-4 py-4 font-bold text-slate-700"><?=$row_a[1]?></td>
                                                            <td class="px-4 py-4">
                                                                <div class="flex flex-wrap gap-2">
                                                                    <?php
                                                                    $sql_g = "SELECT g.replid, grade, nmin, nmax
                                                                              FROM aturangrading g, tingkat t
                                                                              WHERE t.replid = g.idtingkat AND t.departemen = '$departemen_pel' 
                                                                                AND g.idpelajaran = '$id_pelajaran' AND g.idtingkat = '$tingkat_id' 
                                                                                AND g.dasarpenilaian = '$row_a[0]' AND g.nipguru = '$nip' ORDER BY grade";
                                                                    $res_g = QueryDb($sql_g);
                                                                    while ($row_g = mysqli_fetch_row($res_g)) {
                                                                        echo '<span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-100">';
                                                                        echo $row_g[1].' : '.$row_g[2].' - '.$row_g[3];
                                                                        echo '</span>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-4 text-center">
                                                                <div class="flex justify-center gap-2">
                                                                    <button onclick="edit_grading('<?=$tingkat_id?>','<?=$row_a[0]?>')" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Ubah">
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                    </button>
                                                                    <button onclick="hapus_grading('<?=$tingkat_id?>','<?=$row_a[0]?>')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <div class="py-10 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                            <p class="text-xs text-slate-400 italic">Belum ada aturan grading untuk tingkat ini.</p>
                                        </div>
                                    <?php } ?>
                                </div>
                        <?php 
                            }
                        } else {
                            echo '<div class="flex-1 flex flex-col items-center justify-center p-10"><i class="fa-solid fa-triangle-exclamation text-amber-200 text-5xl mb-4"></i><p class="text-slate-500 font-medium">Data tingkat belum diatur untuk departemen ini.</p></div>';
                        }
                        ?>
                    </div>

                <?php } else { ?>
                    <!-- BLANK STATE CONTENT -->
                    <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                        <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                            <i class="fa-solid fa-award text-5xl text-emerald-200"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-800">Aturan Perhitungan Grading Nilai</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                            Silakan pilih <strong>Guru</strong> dan <strong>Pelajaran</strong> pada panel kiri untuk menampilkan atau mengelola aturan grading nilai rapor.
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php CloseDb(); ?>