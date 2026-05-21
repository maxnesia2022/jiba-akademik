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
$tingkat = isset($_REQUEST['tingkat']) ? $_REQUEST['tingkat'] : '';
$tahunajaran = isset($_REQUEST['tahunajaran']) ? $_REQUEST['tahunajaran'] : '';
$kelas = isset($_REQUEST['kelas']) ? $_REQUEST['kelas'] : '';
$info_jadwal = isset($_REQUEST['info_jadwal']) ? $_REQUEST['info_jadwal'] : '';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : ''; // 'view' to show grid

// =========================================================================
// PROSES AKSI (HAPUS)
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
if ($op == "xm8r389xemx23xb2378e23") {
	$filter = isset($_REQUEST['field']) && $_REQUEST['field'] == 1 ? 'idkelas' : 'replid';
	$sql = "DELETE FROM jadwal WHERE $filter = '$_REQUEST[replid]' ";
	QueryDb($sql);
    echo "<script>window.location.href='jadwal_kelas_main.php?action=view&departemen=".urlencode($departemen)."&tahunajaran=$tahunajaran&tingkat=$tingkat&kelas=$kelas&info_jadwal=$info_jadwal';</script>";
    exit;
}

// =========================================================================
// HELPER FUNCTIONS & DATA LOADING
// =========================================================================
$jam_data = array();
$jadwal_data = array();
$maxJam = 0;

function loadJam($dep) {
    global $jam_data, $maxJam;
	$sql = "SELECT jamke, TIME_FORMAT(jam1, '%H:%i'), TIME_FORMAT(jam2, '%H:%i') FROM jam WHERE departemen = '$dep' ORDER BY jamke";
	$result = QueryDb($sql);
	$maxJam = mysqli_num_rows($result);
	while($row = mysqli_fetch_array($result)) {
		$jam_data[$row[0]]['jam1'] = $row[1];
		$jam_data[$row[0]]['jam2'] = $row[2];
	}
}

function loadJadwal($kelas_id, $dep, $info) {
    global $jadwal_data;
	$sql = "SELECT j.replid AS id, j.hari AS hari, j.jamke AS jam, j.njam AS njam, j.keterangan AS ket, l.nama AS pelajaran, p.nama AS guru, CASE j.status WHEN 0 THEN 'Mengajar' WHEN 1 THEN 'Asistensi' WHEN 2 THEN 'Tambahan' END AS status FROM jadwal j, pelajaran l, pegawai p WHERE j.idkelas = $kelas_id AND j.departemen = '$dep' AND j.infojadwal = $info AND j.nipguru = p.nip AND j.idpelajaran = l.replid";
	$result = QueryDb($sql);
	while($row = mysqli_fetch_assoc($result)) {
		$jadwal_data[$row['hari']][$row['jam']] = $row;
	}
}

$mask = array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0);

function getCell($r, $c) {
	global $mask, $jadwal_data;
	if($mask[$c] == 0) {
		if(isset($jadwal_data[$c][$r])) {
			$item = $jadwal_data[$c][$r];
			$mask[$c] = $item['njam'] - 1;
            $rowspan = $item['njam'];
			$s = "<td rowspan='$rowspan' class='p-2 border border-slate-200 text-center bg-white shadow-inner'>";
			$s .= "<div class='text-xs font-extrabold text-slate-900 leading-tight mb-1'>{$item['pelajaran']}</div>";
			$s .= "<div class='text-[10px] font-bold text-emerald-700 mb-1 tracking-tighter'>{$item['guru']}</div>";
			$s .= "<div class='text-[9px] text-slate-500 italic mb-2'>{$item['status']}</div>";
            if (!empty($item['ket'])) $s .= "<div class='text-[8px] text-slate-400 mb-2 truncate' title='{$item['ket']}'>{$item['ket']}</div>";
            $s .= "<div class='flex justify-center gap-1'>";
			$s .= "<button onclick='edit_jadwal({$item['id']})' class='p-1 text-amber-500 hover:bg-amber-50 rounded transition-colors'><i class='fa-solid fa-pen-to-square text-[10px]'></i></button>";
			$s .= "<button onclick='hapus_jadwal({$item['id']}, 0)' class='p-1 text-red-500 hover:bg-red-50 rounded transition-colors'><i class='fa-solid fa-trash-can text-[10px]'></i></button>";
			$s .= "</div></td>";
			return $s;
		} else {
			return "<td class='p-2 border border-slate-100 text-center bg-slate-50/30 group transition-colors hover:bg-emerald-50/50'><button onclick='tambah_jadwal($r, $c)' class='opacity-0 group-hover:opacity-100 p-1.5 text-emerald-500 hover:bg-emerald-100 rounded-full transition-all'><i class='fa-solid fa-plus text-xs'></i></button></td>";
		}
	} else {
		$mask[$c]--;
        return "";
	}
}

