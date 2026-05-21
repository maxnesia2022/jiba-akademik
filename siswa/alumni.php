<?
require_once('../include/errorhandler.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../library/departemen.php');
require_once('../cek.php');

OpenDb();
$op = "";
if (isset($_REQUEST['op']))
	$op = $_REQUEST['op'];

$varbaris=20;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];

$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];
	
$tahun = "";
if (isset($_REQUEST['tahun']))
	$tahun = $_REQUEST['tahun'];
	
$urut = "s.nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

// Get default values if not set
if ($departemen == "") {
    $dep = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep[0];
}

if ($tahun == "") {
    $sql="SELECT YEAR(tgllulus) AS thn FROM alumni WHERE departemen='$departemen' GROUP BY thn ORDER BY thn DESC LIMIT 1";
    $result=QueryDb($sql);
    if ($row = @mysqli_fetch_array($result)) {
        $tahun = $row['thn'];
    }
}

if ($op == "xm8r389xemx23xb2378e23") {
	$sql="SELECT a.tktakhir, a.klsakhir, a.nis, k.idtahunajaran FROM alumni a, kelas k WHERE a.replid='$_REQUEST[replid]' AND a.klsakhir = k.replid AND k.idtingkat=a.tktakhir";
	$result=QueryDb($sql);
	$row = mysqli_fetch_array($result);
	$nis = $row['nis'];
	$idkelas = $row['klsakhir'];
	
	BeginTrans();
	$success=0;
	
	$sql1="UPDATE riwayatkelassiswa SET aktif=1 WHERE nis='$nis' AND idkelas = '$idkelas'";
	$result1=QueryDbTrans($sql1, $success);
	
	if ($success){
		$sql1="UPDATE riwayatdeptsiswa SET aktif=1 WHERE nis='$nis' AND departemen='$departemen'";
		$result1=QueryDbTrans($sql1, $success);
	}
	
	if ($success){
		$sql1="UPDATE siswa SET aktif=1,alumni=0 WHERE nis='$nis'";
		$result=QueryDbTrans($sql1, $success);
	}
	
	if ($success){
		$sql1="DELETE FROM alumni WHERE replid='$_REQUEST[replid]'";
		$result1=QueryDbTrans($sql1, $success);
	}
	
	if ($success)
		CommitTrans();
	else
		RollbackTrans();
	
	header("Location: alumni.php?departemen=$departemen&tahun=$tahun");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alumni</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
    function tambah() {
        var departemen = document.getElementById('departemen').value;
        document.location.href="alumni_main.php?departemen="+departemen;
    }

    function hapus(replid){
        var departemen = document.getElementById('departemen').value;
        var tahun = document.getElementById('tahun').value;
        
        if (confirm("Apakah anda yakin akan mengembalikan siswa ini ke Departemen, Tingkat dan Kelas sebelumnya?"))
            document.location.href = "alumni.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&tahun="+tahun+"&urut=<?=$urut?>&urutan=<?=$urutan?>&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
    }

    function cetak() {
        var departemen=document.getElementById("departemen").value;
        var tahun=document.getElementById("tahun").value;
        var total=document.getElementById("total_hal").value;
        newWindow('alumni_cetak.php?departemen='+departemen+'&tahun='+tahun+'&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakAlumni','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function change_dep() {
        var departemen=document.getElementById("departemen").value;
        document.location.href = "alumni.php?departemen="+departemen;
    }

    function refresh() {
        var departemen=document.getElementById("departemen").value;
        var tahun=document.getElementById("tahun").value;
        document.location.href = "alumni.php?tahun="+tahun+"&departemen="+departemen;
    }

    function change_urut(new_urut){
        var departemen = document.getElementById('departemen').value;
        var tahun = document.getElementById('tahun').value;
        var current_urutan = "<?=$urutan?>";
        var next_urutan = (current_urutan == "ASC") ? "DESC" : "ASC";
            
        document.location.href="alumni.php?departemen="+departemen+"&tahun="+tahun+"&urut="+new_urut+"&urutan="+next_urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
    }

    function change_hal() {
        var departemen=document.getElementById("departemen").value;
        var tahun=document.getElementById("tahun").value;
        var hal = document.getElementById("hal").value;
        var varbaris=document.getElementById("varbaris").value;
        
        document.location.href="alumni.php?departemen="+departemen+"&tahun="+tahun+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }

    function change_baris() {
        var departemen=document.getElementById("departemen").value;
        var tahun=document.getElementById("tahun").value;
        var varbaris=document.getElementById("varbaris").value;
        
        document.location.href= "alumni.php?departemen="+departemen+"&tahun="+tahun+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }
    </script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" onload="document.getElementById('departemen').focus()">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Kenaikan & Kelulusan</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">DAFTAR ALUMNI</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../kelulusan.php" target="content" class="text-emerald-700 hover:underline font-semibold">Kelulusan</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Daftar Alumni</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Departemen -->
                <div class="flex items-center gap-3">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="change_dep()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                            <? $dep = getDepartemen(SI_USER_ACCESS());    
                            foreach($dep as $value) { ?>
                                <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Tahun Lulus -->
                <div class="flex items-center gap-3">
                    <label for="tahun" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Tahun Lulus</label>
                    <div class="relative">
                        <select name="tahun" id="tahun" onChange="refresh()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-32 pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                            <?  
                            $sql="SELECT YEAR(tgllulus) AS thn FROM alumni WHERE departemen='$departemen' GROUP BY thn ORDER BY thn DESC";
                            $result_thn=QueryDb($sql);
                            $jum_tahun = mysqli_num_rows($result_thn);
                            while ($row_thn=@mysqli_fetch_array($result_thn)){ ?>
                                <option value="<?=$row_thn['thn']?>" <?=IntIsSelected($row_thn['thn'], $tahun) ?>><?=$row_thn['thn']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5">
                <button onClick="refresh()" class="p-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors" title="Refresh">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
                <button onClick="cetak()" class="p-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors" title="Cetak">
                    <i class="fa-solid fa-print"></i>
                </button>
                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                    <button onClick="tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-plus"></i> Tambah Alumnus
                    </button>
                <? } ?>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <?
            if ($jum_tahun > 0){
                $sql_tot = "SELECT al.replid FROM alumni al, siswa s WHERE al.departemen = '$departemen' AND s.nis = al.nis AND YEAR(al.tgllulus) = '$tahun'";
                $result_tot = QueryDb($sql_tot);
                $jumlah_data = mysqli_num_rows($result_tot);
                $total_halaman = ceil($jumlah_data / $varbaris);
                
                $sql_siswa = "SELECT s.replid AS replidsiswa, s.nis, s.nama, k.kelas, al.tgllulus, al.klsakhir, al.tktakhir, al.replid, t.tingkat, a.angkatan 
                             FROM alumni al, kelas k, tingkat t, siswa s, angkatan a 
                             WHERE k.idtingkat=t.replid AND t.replid=al.tktakhir AND k.replid=al.klsakhir AND YEAR(al.tgllulus) = '$tahun' AND al.departemen = '$departemen' AND s.nis = al.nis AND s.idangkatan = a.replid 
                             ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
                $result_siswa = QueryDb($sql_siswa);
                
                if (mysqli_num_rows($result_siswa) > 0) { ?>
                    <input type="hidden" id="total_hal" value="<?=$total_halaman?>"/>
                    <div class="overflow-y-auto flex-1 p-1">
                        <table class="w-full text-left border-separate border-spacing-0">
                            <thead>
                                <tr class="bg-slate-50 sticky top-0 z-10">
                                    <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 rounded-tl-2xl text-center">No</th>
                                    <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 cursor-pointer hover:text-emerald-700" onClick="change_urut('s.nis')">NIS <?=change_urut('s.nis',$urut,$urutan)?></th>
                                    <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 cursor-pointer hover:text-emerald-700" onClick="change_urut('s.nama')">Nama <?=change_urut('s.nama',$urut,$urutan)?></th>
                                    <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 cursor-pointer hover:text-emerald-700 text-center" onClick="change_urut('a.angkatan')">Angkatan <?=change_urut('a.angkatan',$urut,$urutan)?></th>
                                    <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 cursor-pointer hover:text-emerald-700 text-center" onClick="change_urut('t.tingkat, k.kelas')">Kls Akhir <?=change_urut('t.tingkat, k.kelas',$urut,$urutan)?></th>
                                    <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 cursor-pointer hover:text-emerald-700 text-center" onClick="change_urut('al.tgllulus')">Tgl Lulus <?=change_urut('al.tgllulus',$urut,$urutan)?></th>
                                    <th class="px-4 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 rounded-tr-2xl text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?	
                                $cnt = (int)$page * (int)$varbaris;
                                while ($row = mysqli_fetch_array($result_siswa)) { ?>
                                    <tr class="hover:bg-slate-50 transition-colors group">
                                        <td class="px-4 py-3 text-xs font-bold text-slate-400 text-center"><?=++$cnt ?></td>
                                        <td class="px-4 py-3 text-xs font-bold text-slate-900"><?=$row['nis'] ?></td>
                                        <td class="px-4 py-3 text-xs text-slate-700"><?=$row['nama'] ?></td>
                                        <td class="px-4 py-3 text-xs text-slate-600 text-center"><?=$row['angkatan']; ?></td>
                                        <td class="px-4 py-3 text-xs text-slate-600 text-center"><?=$row['tingkat'].' - '.$row['kelas']; ?></td>
                                        <td class="px-4 py-3 text-xs text-slate-600 text-center"><?=LongDateFormat($row['tgllulus']); ?></td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center gap-1.5">
                                                <button onClick="newWindow('../library/detail_siswa.php?replid=<?=$row['replidsiswa']?>', 'DetailSiswa','800','650','resizable=1,scrollbars=1,status=0,toolbar=0')" class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="Detail">
                                                    <i class="fa-solid fa-eye text-[10px]"></i>
                                                </button>
                                                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                                    <button onClick="newWindow('siswa_cetak_detail.php?replid=<?=$row['replidsiswa']?>', 'CetakDetail','800','650','resizable=1,scrollbars=1,status=0,toolbar=0')" class="p-1.5 bg-slate-50 text-slate-600 rounded-lg hover:bg-slate-100 transition-colors" title="Cetak">
                                                        <i class="fa-solid fa-print text-[10px]"></i>
                                                    </button>
                                                    <button onClick="hapus('<?=$row['replid'] ?>')" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Batalkan">
                                                        <i class="fa-solid fa-undo text-[10px]"></i>
                                                    </button>
                                                <? } ?>
                                            </div>
                                        </td>
                                    </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-between border-t border-slate-100">
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Halaman</span>
                            <div class="relative">
                                <select id="hal" onChange="change_hal()" class="appearance-none bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-lg pl-3 pr-8 py-1.5 shadow-sm cursor-pointer">
                                    <? for ($m=0; $m<$total_halaman; $m++) {?>
                                        <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                </div>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">dari <?=$total_halaman?> halaman</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Baris</span>
                            <div class="relative">
                                <select id="varbaris" onChange="change_baris()" class="appearance-none bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-lg pl-3 pr-8 py-1.5 shadow-sm cursor-pointer">
                                    <? for ($m=5; $m <= 100; $m=$m+5) { ?>
                                        <option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-[8px]"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <? } else { ?>
                    <div class="flex-1 flex flex-col items-center justify-center p-10 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6 text-slate-300">
                            <i class="fa-solid fa-user-slash text-4xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-slate-900 mb-2">Tidak Ada Data</h2>
                        <p class="text-slate-500 text-sm max-w-md leading-relaxed">
                            Tidak ditemukan data alumni untuk kriteria yang dipilih.
                        </p>
                    </div>
                <? }
            } else { ?>
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center">
                    <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mb-6 text-emerald-900">
                        <i class="fa-solid fa-info-circle text-4xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Data</h2>
                    <p class="text-slate-500 text-sm max-w-md leading-relaxed">
                        Belum ada data alumni pada departemen <strong><?=$departemen?></strong>.
                        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                            <br/><br/>
                            <button onClick="tambah()" class="text-emerald-700 font-bold hover:underline">Klik di sini untuk mengisi data baru</button>
                        <? } ?>
                    </p>
                </div>
            <? } ?>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
