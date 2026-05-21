<?php
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');
require_once('../library/dpupdate.php');
require_once('HitungRata.php');

OpenDb();

// =========================================================================
// PENANGKAPAN PARAMETER
// =========================================================================
$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$tingkat = isset($_REQUEST['tingkat']) ? $_REQUEST['tingkat'] : '';
$kelas = isset($_REQUEST['kelas']) ? $_REQUEST['kelas'] : '';
$tahunajaran = isset($_REQUEST['tahunajaran']) ? $_REQUEST['tahunajaran'] : '';
$semester = isset($_REQUEST['semester']) ? $_REQUEST['semester'] : '';
$nip = isset($_REQUEST['nip']) ? $_REQUEST['nip'] : '';
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : '';
$idaturan = isset($_REQUEST['idaturan']) ? $_REQUEST['idaturan'] : '';
$idpelajaran = isset($_REQUEST['idpelajaran']) ? $_REQUEST['idpelajaran'] : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// =========================================================================
// PROSES AKSI (HAPUS & HITUNG ULANG)
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
if ($op == "jfd84rkj843h834jjduw3") {
    $replid_ujian = $_REQUEST['replid_ujian'];
	BeginTrans();
	$success = true;
	$sql_hapus_nau = "DELETE FROM nau WHERE idaturan='$idaturan' AND idkelas = '$kelas' AND idsemester = '$semester'";
	QueryDbTrans($sql_hapus_nau, $success);
	if ($success) {
		$sql_hapus_nilai_ujian = "DELETE FROM nilaiujian WHERE idujian='$replid_ujian'";	
		QueryDbTrans($sql_hapus_nilai_ujian, $success);
	}
	if ($success) {
		$sql_hapus_ujian = "DELETE FROM ujian WHERE replid='$replid_ujian'";	
		QueryDbTrans($sql_hapus_ujian, $success);
	}
	if ($success) {
		$sql_hapus_ratauk = "DELETE FROM ratauk WHERE idujian = '$replid_ujian' AND idkelas = '$kelas' AND idsemester = '$semester'";
		QueryDbTrans($sql_hapus_ratauk, $success);
	}
	if ($success) HitungUlangRataSiswa($kelas, $semester, $idaturan, $success);
	if ($success) CommitTrans(); else RollbackTrans();
    echo "<script>window.location.href='lihat_nilai_pelajaran.php?action=view&departemen=".urlencode($departemen)."&tingkat=$tingkat&kelas=$kelas&tahunajaran=$tahunajaran&semester=$semester&nip=$nip&nama=".urlencode($nama)."&idaturan=$idaturan&idpelajaran=$idpelajaran';</script>";
    exit;
} else if ($op == "bwe24sssd2p24237lwi0234") {
	$success = true;
	BeginTrans();
	$sql = "SELECT nis FROM siswa WHERE idkelas='$kelas' AND aktif=1";
	$ressis = QueryDb($sql);
	while($success && ($rowsis = mysqli_fetch_row($ressis))) {
		$nis = $rowsis[0];
		HitungRataSiswa($kelas, $semester, $idaturan, $nis, $success);
	}
	$sql = "SELECT replid FROM ujian WHERE idkelas='$kelas' AND idsemester='$semester' AND idaturan='$idaturan'";
	$resuj = QueryDb($sql);
	while($success && ($rowuj = mysqli_fetch_row($resuj))) {
		$iduj = $rowuj[0];
		HitungRataKelasUjian($kelas, $semester, $idaturan, $iduj, $success);
	}
	if ($success) CommitTrans(); else RollbackTrans();
    echo "<script>window.location.href='lihat_nilai_pelajaran.php?action=view&departemen=".urlencode($departemen)."&tingkat=$tingkat&kelas=$kelas&tahunajaran=$tahunajaran&semester=$semester&nip=$nip&nama=".urlencode($nama)."&idaturan=$idaturan&idpelajaran=$idpelajaran';</script>";
    exit;
} else if ($op == "osdiui4903i03j490dj") {
	$sql_hapus_nau = "DELETE FROM nau WHERE idkelas='$kelas' AND idsemester='$semester' AND idaturan='$idaturan'";
	QueryDb($sql_hapus_nau);	
    echo "<script>window.location.href='lihat_nilai_pelajaran.php?action=view&departemen=".urlencode($departemen)."&tingkat=$tingkat&kelas=$kelas&tahunajaran=$tahunajaran&semester=$semester&nip=$nip&nama=".urlencode($nama)."&idaturan=$idaturan&idpelajaran=$idpelajaran';</script>";
    exit;
}

