<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$nip = "";
if (isset($_REQUEST['nip']))
	$nip = $_REQUEST['nip'];
$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
$tahunajaran = "";
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];
$semester = "";
if (isset($_REQUEST['semester']))
	$semester = $_REQUEST['semester'];
$tingkat = "";
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
$kelas = "";
if (isset($_REQUEST['kelas']))
	$kelas = $_REQUEST['kelas'];
$pelajaran = "";
if (isset($_REQUEST['pelajaran']))
	$pelajaran = $_REQUEST['pelajaran'];

OpenDb();

// Get default values if not set
if ($departemen == "") {
    $dep = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep[0];
}

if ($tahunajaran == "") {
    $sql = "SELECT replid FROM tahunajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY replid DESC";
    $result = QueryDb($sql);
    $row = @mysqli_fetch_array($result);	
    $tahunajaran = $row['replid'];
}

if ($semester == "") {
    $sql = "SELECT replid FROM semester where departemen='$departemen' AND aktif = 1";
    $result = QueryDb($sql);
    $row = @mysqli_fetch_array($result);
    $semester = $row['replid'];
}

if ($tingkat == "") {
    $sql = "SELECT replid FROM tingkat WHERE aktif=1 AND departemen='$departemen' ORDER BY urutan LIMIT 1";	
    $result = QueryDb($sql);
    $row = mysqli_fetch_array($result);
    $tingkat = $row['replid'];
}

if ($kelas == "" && $tahunajaran != "" && $tingkat != "") {
    $sql = "SELECT replid FROM kelas WHERE aktif=1 AND idtahunajaran = '$tahunajaran' AND idtingkat = '$tingkat' ORDER BY kelas LIMIT 1";	
    $result = QueryDb($sql);
    $row = mysqli_fetch_array($result);
    $kelas = $row['replid'];
}