// Get Class and Level Info
$kelas_name = "";
if (!empty($kelas)) {
    $sql_k = "SELECT kelas FROM kelas WHERE replid = '$kelas'";
    $res_k = QueryDb($sql_k);
    if ($row_k = mysqli_fetch_array($res_k)) $kelas_name = $row_k['kelas'];
}

if ($action == 'view' && !empty($kelas) && !empty($departemen) && !empty($info_jadwal)) {
    loadJam($departemen);
    loadJadwal($kelas, $departemen, $info_jadwal);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kelas</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function change_filter() {
        var dep = document.getElementById("departemen").value;
        var ta = document.getElementById("tahunajaran").value;
        var tkt = document.getElementById("tingkat").value;
        var kl = document.getElementById("kelas").value;
        var info = document.getElementById("info_jadwal").value;
        window.location.href = "jadwal_kelas_main.php?departemen="+encodeURIComponent(dep)+"&tahunajaran="+ta+"&tingkat="+tkt+"&kelas="+kl+"&info_jadwal="+info;
    }

    function show_grid() {
        var dep = document.getElementById("departemen").value;
        var ta = document.getElementById("tahunajaran").value;
        var tkt = document.getElementById("tingkat").value;
        var kl = document.getElementById("kelas").value;
        var info = document.getElementById("info_jadwal").value;
        
        if (info == "") { alert('Info Jadwal tidak boleh kosong!'); return false; }
        if (tkt == "") { alert('Tingkat tidak boleh kosong!'); return false; }
        if (ta == "") { alert('Tahun Ajaran tidak boleh kosong!'); return false; }
        if (kl == "") { alert('Kelas tidak boleh kosong!'); return false; }
        
        window.location.href = "jadwal_kelas_main.php?action=view&departemen="+encodeURIComponent(dep)+"&tahunajaran="+ta+"&tingkat="+tkt+"&kelas="+kl+"&info_jadwal="+info;
    }

    function tambah_jadwal(jam, hari) {
        var dep = "<?=$departemen?>";
        var kl = "<?=$kelas?>";
        var info = "<?=$info_jadwal?>";
        var maxJam = "<?=$maxJam?>";
        window.open('jadwal_kelas_add.php?departemen='+dep+'&kelas='+kl+'&info='+info+'&maxJam='+maxJam+'&jam='+jam+'&hari='+hari, 'TambahJadwalKelas', '500', '455', 'resizable=1,scrollbars=1');
    }

    function edit_jadwal(replid) {
        var maxJam = "<?=$maxJam?>";
        window.open('jadwal_kelas_edit.php?maxJam='+maxJam+'&replid='+replid, 'UbahJadwalKelas','500','455','resizable=1,scrollbars=1');
    }

    function hapus_jadwal(replid, field) {
        var msg = (field == 1) ? "Hapus seluruh jadwal kelas ini?" : "Hapus jadwal ini?";
        if (confirm(msg)) {
            window.location.href = "jadwal_kelas_main.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&field="+field+"&departemen=<?=urlencode($departemen)?>&tahunajaran=<?=$tahunajaran?>&tingkat=<?=$tingkat?>&kelas=<?=$kelas?>&info_jadwal=<?=$info_jadwal?>";
        }
    }

    function cetak() {
        window.open('jadwal_kelas_cetak.php?departemen=<?=urlencode($departemen)?>&kelas=<?=$kelas?>&info=<?=$info_jadwal?>', 'CetakJadwalKelas', '800', '650', 'resizable=1,scrollbars=1');
    }

    function tambah_info() {
        window.open('info_jadwal.php?departemen=<?=urlencode($departemen)?>&tahunajaran=<?=$tahunajaran?>','InfoJadwal','600','425','resizable=1,scrollbars=1');
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
                    <i class="fa-solid fa-calendar-week text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Jadwal & Kalender</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">JADWAL KELAS</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Jadwal</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Jadwal Kelas</span>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                <!-- Departemen -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Departemen</label>
                    <select id="departemen" onChange="change_filter()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                        <?php 
                        $dep_list = getDepartemen(SI_USER_ACCESS());    
                        foreach($dep_list as $value) {
                            if ($departemen == "") $departemen = $value; 
                            $selected = ($value == $departemen) ? "selected" : "";
                            echo "<option value=\"$value\" $selected>$value</option>";
                        } ?>
                    </select>
                </div>

                <!-- Tahun Ajaran -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Tahun Ajaran</label>
                    <select id="tahunajaran" onChange="change_filter()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                        <?php
                        $sql_ta = "SELECT replid, tahunajaran, aktif FROM tahunajaran WHERE departemen='$departemen' ORDER BY replid DESC";
                        $res_ta = QueryDb($sql_ta);
                        while ($row_ta = mysqli_fetch_array($res_ta)) {
                            if ($tahunajaran == "") $tahunajaran = $row_ta['replid'];
                            $selected = ($row_ta['replid'] == $tahunajaran) ? "selected" : "";
                            echo "<option value=\"{$row_ta['replid']}\" $selected>{$row_ta['tahunajaran']}</option>";
                        } ?>
                    </select>
                </div>

                <!-- Tingkat -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Tingkat / Kelas</label>
                    <div class="flex gap-2">
                        <select id="tingkat" onChange="change_filter()" class="w-1/2 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <?php 
                            $sql_tkt = "SELECT replid, tingkat FROM tingkat WHERE departemen='$departemen' AND aktif = 1 ORDER BY urutan";
                            $res_tkt = QueryDb($sql_tkt);
                            while ($row_tkt = mysqli_fetch_array($res_tkt)) {
                                if ($tingkat == "") $tingkat = $row_tkt['replid'];
                                $selected = ($row_tkt['replid'] == $tingkat) ? "selected" : "";
                                echo "<option value=\"{$row_tkt['replid']}\" $selected>{$row_tkt['tingkat']}</option>";
                            } ?>
                        </select>
                        <select id="kelas" onChange="change_filter()" class="w-1/2 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <?php
                            $sql_kls = "SELECT replid, kelas FROM kelas WHERE idtahunajaran='$tahunajaran' AND idtingkat='$tingkat' ORDER BY kelas";
                            $res_kls = QueryDb($sql_kls);
                            while ($row_kls = mysqli_fetch_array($res_kls)) {
                                if ($kelas == "") $kelas = $row_kls['replid'];
                                $selected = ($row_kls['replid'] == $kelas) ? "selected" : "";
                                echo "<option value=\"{$row_kls['replid']}\" $selected>{$row_kls['kelas']}</option>";
                            } ?>
                        </select>
                    </div>
                </div>

                <!-- Info Jadwal -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Info Jadwal</label>
                    <div class="flex gap-2">
                        <select id="info_jadwal" onChange="change_filter()" class="flex-1 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <?php
                            $sql_ij = "SELECT replid, deskripsi, aktif FROM infojadwal WHERE idtahunajaran = '$tahunajaran' AND aktif=1 ORDER BY aktif DESC";
                            $res_ij = QueryDb($sql_ij);
                            while ($row_ij = mysqli_fetch_array($res_ij)) {
                                if ($info_jadwal == "") $info_jadwal = $row_ij['replid'];
                                $selected = ($row_ij['replid'] == $info_jadwal) ? "selected" : "";
                                $ada = $row_ij['aktif'] ? " (Aktif)" : "";
                                echo "<option value=\"{$row_ij['replid']}\" $selected>{$row_ij['deskripsi']}$ada</option>";
                            } ?>
                        </select>
                        <button onclick="tambah_info()" class="bg-emerald-900 text-white p-2.5 rounded-xl hover:bg-emerald-800 transition-colors" title="Tambah Info Jadwal"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>

                <!-- Action Button -->
                <div>
                    <button onclick="show_grid()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-eye"></i> TAMPILKAN JADWAL
                    </button>
                </div>
            </div>
        </div>

        <!-- GRID AREA -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
            <?php if ($action == 'view' && !empty($kelas)) { ?>
                
                <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Jadwal Kelas: <span class="text-emerald-700"><?=$kelas_name?></span></h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?=$departemen?> &bull; TA <?=$tahunajaran?></p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                        <button onclick="hapus_jadwal('<?=$kelas?>', 1)" class="bg-red-50 border border-red-100 text-red-600 px-5 py-2.5 rounded-2xl hover:bg-red-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-trash-can"></i> HAPUS SEMUA
                        </button>
                        <?php } ?>
                        <button onclick="cetak()" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-2.5 rounded-2xl hover:bg-emerald-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-print"></i> CETAK
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-auto p-4">
                    <?php if (!empty($jam_data)) { ?>
                        <div class="min-w-[1000px]">
                            <table class="w-full border-collapse border-spacing-0 table-fixed">
                                <thead>
                                    <tr class="bg-emerald-900 text-white text-[10px] font-bold uppercase tracking-widest">
                                        <th class="w-24 p-3 border border-emerald-800 text-center">Jam</th>
                                        <th class="p-3 border border-emerald-800 text-center">Senin</th>
                                        <th class="p-3 border border-emerald-800 text-center">Selasa</th>
                                        <th class="p-3 border border-emerald-800 text-center">Rabu</th>
                                        <th class="p-3 border border-emerald-800 text-center">Kamis</th>
                                        <th class="p-3 border border-emerald-800 text-center">Jumat</th>
                                        <th class="p-3 border border-emerald-800 text-center">Sabtu</th>
                                        <th class="p-3 border border-emerald-800 text-center">Minggu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $j_num = 1;
                                    foreach ($jam_data as $k => $v) { ?>
                                        <tr class="h-24">
                                            <td class="bg-slate-100 border border-slate-200 p-3 text-center">
                                                <div class="text-xs font-extrabold text-slate-800"><?=$j_num++?></div>
                                                <div class="text-[9px] text-slate-500 font-bold mt-1"><?=$v['jam1']?> - <?=$v['jam2']?></div>
                                            </td>
                                            <?php for($i = 1; $i <= 7; $i++) { echo getCell($k, $i); } ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <div class="h-full flex flex-col items-center justify-center p-16 text-center space-y-4">
                            <i class="fa-solid fa-clock text-5xl text-slate-200"></i>
                            <p class="text-slate-500 font-medium">Jam belajar belum diatur untuk departemen <?=$departemen?>.</p>
                            <a href="definisi_jam.php" class="text-emerald-700 font-bold hover:underline">Atur Jam Belajar &rarr;</a>
                        </div>
                    <?php } ?>
                </div>

            <?php } else { ?>
                <!-- BLANK STATE -->
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                    <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-calendar-week text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Manajemen Jadwal Kelas</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Silakan pilih <strong>Departemen, Tahun Ajaran, Tingkat, Kelas</strong> dan <strong>Info Jadwal</strong> untuk menampilkan dan mengelola jadwal pelajaran kelas.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>