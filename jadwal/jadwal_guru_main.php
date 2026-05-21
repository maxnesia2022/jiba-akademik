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
$nip = isset($_REQUEST['nip']) ? $_REQUEST['nip'] : '';
$nama = isset($_REQUEST['nama']) ? $_REQUEST['nama'] : '';
$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$tahunajaran = isset($_REQUEST['tahunajaran']) ? $_REQUEST['tahunajaran'] : '';
$info_jadwal = isset($_REQUEST['info_jadwal']) ? $_REQUEST['info_jadwal'] : '';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : ''; // 'view' to show grid

// =========================================================================
// PROSES AKSI (HAPUS)
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
if ($op == "xm8r389xemx23xb2378e23") {
	$filter = isset($_REQUEST['field']) && $_REQUEST['field'] == 1 ? 'nipguru' : 'replid';
	$sql = "DELETE FROM jadwal WHERE $filter = '$_REQUEST[replid]' ";
	QueryDb($sql);
    echo "<script>window.location.href='jadwal_guru_main.php?action=view&nip=$nip&nama=".urlencode($nama)."&departemen=".urlencode($departemen)."&tahunajaran=$tahunajaran&info_jadwal=$info_jadwal';</script>";
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

function loadJadwal($nip, $dep, $info) {
    global $jadwal_data;
	$sql = "SELECT j.replid AS id, j.hari AS hari, j.jamke AS jam, j.njam AS njam, j.keterangan AS ket, l.nama AS pelajaran, k.kelas, CASE j.status WHEN 0 THEN 'Mengajar' WHEN 1 THEN 'Asistensi' WHEN 2 THEN 'Tambahan' END AS status FROM jadwal j, pelajaran l, kelas k WHERE j.nipguru = '$nip' AND j.departemen = '$dep' AND j.infojadwal = $info AND j.idkelas = k.replid AND j.idpelajaran = l.replid";
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
			$s .= "<div class='text-[10px] font-bold text-emerald-700 mb-1 uppercase tracking-tighter'>{$item['kelas']}</div>";
			$s .= "<div class='text-xs font-extrabold text-slate-900 leading-tight mb-1'>{$item['pelajaran']}</div>";
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

if ($action == 'view' && !empty($nip) && !empty($departemen) && !empty($info_jadwal)) {
    loadJam($departemen);
    loadJadwal($nip, $departemen, $info_jadwal);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Guru</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function change_dep() {
        var dep = document.getElementById("departemen").value;
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        window.location.href = "jadwal_guru_main.php?departemen=" + encodeURIComponent(dep) + "&nip=" + nip + "&nama=" + nama;
    }

    function change_tahunajaran() {
        var dep = document.getElementById("departemen").value;
        var ta = document.getElementById("tahunajaran").value;
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        window.location.href = "jadwal_guru_main.php?departemen=" + encodeURIComponent(dep) + "&tahunajaran=" + ta + "&nip=" + nip + "&nama=" + nama;
    }

    function change_info() {
        var dep = document.getElementById("departemen").value;
        var ta = document.getElementById("tahunajaran").value;
        var info = document.getElementById("info_jadwal").value;
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        window.location.href = "jadwal_guru_main.php?departemen=" + encodeURIComponent(dep) + "&tahunajaran=" + ta + "&info_jadwal=" + info + "&nip=" + nip + "&nama=" + nama;
    }

    function pegawai() {
        window.open('../library/guru.php?flag=0', 'CariPegawai','600','590','resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function acceptPegawai(nip, nama, flag, dep) {
        window.location.href = "jadwal_guru_main.php?departemen="+dep+"&nip="+nip+"&nama="+encodeURIComponent(nama);
    }

    function show_grid() {
        var dep = document.getElementById("departemen").value;
        var ta = document.getElementById("tahunajaran").value;
        var info = document.getElementById("info_jadwal").value;
        var nip = "<?=$nip?>";
        var nama = "<?=urlencode($nama)?>";
        
        if (nip == "") { alert('Pilih Guru terlebih dahulu!'); return false; }
        if (ta == "") { alert('Pilih Tahun Ajaran!'); return false; }
        if (info == "") { alert('Pilih Info Jadwal!'); return false; }
        
        window.location.href = "jadwal_guru_main.php?action=view&departemen="+encodeURIComponent(dep)+"&tahunajaran="+ta+"&info_jadwal="+info+"&nip="+nip+"&nama="+nama;
    }

    function tambah_jadwal(jam, hari) {
        var nip = "<?=$nip?>";
        var info = "<?=$info_jadwal?>";
        var dep = "<?=$departemen?>";
        var ta = "<?=$tahunajaran?>";
        var maxJam = "<?=$maxJam?>";
        window.open('jadwal_guru_add.php?departemen='+dep+'&tahunajaran='+ta+'&nip='+nip+'&info='+info+'&maxJam='+maxJam+'&jam='+jam+'&hari='+hari, 'TambahJadwal', '500', '480', 'resizable=1,scrollbars=1');
    }

    function edit_jadwal(replid) {
        var maxJam = "<?=$maxJam?>";
        window.open('jadwal_guru_edit.php?maxJam='+maxJam+'&replid='+replid, 'UbahJadwal','500','480','resizable=1,scrollbars=1');
    }

    function hapus_jadwal(replid, field) {
        var msg = (field == 1) ? "Hapus seluruh jadwal guru ini?" : "Hapus jadwal ini?";
        if (confirm(msg)) {
            window.location.href = "jadwal_guru_main.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&field="+field+"&nip=<?=$nip?>&nama=<?=urlencode($nama)?>&departemen=<?=urlencode($departemen)?>&tahunajaran=<?=$tahunajaran?>&info_jadwal=<?=$info_jadwal?>";
        }
    }

    function cetak() {
        window.open('jadwal_guru_cetak.php?nip=<?=$nip?>&info=<?=$info_jadwal?>&departemen=<?=urlencode($departemen)?>', 'CetakJadwal','790', '650', 'resizable=1,scrollbars=1');
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
                    <i class="fa-solid fa-calendar-day text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Jadwal & Kalender</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">JADWAL GURU</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Jadwal</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Jadwal Guru</span>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                <!-- Guru Selection -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Guru</label>
                    <div class="flex gap-2">
                        <input type="text" readonly class="flex-1 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 cursor-pointer outline-none" placeholder="Pilih Guru..." onclick="pegawai()" value="<?= !empty($nip) ? "$nip - $nama" : "" ?>">
                        <button onclick="pegawai()" class="bg-emerald-50 text-emerald-700 p-2.5 rounded-xl hover:bg-emerald-100 transition-colors"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>

                <!-- Departemen & Tahun Ajaran -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Departemen / TA</label>
                    <div class="flex gap-2">
                        <select id="departemen" onChange="change_dep()" class="w-1/3 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <?php 
                            $dep_list = getDepartemen(SI_USER_ACCESS());    
                            foreach($dep_list as $value) {
                                if ($departemen == "") $departemen = $value; 
                                $selected = ($value == $departemen) ? "selected" : "";
                                echo "<option value=\"$value\" $selected>$value</option>";
                            } ?>
                        </select>
                        <select id="tahunajaran" onChange="change_tahunajaran()" class="w-2/3 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
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
                </div>

                <!-- Info Jadwal -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Info Jadwal</label>
                    <div class="flex gap-2">
                        <select id="info_jadwal" onChange="change_info()" class="flex-1 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <?php
                            $sql_ij = "SELECT i.replid, i.deskripsi, i.aktif FROM infojadwal i WHERE i.idtahunajaran = '$tahunajaran' AND i.aktif=1 ORDER BY i.aktif DESC";
                            $res_ij = QueryDb($sql_ij);
                            while ($row_ij = mysqli_fetch_array($res_ij)) {
                                if ($info_jadwal == "") $info_jadwal = $row_ij['replid'];
                                $selected = ($row_ij['replid'] == $info_jadwal) ? "selected" : "";
                                echo "<option value=\"{$row_ij['replid']}\" $selected>{$row_ij['deskripsi']}</option>";
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
            <?php if ($action == 'view' && !empty($nip)) { ?>
                
                <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Jadwal: <span class="text-emerald-700"><?=$nama?></span></h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?=$departemen?> &bull; TA <?=$tahunajaran?></p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                        <button onclick="hapus_jadwal('<?=$nip?>', 1)" class="bg-red-50 border border-red-100 text-red-600 px-5 py-2.5 rounded-2xl hover:bg-red-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
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
                        <i class="fa-solid fa-calendar-day text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Manajemen Jadwal Guru</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Pilih <strong>Guru, Departemen, Tahun Ajaran</strong> dan <strong>Info Jadwal</strong> untuk menampilkan dan mengelola jadwal mengajar.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>