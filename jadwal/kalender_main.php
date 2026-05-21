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
$kalender = isset($_REQUEST['kalender']) ? $_REQUEST['kalender'] : '';
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// Calendar View State
$bln = isset($_REQUEST['bln']) ? $_REQUEST['bln'] : 0;
$thn = isset($_REQUEST['thn']) ? $_REQUEST['thn'] : 0;
$prevbln = isset($_REQUEST['prevbln']) ? $_REQUEST['prevbln'] : 0;
$prevthn = isset($_REQUEST['prevthn']) ? $_REQUEST['prevthn'] : 0;
$next = isset($_REQUEST['next']) ? $_REQUEST['next'] : 0;
$last = 0;

// =========================================================================
// PROSES AKSI (HAPUS)
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
if ($op == "xm8r389xemx23xb2378e23") {
    $replid = $_REQUEST['replid_keg'];
	$sql = "DELETE FROM aktivitaskalender WHERE replid = '$replid'";	
	QueryDb($sql);
    echo "<script>window.location.href='kalender_main.php?action=view&departemen=".urlencode($departemen)."&kalender=$kalender&bln=$bln&thn=$thn&next=$next&prevbln=$prevbln&prevthn=$prevthn';</script>";
    exit;
}

// =========================================================================
// CALENDAR RENDERING LOGIC
// =========================================================================
$color = array(array("#FD0000","#FFCCCC"),array("#339900","#DFEFDF"),array("#5E5CB5","#C7C6EA"),array("#FF7200","#FCCAA0"),array("#F100C1","#f2ade4"),array("#009F79","#9DD7CB"),array("#8900FE","#DDC1F4"),array("#0080B0","#9CC2D1"),array("#FF9933","#FFFF99"),array("#007F00","#C1E6AC"),array("#990000","#FF8e8e"),array("#0057B9","#8aaed6"));

$keg_data = array();
$jadwal_data = array();

function loadKalender1($id_kal) {
    global $keg_data;
	$sql = "SELECT replid, kegiatan, tanggalawal, tanggalakhir FROM aktivitaskalender WHERE idkalender = '$id_kal' ORDER BY tanggalawal"; 
	$result = QueryDb($sql);
	$i = 0;	
	while($row = mysqli_fetch_row($result)) {		
		$tgl1 = explode('-',$row[2]);
		$tgl2 = explode('-',$row[3]);
		$awal = $tgl1[2].'/'.$tgl1[1].'/'.substr($tgl1[0],2,2).' - '.$tgl2[2].'/'.$tgl2[1].'/'.substr($tgl2[0],2,2);
		$keg_data[$i]['id'] = $row[0];
		$keg_data[$i]['judul'] = $row[1];
		$keg_data[$i]['tanggal'] = $awal;
		$i++;
	}
}

function loadKalender2($id_kal, $bulan1, $tahun1, $bulan2, $tahun2) {
    global $keg_data, $jadwal_data;
	$batastgl1 = $tahun1."-".$bulan1."-1";
	$batastgl2 = $tahun2."-".$bulan2."-31";
	$sql = "SELECT replid, kegiatan, tanggalawal, tanggalakhir, MONTH(tanggalawal), MONTH(tanggalakhir), DAY(tanggalawal), DAY(tanggalakhir), YEAR(tanggalawal), YEAR(tanggalakhir) FROM aktivitaskalender WHERE idkalender = '$id_kal' AND (('$batastgl1' BETWEEN tanggalawal AND tanggalakhir) OR ('$batastgl2' BETWEEN tanggalawal AND tanggalakhir) OR (tanggalawal BETWEEN '$batastgl1' AND '$batastgl2') OR (tanggalakhir BETWEEN '$batastgl1' AND '$batastgl2')) ORDER BY tanggalawal";  
	$result = QueryDb($sql);
	while($row = mysqli_fetch_row($result)) {
		$awal = ($row[6] <= 7) ? 1 : ( (7 < $row[6] && $row[6] <= 14) ? 2 : ( (14 < $row[6] && $row[6] <= 21) ? 3 : 4 ) );
		$akhir = ($row[7] <= 7) ? 1 : ( (7 < $row[7] && $row[7] <= 14) ? 2 : ( (14 < $row[7] && $row[7] <= 21) ? 3 : 4 ) );
		$blnawal = $row[4];			
		if ($blnawal < $bulan1) {
			if ($row[9] == $tahun2 && $row[8] <> $tahun2) { $blnawal = $bulan1; $awal = 1; } 
			else if ($row[9] == $tahun1 && $row[8] == $tahun1) { $blnawal = $bulan1; $awal = 1; }
			else if ($row[9] == $tahun2 && $row[8] == $tahun2 && $tahun1 <> $tahun2) { $blnawal = $row[4] + 12; }
		} 
		if ($row[9] == $tahun1 || $row[9] == $tahun2) {			
			$blnakhir = $row[5];
			if ($row[5] < $bulan1) $blnakhir = $row[5] + 12;
			if ($row[8] <> $tahun1 && $row[8] <> $tahun2) { $blnakhir = $row[5]; $blnawal = $bulan1; $awal = 1; }
		} else {
			$blnakhir = $bulan1 + 5;
			if ($row[8] == $tahun1 && $row[9] <> $tahun2) $akhir = 4;
		}
		$kolom = ($blnawal-$bulan1)*4+$awal;
		$selisih = (($blnakhir-$bulan1)*4+$akhir-$kolom)+1;
		$tanggal = $row[6].'/'.$row[4].'/'.substr($row[8],2,2).' - '.$row[7].'/'.$row[5].'/'.substr($row[9],2,2);
		if ($selisih <= 0) { $selisih = 1; $tanggal = $row[6].'/'.$row[4]; } 
		$baris = -1;
		for ($j=0; $j<count($keg_data); $j++) { if ($keg_data[$j]['id'] == $row[0]) $baris = $j; }	
		$jadwal_data[$row[0]][$baris][$kolom]['njam'] = $selisih;
		$jadwal_data[$row[0]][$baris][$kolom]['awal'] = $tanggal;
	}
}

