<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$tipe = array(
    array("nis","NIS"), 
    array("idangkatan","Angkatan"), 
    array("tgllulus","Tahun Lulus"), 
    array("nama","Nama"), 
    array("panggilan","Nama Panggilan"), 
    array("agama","Agama"), 
    array("suku","Suku"), 
    array ("status","Status"), 
    array("kondisi","Kondisi Siswa"), 
    array("darah","Golongan Darah"), 
    array("alamatsiswa","Alamat Siswa"), 
    array("asalsekolah","Asal Sekolah"), 
    array("namaayah","Nama Ayah"), 
    array("namaibu","Nama Ibu"), 
    array("alamatortu","Alamat Orang Tua"), 
    array("keterangan","Keterangan")
);

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

$jenis = "nis";
if (isset($_REQUEST['jenis']))
	$jenis = $_REQUEST['jenis'];

$cari = "";
if (isset($_REQUEST['cari']))
	$cari = $_REQUEST['cari'];

OpenDb();

// Get default values if not set
if ($departemen == "") {
    $dep = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep[0];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Alumni</title>
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

    <script language="javascript">
    function blank() {
        var departemen = document.getElementById('departemen').value;
        var jenis = document.getElementById('jenis').value;
        var cari = document.getElementById("cari").value;
        
        document.location.href = "alumni_cari.php?departemen="+departemen+"&jenis="+jenis+"&cari="+cari;
    }

    function cari_alumni() {
        var jenis = document.getElementById("jenis").value;
        var cari = document.getElementById("cari").value;
        var departemen = document.getElementById("departemen").value;	
        
        if (cari == "") {
            alert ('Keyword tidak boleh kosong');
            document.getElementById("cari").focus();
            return false;
        }
        
        if (jenis != 'kondisi' && jenis != 'status' && jenis != 'agama' && jenis != 'suku' && jenis != 'darah' && jenis != 'idangkatan'){
            if (cari.length < 3){
                alert ('Keyword tidak boleh kurang dari 3 karakter');
                return false;
            }
        }
        
        document.getElementById('footer_frame').src = "alumni_cari_footer.php?departemen="+departemen+"&jenis="+jenis+"&cari="+cari;
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            if (elemName == 'tabel') {
                cari_alumni();
            } else {
                document.getElementById(elemName).focus();
            }
            return false;
        }
        return true;
    }
    </script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" onload="document.getElementById('cari').focus();">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-user-tag text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Kenaikan & Kelulusan</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PENCARIAN ALUMNI</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../kelulusan.php" target="content" class="text-emerald-700 hover:underline font-semibold">Kelulusan</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Pencarian Alumni</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Departemen -->
                <div class="flex items-center gap-3">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="blank()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
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

                <!-- Berdasarkan -->
                <div class="flex items-center gap-3">
                    <label for="jenis" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Berdasarkan</label>
                    <div class="relative">
                        <select name="jenis" id="jenis" onChange="blank()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-48 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                            <? foreach($tipe as $value) { ?>
                                <option value="<?=$value[0]?>" <?=StringIsSelected($value[0], $jenis)?> ><?=$value[1]?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Keyword -->
                <div class="flex items-center gap-3">
                    <label for="cari" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Kata Kunci</label>
                    <div class="relative">
                        <?
                        if ($jenis == 'darah') {
                            $row = array('A','O','B','AB');
                            $jum = 4; ?>
                            <select name="cari" id="cari" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                                <? for ($i=0;$i<$jum;$i++) { ?>
                                    <option value="<?=$row[$i]?>" <?=StringIsSelected($row[$i], $cari)?> ><?=$row[$i]?></option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        <? } elseif ($jenis == 'idangkatan') { ?>
                            <select name="cari" id="cari" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                                <?
                                $query = "SELECT replid, angkatan FROM angkatan WHERE departemen = '$departemen' ORDER BY angkatan DESC ";
                                $result = QueryDb($query);
                                while ($row = mysqli_fetch_row($result)) { ?>
                                    <option value="<?=$row[0]?>" <?=IntIsSelected($row[0], $cari)?> ><?=$row[1]?></option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        <? } elseif ($jenis == 'kondisi' || $jenis == 'status' || $jenis == 'agama' || $jenis == 'suku' || $jenis == 'tgllulus') {	
                            if ($jenis == 'kondisi') {								
                                $query = "SELECT kondisi FROM kondisisiswa ORDER BY kondisi ";			
                            } elseif ($jenis == 'status') {	
                                $query = "SELECT status FROM statussiswa ORDER BY status ";
                            } elseif ($jenis == 'tgllulus') {
                                $query = "SELECT YEAR(tgllulus) AS tahun FROM alumni WHERE departemen = '$departemen' GROUP BY tahun ORDER BY tahun DESC ";
                            } elseif ($jenis == 'agama') {		
                                $query = "SELECT agama FROM agama ORDER BY urutan";
                            } elseif ($jenis == 'suku') {		
                                $query = "SELECT suku FROM suku ORDER BY suku";
                            }
                            $result_q = QueryDb($query); ?>
                            <select name="cari" id="cari" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm cursor-pointer">
                                <? while ($row_q = mysqli_fetch_row($result_q)) { ?>
                                    <option value="<?=$row_q[0]?>" <?=StringIsSelected($row_q[0], $cari)?> ><?=$row_q[0]?></option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        <? } else { ?>
                            <input type="text" name="cari" id="cari" value="<?=$cari?>" class="bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-56 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all shadow-sm" placeholder="Ketik di sini..." onKeyPress="return focusNext('tabel', event)" />
                        <? } ?>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5">
                <button id="tabel" onClick="cari_alumni()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari Alumni
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative">
            <iframe name="cari_alumni_footer" id="footer_frame" src="blank_alumni_cari.php" class="w-full h-full border-none"></iframe>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