if ($pelajaran == "") {
    $sql = "SELECT replid FROM pelajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY nama LIMIT 1";
    $result = QueryDb($sql);
    $row = @mysqli_fetch_array($result);
    $pelajaran = $row['replid'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Form Penilaian</title>
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
    function change() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var semester = document.getElementById("semester").value;
        var tingkat = document.getElementById("tingkat").value;
        var pelajaran = document.getElementById("pelajaran").value;
        var kelas = document.getElementById("kelas").value;
        var nip = document.getElementById("nip").value;
                
        document.location.href = "formpenilaian.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&semester="+semester+"&tingkat="+tingkat+"&pelajaran="+pelajaran+"&kelas="+kelas+"&nip="+nip;
    }

    function change_dep() {
        var departemen = document.getElementById("departemen").value;
        document.location.href = "formpenilaian.php?departemen="+departemen;
    }

    function change_tingkat() {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var semester = document.getElementById("semester").value;
        var tingkat = document.getElementById("tingkat").value;
        document.location.href = "formpenilaian.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&semester="+semester+"&tingkat="+tingkat;
    }

    function validate(jenis) {
        var departemen = document.getElementById("departemen").value;
        var tahunajaran = document.getElementById("tahunajaran").value;
        var semester = document.getElementById("semester").value;
        var tingkat = document.getElementById("tingkat").value;	
        var pelajaran = document.getElementById("pelajaran").value;
        var kelas = document.getElementById("kelas").value;
        var nip = document.getElementById("nip").value; 	

        if (tahunajaran.length == 0) {	
            alert ('Pastikan tahun ajaran sudah ada!');
            return false;
        } else if (semester.length == 0) {	
            alert ('Pastikan semester sudah ada!');
            return false;
        } else if (tingkat.length == 0) {	
            alert ('Pastikan tingkat sudah ada!');
            return false;
        } else if (kelas.length == 0) {	
            alert ('Pastikan kelas sudah ada!');
            return false;
        } else if (pelajaran.length == 0) {	
            alert ('Pastikan pelajaran sudah ada!');
            return false;
        } else if (nip.length == 0) {	
            alert ('Pastikan ada guru yang mengajar!');
            return false;
        }

        var addr, title, w, h;
        if (jenis==1){
            w='790'; h='850';
            title='CetakFormPengisianNilaiSiswa';
            addr='form_nilai_cetak.php?departemen='+departemen+'&tahunajaran='+tahunajaran+'&semester='+semester+'&pelajaran='+pelajaran+'&kelas='+kelas+'&nip='+nip;
        } else if (jenis==2){
            w='467'; h='242';
            title='CetakFormPengisianNilaiAkhirSiswa_Verifikasi';
            addr='form_akhir_cetak_verifikasi.php?semester='+semester+'&pelajaran='+pelajaran+'&kelas='+kelas+'&nip='+nip+'&tingkat='+tingkat;
        } else if (jenis==3){
            w='790'; h='850';
            title='CetakFormNilaiRaporSiswa';
            addr='form_rapor_cetak.php?semester='+semester+'&pelajaran='+pelajaran+'&kelas='+kelas+'&nip='+nip;
        } else if (jenis==4){
            w='790'; h='850';
            title='CetakFormKomentarNilaiRaporSiswa';
            addr='form_komentar_cetak.php?semester='+semester+'&pelajaran='+pelajaran+'&kelas='+kelas+'&nip='+nip;
        }
        newWindow(addr,title,w,h,'resizable=1,scrollbars=1,status=0,toolbar=0');
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
                    <i class="fa-solid fa-file-invoice text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Penilaian</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">CETAK FORM PENILAIAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../penilaian.php" target="content" class="text-emerald-700 hover:underline font-semibold">Penilaian</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Cetak Form</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Row 1 -->
                <div class="flex flex-col gap-2">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="change_dep()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-2xl focus:ring-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm cursor-pointer">
                            <? $dep = getDepartemen(SI_USER_ACCESS());    
                            foreach($dep as $value) { ?>
                                <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="tahun" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Tahun Ajaran</label>
                    <? 
                    $sql = "SELECT replid,tahunajaran FROM tahunajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY replid DESC";
                    $result = QueryDb($sql);
                    $row = @mysqli_fetch_array($result);
                    ?>
                    <input type="text" name="tahun" id="tahun" readonly class="bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-2xl px-4 py-3 w-full shadow-sm" value="<?=$row['tahunajaran']?>" />
                    <input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$row['replid']?>">
                </div>

                <div class="flex flex-col gap-2">
                    <label for="sem" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Semester</label>
                    <? 
                    $sql = "SELECT replid,semester FROM semester where departemen='$departemen' AND aktif = 1";
                    $result = QueryDb($sql);
                    $row = @mysqli_fetch_array($result);
                    ?>
                    <input type="text" name="sem" id="sem" readonly class="bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-2xl px-4 py-3 w-full shadow-sm" value="<?=$row['semester']?>" />
                    <input type="hidden" name="semester" id="semester" value="<?=$row['replid']?>">
                </div>

                <!-- Row 2 -->
                <div class="flex flex-col gap-2">
                    <label for="tingkat" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Tingkat</label>
                    <div class="relative">
                        <select name="tingkat" id="tingkat" onChange="change_tingkat()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-2xl focus:ring-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm cursor-pointer">
                            <? 
                            $sql = "SELECT replid,tingkat FROM tingkat WHERE aktif=1 AND departemen='$departemen' ORDER BY urutan";	
                            $result = QueryDb($sql);
                            while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $tingkat) ?>><?=$row['tingkat']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="kelas" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Kelas</label>
                    <div class="relative">
                        <select name="kelas" id="kelas" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-2xl focus:ring-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm cursor-pointer">
                            <? 
                            $sql = "SELECT replid,kelas FROM kelas WHERE aktif=1 AND idtahunajaran = '$tahunajaran' AND idtingkat = '$tingkat' ORDER BY kelas ";	
                            $result = QueryDb($sql);
                            while($row = mysqli_fetch_array($result)) { ?>
                                <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $kelas) ?>><?=$row['kelas']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="pelajaran" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Pelajaran</label>
                    <div class="relative">
                        <select name="pelajaran" id="pelajaran" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-2xl focus:ring-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm cursor-pointer">
                            <? 
                            $sql = "SELECT replid,nama FROM pelajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY nama";
                            $result = QueryDb($sql);
                            while ($row = @mysqli_fetch_array($result)) { ?>
                                <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $pelajaran)?> ><?=$row['nama']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Row 3 (Full Width) -->
                <div class="flex flex-col gap-2 lg:col-span-3">
                    <label for="nip" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-[10px] ml-1">Guru Pengampu</label>
                    <div class="relative">
                        <select name="nip" id="nip" onChange="change()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-2xl focus:ring-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm cursor-pointer">
                            <? 
                            $sql = "SELECT DISTINCT p.nip,p.nama FROM pegawai p, guru g WHERE p.nip = g.nip AND g.idpelajaran = '$pelajaran' AND g.aktif = 1 ORDER BY p.nama";
                            $result = QueryDb($sql);
                            while ($row = @mysqli_fetch_array($result)) { ?>
                                <option value="<?=urlencode($row['nip'])?>" <?=StringIsSelected($row['nip'], $nip)?> ><?=$row['nip']?> - <?=$row['nama']?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Print Options Area -->
        <div class="flex-1 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8 flex flex-col items-center justify-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full max-w-4xl">
                <button onClick="validate(1)" class="group flex items-center gap-4 p-5 bg-slate-50 hover:bg-emerald-900 rounded-3xl transition-all duration-300 border border-slate-100 hover:border-emerald-700 shadow-sm">
                    <div class="bg-emerald-100 group-hover:bg-emerald-800 text-emerald-700 group-hover:text-white p-4 rounded-2xl transition-colors">
                        <i class="fa-solid fa-user-edit text-xl"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-xs font-bold text-slate-400 group-hover:text-emerald-400 uppercase tracking-widest mb-1">Form Pengisian</span>
                        <span class="block text-sm font-extrabold text-slate-900 group-hover:text-white">Nilai Siswa</span>
                    </div>
                </button>

                <button onClick="validate(2)" class="group flex items-center gap-4 p-5 bg-slate-50 hover:bg-emerald-900 rounded-3xl transition-all duration-300 border border-slate-100 hover:border-emerald-700 shadow-sm">
                    <div class="bg-emerald-100 group-hover:bg-emerald-800 text-emerald-700 group-hover:text-white p-4 rounded-2xl transition-colors">
                        <i class="fa-solid fa-check-double text-xl"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-xs font-bold text-slate-400 group-hover:text-emerald-400 uppercase tracking-widest mb-1">Form Pengisian</span>
                        <span class="block text-sm font-extrabold text-slate-900 group-hover:text-white">Nilai Akhir Siswa</span>
                    </div>
                </button>

                <button onClick="validate(3)" class="group flex items-center gap-4 p-5 bg-slate-50 hover:bg-emerald-900 rounded-3xl transition-all duration-300 border border-slate-100 hover:border-emerald-700 shadow-sm">
                    <div class="bg-emerald-100 group-hover:bg-emerald-800 text-emerald-700 group-hover:text-white p-4 rounded-2xl transition-colors">
                        <i class="fa-solid fa-graduation-cap text-xl"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-xs font-bold text-slate-400 group-hover:text-emerald-400 uppercase tracking-widest mb-1">Form Pengisian</span>
                        <span class="block text-sm font-extrabold text-slate-900 group-hover:text-white">Nilai Rapor Siswa</span>
                    </div>
                </button>

                <button onClick="validate(4)" class="group flex items-center gap-4 p-5 bg-slate-50 hover:bg-emerald-900 rounded-3xl transition-all duration-300 border border-slate-100 hover:border-emerald-700 shadow-sm">
                    <div class="bg-emerald-100 group-hover:bg-emerald-800 text-emerald-700 group-hover:text-white p-4 rounded-2xl transition-colors">
                        <i class="fa-solid fa-comment-dots text-xl"></i>
                    </div>
                    <div class="text-left">
                        <span class="block text-xs font-bold text-slate-400 group-hover:text-emerald-400 uppercase tracking-widest mb-1">Form Komentar</span>
                        <span class="block text-sm font-extrabold text-slate-900 group-hover:text-white">Rapor Siswa</span>
                    </div>
                </button>
            </div>
            
            <p class="mt-8 text-slate-400 text-[10px] font-medium uppercase tracking-[0.2em]">Pilih salah satu form di atas untuk mencetak</p>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