// Initial defaults
if ($departemen == "") { $dep_list = getDepartemen(SI_USER_ACCESS()); $departemen = $dep_list[0]; }
if ($tahunajaran == "") {
    $sql = "SELECT replid FROM tahunajaran WHERE departemen='$departemen' AND aktif=1 ORDER BY replid DESC LIMIT 1";
    $res = QueryDb($sql); if ($row = mysqli_fetch_array($res)) $tahunajaran = $row['replid'];
}
if ($semester == "") {
    $sql = "SELECT replid FROM semester where departemen='$departemen' AND aktif = 1 ORDER BY replid DESC LIMIT 1";
    $res = QueryDb($sql); if ($row = mysqli_fetch_array($res)) $semester = $row['replid'];
}
if ($tingkat == "") {
    $sql = "SELECT replid FROM tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan LIMIT 1";
    $res = QueryDb($sql); if ($row = mysqli_fetch_array($res)) $tingkat = $row['replid'];
}
if ($kelas == "" && $tahunajaran != "" && $tingkat != "") {
    $sql = "SELECT replid FROM kelas WHERE idtahunajaran='$tahunajaran' AND idtingkat='$tingkat' AND aktif = 1 ORDER BY kelas LIMIT 1";
    $res = QueryDb($sql); if ($row = mysqli_fetch_array($res)) $kelas = $row['replid'];
}

