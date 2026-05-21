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
// PROSES AKSI (HAPUS & STATUS)
// =========================================================================
if ($op == "dw8dxn8w9ms8zs22") {
	$newaktif = (int)$_REQUEST['newaktif'];
	$replid = (int)$_REQUEST['replid'];
	$sql = "UPDATE aturannhb SET aktif = '$newaktif' WHERE replid = '$replid' ";
	QueryDb($sql);
    echo "<script>window.location.href='perhitungan_rapor.php?nip=$nip&nama=".urlencode($nama)."&id=$id_pelajaran';</script>";
    exit;
} 
elseif ($op == "xm8r389xemx23xb2378e23") {
    $idtingkat = $_REQUEST['id_tingkat'];
    $aspek = $_REQUEST['aspek'];
	$sql = "DELETE FROM aturannhb WHERE idpelajaran = '$id_pelajaran' AND nipguru = '$nip' AND idtingkat = '$idtingkat' AND dasarpenilaian = '$aspek'"; 
	QueryDb($sql);	
    echo "<script>window.location.href='perhitungan_rapor.php?nip=$nip&nama=".urlencode($nama)."&id=$id_pelajaran';</script>";
    exit;
}

// Data Pelajaran & Guru
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
    <title>Aturan Perhitungan Nilai Rapor</title>
    
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
        window.location.href = "perhitungan_rapor.php?nip="+nip+"&nama="+encodeURIComponent(nama);
    }

    function pilih_pelajaran(id) {
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        window.location.href = "perhitungan_rapor.php?nip="+nip+"&nama="+nama+"&id="+id;
    }

    function setaktif(replid, aktif) {
        var msg = (aktif == 1) ? "Apakah anda yakin akan mengubah bobot penilaian ini menjadi TIDAK AKTIF?" : "Apakah anda yakin akan mengubah bobot penilaian ini menjadi AKTIF?";
        var newaktif = (aktif == 1) ? 0 : 1;
        if (confirm(msg)) {
            window.location.href = "perhitungan_rapor.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&nip=<?=$nip?>&nama=<?=urlencode($nama)?>&id=<?=$id_pelajaran?>";
        }
    }

    function tambah(tingkat) {
        var id = "<?=$id_pelajaran?>";
        var nip = "<?=$nip?>";
        window.open('perhitungan_rapor_add.php?id_tingkat='+tingkat+'&id_pelajaran='+id+'&nip_guru='+nip, 'TambahPerhitungan','360','600','resizable=1,scrollbars=1');
    }

    function edit(tingkat, aspek) {
        var id = "<?=$id_pelajaran?>";
        var nip = "<?=$nip?>";
        window.open('perhitungan_rapor_edit.php?id_tingkat='+tingkat+'&id_pelajaran='+id+'&nip_guru='+nip+"&aspek="+aspek, 'UbahPerhitungan','360','600','resizable=1,scrollbars=1');
    }

    function hapus(tingkat, aspek) {
        if (confirm("Apakah anda yakin akan menghapus aspek penilaian ini?")) {
            window.location.href = "perhitungan_rapor.php?op=xm8r389xemx23xb2378e23&nip=<?=$nip?>&nama=<?=urlencode($nama)?>&id=<?=$id_pelajaran?>&id_tingkat="+tingkat+"&aspek="+aspek;
        }
    }

    function cetak() {
        window.open('perhitungan_rapor_cetak.php?id_pelajaran=<?=$id_pelajaran?>&nip_guru=<?=$nip?>', 'CetakPerhitungan','790','650','resizable=1,scrollbars=1');
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
                    <i class="fa-solid fa-calculator text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Guru & Pelajaran</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PERHITUNGAN RAPOR</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Guru & Pelajaran</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Perhitungan Rapor</span>
            </div>
        </div>

        <div class="flex-1 flex flex-col lg:flex-row gap-6 overflow-hidden">
            
            <!-- SIDEBAR -->
            <div class="lg:w-80 flex flex-col gap-6 flex-shrink-0">
                
                <!-- GURU SELECTION -->
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

                <!-- PELAJARAN LIST -->
                <div class="flex-1 bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="text-xs font-bold text-slate-600 uppercase tracking-widest">Pelajaran yang Diajar</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-4">
                        <?php
                        if (!empty($nip)) {
                            $sql_dep = "SELECT DISTINCT pel.departemen FROM pelajaran pel, guru g, departemen d WHERE g.nip='$nip' AND pel.replid=g.idpelajaran AND pel.departemen = d.departemen ORDER BY d.urutan";
                            $res_dep = QueryDb($sql_dep);
                            if (mysqli_num_rows($res_dep) > 0) {
                                while ($row_dep = mysqli_fetch_array($res_dep)) {
                        ?>
                                <div class="space-y-2">
                                    <div class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest px-2"><?=$row_dep['departemen']?></div>
                                    <div class="space-y-1">
                                        <?php
                                        $sql_pel = "SELECT pel.nama, pel.replid FROM pelajaran pel, guru g WHERE g.nip='$nip' AND pel.replid=g.idpelajaran AND pel.departemen='{$row_dep['departemen']}' GROUP BY pel.nama";	
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

            <!-- CONTENT -->
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
                        $sql_tkt = "SELECT tingkat, replid FROM tingkat WHERE departemen = '$departemen_pel' AND aktif=1 ORDER BY urutan";
                        $res_tkt = QueryDb($sql_tkt);
                        if (mysqli_num_rows($res_tkt) > 0) {
                            $cnt = 0;
                            while ($row_tkt = mysqli_fetch_array($res_tkt)) {
                                $tingkat_id = $row_tkt['replid'];
                                $sql_at = "SELECT a.dasarpenilaian, dp.keterangan
                                           FROM aturannhb a, tingkat t, dasarpenilaian dp 
                                           WHERE a.idtingkat='$tingkat_id' AND a.idpelajaran = '$id_pelajaran' AND t.departemen='$departemen_pel' 
                                             AND a.dasarpenilaian = dp.dasarpenilaian AND dp.aktif = 1
                                             AND t.replid = a.idtingkat AND a.nipguru = '$nip' GROUP BY a.dasarpenilaian";
                                $res_at = QueryDb($sql_at);
                        ?>
                                <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
                                    <div class="flex justify-between items-center mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-900 text-white flex items-center justify-center font-bold shadow-lg shadow-emerald-900/20">
                                                <?=$row_tkt['tingkat']?>
                                            </div>
                                            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Tingkat <?=$row_tkt['tingkat']?></h4>
                                        </div>
                                        <button onclick="tambah(<?=$tingkat_id?>)" class="bg-emerald-900 text-white px-4 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-emerald-800 transition-colors">
                                            <i class="fa-solid fa-plus mr-1"></i> Input Aturan
                                        </button>
                                    </div>

                                    <?php if (mysqli_num_rows($res_at) > 0) { ?>
                                        <div class="overflow-hidden rounded-2xl border border-slate-100">
                                            <table class="min-w-full divide-y divide-slate-100 text-sm">
                                                <thead class="bg-slate-50">
                                                    <tr>
                                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Aspek Penilaian</th>
                                                        <th class="px-4 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Bobot Perhitungan Rapor</th>
                                                        <th class="px-4 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-50">
                                                    <?php while ($row_at = mysqli_fetch_row($res_at)) { ?>
                                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                                            <td class="px-4 py-4 font-bold text-slate-700"><?=$row_at[1]?></td>
                                                            <td class="px-4 py-4">
                                                                <div class="flex flex-col gap-1">
                                                                    <?php
                                                                    $sql_ju = "SELECT j.jenisujian, a.bobot, a.aktif, a.replid 
                                                                               FROM aturannhb a, tingkat t, jenisujian j 
                                                                               WHERE a.idtingkat = '$tingkat_id' AND a.idpelajaran = '$id_pelajaran' AND j.replid = a.idjenisujian 
                                                                                 AND t.departemen = '$departemen_pel' AND a.dasarpenilaian = '$row_at[0]' AND a.nipguru = '$nip' 
                                                                                 AND t.replid = a.idtingkat";
                                                                    $res_ju = QueryDb($sql_ju);
                                                                    while ($row_ju = mysqli_fetch_row($res_ju)) {
                                                                    ?>
                                                                        <div class="flex items-center gap-2">
                                                                            <button onclick="setaktif(<?=$row_ju[3]?>, <?=$row_ju[2]?>)" class="transition-opacity hover:opacity-80">
                                                                                <i class="fa-solid <?= $row_ju[2] == 1 ? 'fa-toggle-on text-emerald-600' : 'fa-toggle-off text-slate-300' ?> text-lg"></i>
                                                                            </button>
                                                                            <span class="text-xs <?= $row_ju[2] == 1 ? 'text-slate-700 font-semibold' : 'text-slate-400 italic' ?>">
                                                                                <?=$row_ju[0]?> = <?=$row_ju[1]?>
                                                                            </span>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                            </td>
                                                            <td class="px-4 py-4 text-center">
                                                                <div class="flex justify-center gap-2">
                                                                    <button onclick="edit('<?=$tingkat_id?>','<?=$row_at[0]?>')" class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Ubah">
                                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                                    </button>
                                                                    <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                                                    <button onclick="hapus('<?=$tingkat_id?>','<?=$row_at[0]?>')" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
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
                                        <div class="py-10 text-center bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                            <p class="text-xs text-slate-400 italic">Belum ada aturan perhitungan rapor untuk tingkat ini.</p>
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
                            <i class="fa-solid fa-calculator text-5xl text-emerald-200"></i>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-800">Aturan Perhitungan Nilai Rapor</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                            Silakan pilih <strong>Guru</strong> dan <strong>Pelajaran</strong> pada panel kiri untuk mengelola bobot perhitungan nilai rapor.
                        </p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php CloseDb(); ?>