$mask = array();

function getCell1($r, $c, $id, $m) {
	global $mask, $jadwal_data, $color;	
    if (!isset($mask[$c])) $mask[$c] = 0;
	if($mask[$c] == 0) {
		if(isset($jadwal_data[$id][$r][$c])) {	
			$mask[$c+1] = $jadwal_data[$id][$r][$c]['njam'] - 1;
			$dt=explode("-",$jadwal_data[$id][$r][$c]['awal']);
			$dt1=explode("/",$dt[0]);
			$dt2=isset($dt[1]) ? explode("/",$dt[1]) : array("","");
            $disp_tgl = trim($dt1[0]) . (isset($dt2[0]) && !empty($dt2[0]) ? " - ".trim($dt2[0]) : "");
			$s = "<td align='center' valign='middle' style='background-color: {$color[$m][1]}' colspan='{$jadwal_data[$id][$r][$c]['njam']}' class='border border-slate-200 p-2 shadow-inner'>";
			$s.= "<div class='text-[10px] font-extrabold text-slate-800 mb-2'>$disp_tgl</div>";
			$s.= "<div class='flex justify-center gap-1'>";
			$s.= "<button onclick='lihat_keg($id)' class='p-1 text-blue-500 hover:bg-blue-100 rounded'><i class='fa-solid fa-eye text-[10px]'></i></button>";
			$s.= "<button onclick='edit_keg($id)' class='p-1 text-amber-500 hover:bg-amber-100 rounded'><i class='fa-solid fa-pen-to-square text-[10px]'></i></button>";
			$s.= "<button onclick='hapus_keg($id)' class='p-1 text-red-500 hover:bg-red-100 rounded'><i class='fa-solid fa-trash-can text-[10px]'></i></button>";
            $s.= "</div></td>";
			return $s;
		} else {			
			$mask[$c+1] = 0;			
			return "<td class='bg-slate-50 border border-slate-100'></td>";
		}
	} else {
		$mask[$c+1] = $mask[$c]-1;	
        return "";
	}
}