// Data for Sidebar
$namapel = ""; $pelajaran_id_db = ""; $aspekket = ""; $namajenis = ""; $idjenisujian = "";
if (!empty($idaturan)) {
    $sql = "SELECT p.nama, p.replid AS pelajaran, a.dasarpenilaian, j.jenisujian, j.replid AS jenis, dp.keterangan 
              FROM aturannhb a, pelajaran p, jenisujian j, dasarpenilaian dp 
             WHERE a.dasarpenilaian = dp.dasarpenilaian AND a.replid='$idaturan' AND p.replid = a.idpelajaran AND a.idjenisujian = j.replid";
    $res = QueryDb($sql);
    if ($row = mysqli_fetch_array($res)) {
        $namapel = $row['nama']; $pelajaran_id_db = $row['pelajaran']; $aspekket = $row['keterangan']; $namajenis = $row['jenisujian']; $idjenisujian = $row['jenis'];
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Nilai Pelajaran</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function change_dep() {
        var dep = document.getElementById("departemen").value;
        window.location.href = "lihat_nilai_pelajaran.php?departemen=" + encodeURIComponent(dep);
    }
    function change_filter() {
        var dep = document.getElementById("departemen").value;
        var tkt = document.getElementById("tingkat").value;
        var kl = document.getElementById("kelas").value;
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        window.location.href = "lihat_nilai_pelajaran.php?departemen="+encodeURIComponent(dep)+"&tingkat="+tkt+"&kelas="+kl+"&nip="+nip+"&nama="+nama;
    }
    function pegawai() {
        var dep = document.getElementById("departemen").value;
        window.open('../library/guru.php?flag=0&departemen='+encodeURIComponent(dep), 'CariPegawai','600','590','resizable=1,scrollbars=1');
    }
    function acceptPegawai(nip, nama, flag, dep) {
        var tkt = document.getElementById("tingkat").value;
        var kl = document.getElementById("kelas").value;
        window.location.href = "lihat_nilai_pelajaran.php?departemen="+dep+"&nip="+nip+"&nama="+encodeURIComponent(nama)+"&tingkat="+tkt+"&kelas="+kl;
    }
    function change_pel(idpel) {
        var dep = document.getElementById("departemen").value;
        var tkt = document.getElementById("tingkat").value;
        var kl = document.getElementById("kelas").value;
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        window.location.href = "lihat_nilai_pelajaran.php?departemen="+encodeURIComponent(dep)+"&tingkat="+tkt+"&kelas="+kl+"&nip="+nip+"&nama="+nama+"&idpelajaran="+idpel;
    }
    function show_content(idat) {
        var dep = document.getElementById("departemen").value;
        var tkt = document.getElementById("tingkat").value;
        var kl = document.getElementById("kelas").value;
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        var idpel = "<?=$idpelajaran?>";
        window.location.href = "lihat_nilai_pelajaran.php?action=view&departemen="+encodeURIComponent(dep)+"&tingkat="+tkt+"&kelas="+kl+"&nip="+nip+"&nama="+nama+"&idpelajaran="+idpel+"&idaturan="+idat;
    }
    function tambah_nilai() {
        window.open('nilai_pelajaran_add.php?idaturan=<?=$idaturan?>&semester=<?=$semester?>&kelas=<?=$kelas?>','TambahNilai','680','600','resizable=1,scrollbars=1');
    }
    function cetak_excel() {
        window.open('nilai_pelajaran_excel.php?semester=<?=$semester?>&kelas=<?=$kelas?>&idaturan=<?=$idaturan?>','CetakExcel','120','150','resizable=1,scrollbars=1');
    }
    function hitung_ulang() {
        if (confirm('Apakah anda akan menghitung ulang rata-rata kelas dan siswa?')) {
            window.location.href = "lihat_nilai_pelajaran.php?op=bwe24sssd2p24237lwi0234&idaturan=<?=$idaturan?>&kelas=<?=$kelas?>&semester=<?=$semester?>&departemen=<?=urlencode($departemen)?>&tingkat=<?=$tingkat?>&nip=<?=$nip?>&nama=<?=urlencode($nama)?>&idpelajaran=<?=$idpelajaran?>";
        }
    }
    function hapus_ujian(replid, i, jenis) {
        if (confirm('Anda yakin akan menghapus nilai '+jenis+'-'+i+' ini ?')) {
            window.location.href = "lihat_nilai_pelajaran.php?op=jfd84rkj843h834jjduw3&replid_ujian="+replid+"&idaturan=<?=$idaturan?>&kelas=<?=$kelas?>&semester=<?=$semester?>&departemen=<?=urlencode($departemen)?>&tingkat=<?=$tingkat?>&nip=<?=$nip?>&nama=<?=urlencode($nama)?>&idpelajaran=<?=$idpelajaran?>";
        }
    }
    function edit_ujian(replid) {
        window.open('ubah_ujian.php?replid='+replid,'UbahDataUjian','485','280','resizable=1,scrollbars=1');
    }
    function ubah_nilai(replid) {
        window.open('ubah_nilai_ujian.php?id='+replid,'UbahDataNilaiUjian','495','307','resizable=1,scrollbars=1');
    }
    function tambah_nilai_uj(iduj, nis) {
        window.open('tambah_nilai_ujian.php?idujian='+iduj+'&nis='+nis,'TambahDataNilaiUjian','495','310','resizable=1,scrollbars=1');
    }
    function ubah_nau(replid) {
        window.open('ubah_nau_persiswa.php?replid='+replid,'UbahNilaiAkhirUjian',447,252,'resizable=1,scrollbars=1');
    }
    function hapus_nau() {
        if (confirm('Anda yakin akan menghapus data nilai akhir ini?')) {
            window.location.href = "lihat_nilai_pelajaran.php?op=osdiui4903i03j490dj&idaturan=<?=$idaturan?>&kelas=<?=$kelas?>&semester=<?=$semester?>&departemen=<?=urlencode($departemen)?>&tingkat=<?=$tingkat?>&nip=<?=$nip?>&nama=<?=urlencode($nama)?>&idpelajaran=<?=$idpelajaran?>";
        }
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
                    <i class="fa-solid fa-book-open-reader text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Penilaian</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">LIHAT NILAI PELAJARAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Penilaian</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Nilai Pelajaran</span>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                <!-- Departemen & Kelas -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Departemen & Kelas</label>
                    <div class="flex gap-2">
                        <select id="departemen" onChange="change_dep()" class="w-1/3 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-2 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <?php $dep_list = getDepartemen(SI_USER_ACCESS()); foreach($dep_list as $v) { echo "<option value=\"$v\" ".StringIsSelected($v,$departemen).">$v</option>"; } ?>
                        </select>
                        <select id="tingkat" onChange="change_filter()" class="w-1/4 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-2 py-2.5 outline-none">
                            <?php $res_t = QueryDb("SELECT * FROM tingkat WHERE departemen='$departemen' AND aktif=1 ORDER BY urutan"); while($row_t = mysqli_fetch_array($res_t)) { echo "<option value=\"{$row_t['replid']}\" ".IntIsSelected($row_t['replid'],$tingkat).">{$row_t['tingkat']}</option>"; } ?>
                        </select>
                        <select id="kelas" onChange="change_filter()" class="w-1/3 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-2 py-2.5 outline-none">
                            <?php $res_k = QueryDb("SELECT * FROM kelas WHERE idtahunajaran='$tahunajaran' AND idtingkat='$tingkat' AND aktif=1 ORDER BY kelas"); while($row_k = mysqli_fetch_array($res_k)) { echo "<option value=\"{$row_k['replid']}\" ".IntIsSelected($row_k['replid'],$kelas).">{$row_k['kelas']}</option>"; } ?>
                        </select>
                    </div>
                </div>

                <!-- Tahun & Semester (Hidden but tracked) -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Tahun / Semester</label>
                    <div class="flex gap-2">
                        <input type="text" readonly class="w-1/2 bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-xl px-3 py-2.5" value="<?= @mysqli_fetch_row(QueryDb("SELECT tahunajaran FROM tahunajaran WHERE replid='$tahunajaran'"))[0] ?>">
                        <input type="text" readonly class="w-1/2 bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-xl px-3 py-2.5" value="<?= @mysqli_fetch_row(QueryDb("SELECT semester FROM semester WHERE replid='$semester'"))[0] ?>">
                    </div>
                </div>

                <!-- Guru Selection -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Guru</label>
                    <div class="flex gap-2">
                        <input type="text" readonly class="flex-1 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 cursor-pointer outline-none" placeholder="Pilih Guru..." onclick="pegawai()" value="<?= !empty($nip) ? "$nip - $nama" : "" ?>">
                        <button onclick="pegawai()" class="bg-emerald-50 text-emerald-700 p-2.5 rounded-xl hover:bg-emerald-100 transition-colors"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>

                <div>
                    <button onclick="window.location.reload()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-sync"></i> REFRESH DATA
                    </button>
                </div>
            </div>
        </div>

        <div class="flex-1 flex flex-col lg:flex-row gap-6 overflow-hidden">
            
            <!-- SIDEBAR: LESSONS & EXAM TYPES -->
            <div class="lg:w-80 flex flex-col gap-6 flex-shrink-0">
                <div class="flex-1 bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                        <h3 class="text-xs font-bold text-slate-600 uppercase tracking-widest">Pelajaran & Aspek</h3>
                    </div>
                    <div class="flex-1 overflow-y-auto p-4 space-y-4">
                        <?php if (!empty($nip)) {
                            $res_pel = QueryDb("SELECT DISTINCT a.idpelajaran, p.nama FROM aturannhb a, pelajaran p WHERE a.nipguru='$nip' AND a.idpelajaran=p.replid AND p.departemen='$departemen' AND a.idtingkat='$tingkat' AND a.aktif=1 ORDER BY p.nama");
                            if (mysqli_num_rows($res_pel) > 0) {
                                while ($row_pel = mysqli_fetch_array($res_pel)) {
                                    $is_active_pel = ($idpelajaran == $row_pel['idpelajaran'] || (empty($idpelajaran) && empty($idaturan)));
                                    if (empty($idpelajaran) && $is_active_pel) $idpelajaran = $row_pel['idpelajaran'];
                        ?>
                                    <div class="space-y-2">
                                        <button onclick="change_pel(<?=$row_pel['idpelajaran']?>)" class="w-full text-left px-3 py-2 rounded-xl text-xs font-extrabold uppercase transition-all <?= $is_active_pel ? 'bg-emerald-900 text-white shadow-md' : 'text-slate-600 hover:bg-emerald-50' ?>">
                                            <?=$row_pel['nama']?>
                                        </button>
                                        <?php if ($idpelajaran == $row_pel['idpelajaran']) { ?>
                                            <div class="ml-4 space-y-3 border-l-2 border-emerald-100 pl-3 py-1">
                                                <?php
                                                $res_aspek = QueryDb("SELECT DISTINCT a.dasarpenilaian, dp.keterangan FROM aturannhb a, dasarpenilaian dp WHERE a.idpelajaran='$idpelajaran' AND a.dasarpenilaian=dp.dasarpenilaian AND dp.aktif=1 AND a.idtingkat='$tingkat' AND a.nipguru='$nip' ORDER BY dp.keterangan");
                                                while ($row_as = mysqli_fetch_array($res_aspek)) {
                                                ?>
                                                    <div class="space-y-1">
                                                        <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest"><?=$row_as['keterangan']?></div>
                                                        <?php
                                                        $res_jp = QueryDb("SELECT a.replid, j.jenisujian FROM aturannhb a, jenisujian j WHERE a.idpelajaran='$idpelajaran' AND a.dasarpenilaian='{$row_as['dasarpenilaian']}' AND a.idjenisujian=j.replid AND a.idtingkat='$tingkat' AND a.nipguru='$nip' ORDER BY j.jenisujian");
                                                        while ($row_jp = mysqli_fetch_array($res_jp)) {
                                                            $is_active_at = ($idaturan == $row_jp['replid']);
                                                        ?>
                                                            <button onclick="show_content(<?=$row_jp['replid']?>)" class="w-full text-left px-2 py-1.5 rounded-lg text-[11px] font-semibold transition-all <?= $is_active_at ? 'text-emerald-700 bg-emerald-50 font-bold underline' : 'text-slate-500 hover:text-emerald-600' ?>">
                                                                &bull; <?=$row_jp['jenisujian']?>
                                                            </button>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                        <?php 
                                }
                            } else { echo '<p class="text-xs text-slate-400 italic text-center p-4">Tidak ada aturan perhitungan rapor.</p>'; }
                        } else { echo '<p class="text-xs text-slate-400 italic text-center p-4">Pilih Guru terlebih dahulu.</p>'; }
                        ?>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT: GRADE TABLE -->
            <div class="flex-1 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
                <?php if (!empty($idaturan)) { ?>
                    <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                        <div>
                            <h3 class="text-lg font-bold text-slate-800"><?=$namajenis?> &bull; <?=$namapel?></h3>
                            <p class="text-[10px] text-emerald-600 font-bold uppercase tracking-widest"><?=$aspekket?> &bull; <?=$nama?></p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="cetak_excel()" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-2 rounded-xl hover:bg-emerald-100 font-bold text-xs flex items-center gap-2 transition-all"><i class="fa-solid fa-file-excel"></i> EXCEL</button>
                            <button onclick="tambah_nilai()" class="bg-emerald-900 text-white px-4 py-2 rounded-xl hover:bg-emerald-800 font-bold text-xs flex items-center gap-2 transition-all"><i class="fa-solid fa-plus"></i> TAMBAH</button>
                        </div>
                    </div>

                    <div class="flex-1 overflow-auto p-6">
                        <?php
                        $res_uj = QueryDb("SELECT replid, tanggal, deskripsi, idrpp FROM ujian WHERE idaturan='$idaturan' AND idkelas='$kelas' AND idsemester='$semester' ORDER BY tanggal ASC");
                        $jumlahujian = mysqli_num_rows($res_uj);
                        if ($jumlahujian > 0) {
                            $uj_headers = array();
                            $uj_ids = array();
                            while ($row_uj = mysqli_fetch_array($res_uj)) { $uj_headers[] = $row_uj; $uj_ids[] = $row_uj['replid']; }
                        ?>
                            <div class="overflow-x-auto rounded-2xl border border-slate-100">
                                <table class="min-w-full divide-y divide-slate-100 text-sm">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th rowspan="2" class="px-3 py-3 text-center text-[10px] font-bold text-slate-400 uppercase w-10">No</th>
                                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-bold text-slate-400 uppercase w-24">NIS</th>
                                            <th rowspan="2" class="px-3 py-3 text-left text-[10px] font-bold text-slate-400 uppercase">Nama Siswa</th>
                                            <th colspan="<?=count($uj_headers)?>" class="px-3 py-2 text-center text-[9px] font-bold text-slate-500 uppercase bg-slate-100/50">Ujian / Ulangan</th>
                                            <th rowspan="2" class="px-3 py-3 text-center text-[10px] font-bold text-slate-400 uppercase w-16">Rata</th>
                                            <th rowspan="2" class="px-3 py-3 text-center text-[10px] font-bold text-slate-400 uppercase w-16">NA</th>
                                        </tr>
                                        <tr class="bg-slate-50/50">
                                            <?php foreach ($uj_headers as $idx => $h) { 
                                                $rpp_name = !empty($h['idrpp']) ? @mysqli_fetch_row(QueryDb("SELECT rpp FROM rpp WHERE replid='{$h['idrpp']}'"))[0] : "Tanpa RPP";
                                            ?>
                                                <th class="px-2 py-2 text-center group relative cursor-help">
                                                    <div class="text-[8px] font-extrabold text-emerald-700"><?=$namajenis?>-<?=($idx+1)?></div>
                                                    <div class="text-[7px] text-slate-400"><?=date('d/m/y', strtotime($h['tanggal']))?></div>
                                                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-32 p-2 bg-slate-800 text-white text-[8px] rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50">RPP: <?=$rpp_name?><br>Materi: <?=$h['deskripsi']?></div>
                                                    <div class="flex justify-center gap-1 mt-1">
                                                        <button onclick="edit_ujian(<?=$h['replid']?>)" class="text-amber-500 hover:text-amber-700"><i class="fa-solid fa-pen text-[8px]"></i></button>
                                                        <button onclick="hapus_ujian(<?=$h['replid']?>, <?=($idx+1)?>, '<?=$namajenis?>')" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash text-[8px]"></i></button>
                                                    </div>
                                                </th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50 bg-white">
                                        <?php
                                        $res_sis = QueryDb("SELECT * FROM siswa WHERE idkelas='$kelas' AND aktif=1 AND alumni=0 ORDER BY nama ASC");
                                        $cnt = 0; $jumsiswa = mysqli_num_rows($res_sis);
                                        $nilaiujian_total = array_fill(0, count($uj_ids), 0);
                                        while ($row_sis = mysqli_fetch_array($res_sis)) {
                                        ?>
                                            <tr class="hover:bg-slate-50/50">
                                                <td class="px-3 py-3 text-center text-slate-400 font-bold"><?=++$cnt?></td>
                                                <td class="px-3 py-3 font-mono text-[10px] text-slate-500"><?=$row_sis['nis']?></td>
                                                <td class="px-3 py-3 font-bold text-slate-800 truncate"><?=$row_sis['nama']?></td>
                                                <?php foreach ($uj_ids as $jidx => $ujid) { 
                                                    $res_nv = QueryDb("SELECT * FROM nilaiujian WHERE idujian='$ujid' AND nis='{$row_sis['nis']}'");
                                                    if ($row_nv = mysqli_fetch_array($res_nv)) {
                                                        $nilaiujian_total[$jidx] += $row_nv['nilaiujian'];
                                                        echo "<td class='px-2 py-3 text-center'><button onclick='ubah_nilai({$row_nv['replid']})' class='font-bold text-emerald-700 hover:underline'>{$row_nv['nilaiujian']}</button>".($row_nv['keterangan']!=""?"<span class='text-blue-500 text-[8px]'>*</span>":"")."</td>";
                                                    } else {
                                                        echo "<td class='px-2 py-3 text-center'><button onclick='tambah_nilai_uj($ujid, \"{$row_sis['nis']}\")' class='text-emerald-300 hover:text-emerald-500'><i class='fa-solid fa-plus-circle'></i></button></td>";
                                                    }
                                                } ?>
                                                <td class="px-2 py-3 text-center font-bold text-slate-600"><?php GetRataSiswa2($pelajaran_id_db, $idjenisujian, $kelas, $semester, $idaturan, $row_sis['nis']); ?></td>
                                                <td class="px-2 py-3 text-center font-extrabold text-emerald-900 bg-emerald-50/30">
                                                    <?php $res_nau = QueryDb("SELECT * FROM nau WHERE nis='{$row_sis['nis']}' AND idkelas='$kelas' AND idsemester='$semester' AND idaturan='$idaturan'");
                                                    if ($row_nau = mysqli_fetch_array($res_nau)) {
                                                        if ($row_nau['nilaiAU'] != 0) echo "<button onclick='ubah_nau({$row_nau['replid']})' class='hover:underline'>{$row_nau['nilaiAU']}</button>".($row_nau['keterangan']!=""?"<span class='text-green-600 text-[8px]'>*</span>":"").($row_nau['info1']=='1'?"<span class='text-blue-500 text-[8px]'>*</span>":"");
                                                        else echo "-";
                                                    } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <tr class="bg-slate-100/50 font-extrabold text-slate-800">
                                            <td colspan="3" class="px-3 py-2 text-right uppercase text-[9px]">Rata-rata Kelas</td>
                                            <?php $rata_kelas_total = 0; foreach ($uj_ids as $jidx => $ujid) { 
                                                $rk = GetRataKelas($kelas, $semester, $ujid); $rata_kelas_total += $rk;
                                                echo "<td class='px-2 py-2 text-center text-emerald-700'>$rk</td>";
                                            } ?>
                                            <td class="px-2 py-2 text-center text-slate-600"><?= count($uj_ids)>0 ? round($rata_kelas_total/count($uj_ids), 2) : 0 ?></td>
                                            <td class="px-2 py-2 text-center text-emerald-900"><?php $res_avg_nau = QueryDb("SELECT SUM(nilaiAU)/$jumsiswa FROM nau WHERE idkelas='$kelas' AND idsemester='$semester' AND idaturan='$idaturan'"); if ($row_avg = mysqli_fetch_row($res_avg_nau)) echo round($row_avg[0],2); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4 flex flex-col sm:flex-row justify-between items-center gap-4 text-[9px] font-bold">
                                <div class="flex gap-4">
                                    <span class="text-blue-500">*) Perubahan nilai akhir individual</span>
                                    <span class="text-green-600">*) Nilai Akhir dihitung manual</span>
                                </div>
                                <button onclick="hitung_ulang()" class="bg-slate-800 text-white px-4 py-2 rounded-xl hover:bg-slate-700 transition-colors uppercase tracking-widest"><i class="fa-solid fa-calculator mr-2"></i> Hitung Ulang Rata-rata</button>
                            </div>
                        <?php } else { ?>
                            <div class="flex flex-col items-center justify-center p-16 text-center space-y-4 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                                <i class="fa-solid fa-folder-open text-5xl text-slate-200"></i>
                                <p class="text-slate-500 font-medium">Belum ada data nilai ujian untuk pengujian ini.</p>
                                <button onclick="tambah_nilai()" class="bg-emerald-900 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-emerald-800 transition-colors"><i class="fa-solid fa-plus mr-1"></i> Tambah Data Baru</button>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                        <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4"><i class="fa-solid fa-book-open-reader text-5xl text-emerald-200"></i></div>
                        <h3 class="text-xl font-extrabold text-slate-800">Manajemen Nilai Pelajaran</h3>
                        <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">Pilih <strong>Guru, Pelajaran,</strong> dan <strong>Jenis Pengujian</strong> pada filter untuk mengelola nilai siswa.</p>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>