// Initial Data for Filter
$periode = "";
if (!empty($kalender)) {
    $sql_p = "SELECT * FROM tahunajaran t, kalenderakademik k WHERE t.replid=k.idtahunajaran AND k.replid = '$kalender'";
    $res_p = QueryDb($sql_p);
    if ($row_p = mysqli_fetch_array($res_p)) {
        $periode = format_tgl($row_p['tglmulai']).' s/d '.format_tgl($row_p['tglakhir']);
        if ($action == 'view') {
            $bulan1_orig = (int)date('n', strtotime($row_p['tglmulai']));
            $tahun1_orig = (int)date('Y', strtotime($row_p['tglmulai']));
            $bulan2_orig = (int)date('n', strtotime($row_p['tglakhir']));
            $tahun2_orig = (int)date('Y', strtotime($row_p['tglakhir']));
            if ($bln == 0) { $bln = $bulan1_orig; $thn = $tahun1_orig; $prevbln = $bulan1_orig; $prevthn = $tahun1_orig; }
            $tahun = $thn; $bul_end = $bln + 5;
            if ($bln > 6) { $bul_end = ($bln + 5) - 12; $tahun = $thn + 1; }
            if ($bul_end >= $bulan2_orig && $tahun >= $tahun2_orig) $last = 1;
            if ($bln == $bulan1_orig && $thn == $tahun1_orig) $next = 0;
            loadKalender1($kalender);
            loadKalender2($kalender, $bln, $thn, $bul_end, $tahun);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Akademik</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript">
    function change_dep() {
        var dep = document.getElementById("departemen").value;
        window.location.href = "kalender_main.php?departemen=" + encodeURIComponent(dep);
    }

    function change_kal() {
        var dep = document.getElementById("departemen").value;
        var kal = document.getElementById("kalender").value;
        window.location.href = "kalender_main.php?departemen=" + encodeURIComponent(dep) + "&kalender=" + kal;
    }

    function show_kal() {
        var dep = document.getElementById("departemen").value;
        var kal = document.getElementById("kalender").value;
        if (kal == "") { alert('Pilih Kalender terlebih dahulu!'); return false; }
        window.location.href = "kalender_main.php?action=view&departemen=" + encodeURIComponent(dep) + "&kalender=" + kal;
    }

    function tambah_keg() {
        var kal = "<?=$kalender?>";
        window.open('kegiatan_add.php?kalender='+kal, 'TambahKegiatan', '650','655', 'resizable=1,scrollbars=1');
    }

    function edit_keg(replid) {	
        window.open('kegiatan_edit.php?replid='+replid, 'UbahKegiatan','650','650','resizable=1,scrollbars=1');
    }

    function lihat_keg(replid) {	
        window.open('kalender_detail.php?replid='+replid, 'DetailKegiatan','750','700','resizable=1,scrollbars=1');
    }

    function hapus_keg(replid) {
        if (confirm("Apakah anda yakin akan menghapus kegiatan ini?")) {
            window.location.href = "kalender_main.php?op=xm8r389xemx23xb2378e23&replid_keg="+replid+"&kalender=<?=$kalender?>&departemen=<?=urlencode($departemen)?>&bln=<?=$bln?>&thn=<?=$thn?>&next=<?=$next?>&prevbln=<?=$prevbln?>&prevthn=<?=$prevthn?>";
        }
    }

    function GoToNextMonth() {	
        var nextbln = document.getElementById('nextbln').value;
        var nextthn = document.getElementById('nextthn').value;
        window.location.href = "kalender_main.php?action=view&kalender=<?=$kalender?>&departemen=<?=urlencode($departemen)?>&bln="+nextbln+"&thn="+nextthn+"&next=1&prevbln=<?=$bln?>&prevthn=<?=$thn?>";
    }

    function GoToPrevMonth() {	
        var prevbln = document.getElementById('prevbln').value;
        var prevthn = document.getElementById('prevthn').value;
        window.location.href = "kalender_main.php?action=view&kalender=<?=$kalender?>&departemen=<?=urlencode($departemen)?>&bln="+prevbln+"&thn="+prevthn+"&next=1";
    }

    function cetak() {
        window.open('kalender_cetak.php?kalender=<?=$kalender?>&bln=<?=$bln?>&thn=<?=$thn?>&next=0&last=<?=$last?>', 'CetakKalender', '800', '650', 'resizable=1,scrollbars=1');
    }

    function tambah_kal() {
        window.open('daftar_kalender.php?departemen=<?=urlencode($departemen)?>','KalenderAkademik','600','425','resizable=1,scrollbars=1');
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
                    <i class="fa-solid fa-calendar-alt text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Jadwal & Kalender</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">KALENDER AKADEMIK</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Kalender</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Kalender Akademik</span>
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

                <!-- Kalender Selection -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Kalender Akademik</label>
                    <div class="flex gap-2">
                        <select id="kalender" onChange="change_kal()" class="flex-1 bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                            <?php
                            $sql_k = "SELECT * FROM kalenderakademik WHERE departemen='$departemen' ORDER BY aktif DESC, replid ASC";
                            $res_k = QueryDb($sql_k);
                            while ($row_k = mysqli_fetch_array($res_k)) {
                                if ($kalender == "") $kalender = $row_k['replid'];
                                $ada = $row_k['aktif'] ? " (Aktif)" : "";
                                $selected = ($row_k['replid'] == $kalender) ? "selected" : "";
                                echo "<option value=\"{$row_k['replid']}\" $selected>{$row_k['kalender']}$ada</option>";
                            } ?>
                        </select>
                        <button onclick="tambah_kal()" class="bg-emerald-900 text-white p-2.5 rounded-xl hover:bg-emerald-800 transition-colors" title="Tambah Kalender"><i class="fa-solid fa-plus"></i></button>
                    </div>
                </div>

                <!-- Periode Info -->
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Periode</label>
                    <input type="text" readonly class="w-full bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-xl px-3 py-2.5" value="<?=$periode?>">
                </div>

                <!-- Action Button -->
                <div>
                    <button onclick="show_kal()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-eye"></i> TAMPILKAN KALENDER
                    </button>
                </div>
            </div>
        </div>

        <!-- CALENDAR AREA -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
            <?php if ($action == 'view' && !empty($kalender)) { ?>
                
                <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <div class="flex gap-2">
                        <?php if ($next == 1) { ?>
                            <button onclick="GoToPrevMonth()" class="bg-white border border-slate-200 text-emerald-700 px-4 py-2 rounded-xl hover:bg-slate-50 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                                <i class="fa-solid fa-chevron-left"></i> SEBELUMNYA
                            </button>
                        <?php } ?>
                        <?php
                        $bul_last = $bln + 5;
                        $thn_last = $thn;
                        if ($bul_last > 12) { $bul_last -= 12; $thn_last++; }
                        $batas_date = $thn_last."-".$bul_last."-31";
                        $sql_next = "SELECT replid FROM aktivitaskalender WHERE idkalender = '$kalender' AND tanggalakhir > '$batas_date'";
                        $res_next = QueryDb($sql_next);
                        if (mysqli_num_rows($res_next) > 0) {
                            $nextbln = ($bul_last == 12) ? 1 : $bul_last + 1;
                            $nextthn = ($bul_last == 12) ? $thn_last + 1 : $thn_last;
                        ?>
                            <input type="hidden" id="nextbln" value="<?=$nextbln?>">
                            <input type="hidden" id="nextthn" value="<?=$nextthn?>">
                            <button onclick="GoToNextMonth()" class="bg-white border border-slate-200 text-emerald-700 px-4 py-2 rounded-xl hover:bg-slate-50 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                                BERIKUTNYA <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        <?php } ?>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <button onclick="cetak()" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-2.5 rounded-2xl hover:bg-emerald-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-print"></i> CETAK
                        </button>
                        <button onclick="tambah_keg()" class="bg-emerald-900 text-white px-5 py-2.5 rounded-2xl hover:bg-emerald-800 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-plus"></i> TAMBAH KEGIATAN
                        </button>
                    </div>
                </div>

                <div class="flex-1 overflow-auto p-4">
                    <div class="min-w-[1200px]">
                        <table class="w-full border-collapse border-spacing-0 table-fixed">
                            <thead>
                                <tr class="bg-emerald-900 text-white text-[10px] font-bold uppercase tracking-widest">
                                    <th rowspan="2" class="w-48 p-3 border border-emerald-800 text-center">Kegiatan</th>
                                    <?php 
                                    $curr_thn = $thn;
                                    for ($i=$bln; $i<=$bln+5; $i++) {
                                        $n = $i; if ($i > 12) { $n = $i-12; $curr_thn = $thn+1; }
                                        echo "<th colspan='4' class='p-3 border border-emerald-800 text-center'>{$bulan[$n]} '" . substr($curr_thn, 2, 2) . "</th>";
                                    } ?>
                                </tr>
                                <tr class="bg-emerald-800 text-emerald-100 text-[8px] font-bold">
                                    <?php for ($i=0; $i<6; $i++) { for ($p=1; $p<=4; $p++) echo "<th class='p-1 border border-emerald-700 text-center'>$p</th>"; } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($keg_data)) { 
                                    $m = 0;
                                    foreach ($keg_data as $i => $keg_row) {
                                        $id_keg = $keg_row['id'];
                                ?>
                                    <tr class="h-20">
                                        <td style="background-color: <?=$color[$m][0]?>" class="p-3 border border-slate-200 text-white shadow-sm">
                                            <div class="text-[10px] font-extrabold uppercase leading-tight"><?=$keg_row['judul']?></div>
                                            <?php if (!isset($jadwal_data[$id_keg])) echo "<div class='text-[8px] opacity-75 mt-2'>{$keg_row['tanggal']}</div>"; ?>
                                        </td>
                                        <?php 
                                        $mask = array();
                                        for ($j=1; $j<=24; $j++) echo getCell1($i, $j, $id_keg, $m); 
                                        ?>
                                    </tr>
                                <?php 
                                        $m = ($m + 1) % count($color);
                                    }
                                } else { ?>
                                    <tr><td colspan="25" class="p-16 text-center text-slate-400 font-bold">Belum ada kegiatan untuk kalender ini.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php } else { ?>
                <!-- BLANK STATE -->
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                    <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-calendar-alt text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Manajemen Kalender Akademik</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Pilih <strong>Departemen</strong> dan <strong>Kalender Akademik</strong> untuk menampilkan jadwal kegiatan sekolah.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>