<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

$th1 = date("Y");
if (isset($_REQUEST['th1']))
	$th1 = $_REQUEST['th1'];
$tgl1 = date("j");
if (isset($_REQUEST['tgl1']))
	$tgl1 = $_REQUEST['tgl1'];
$bln1 = date("n");
if (isset($_REQUEST['bln1']))
	$bln1 = $_REQUEST['bln1'];
$th2 = date("Y");
if (isset($_REQUEST['th2']))
	$th2 = $_REQUEST['th2'];
$bln2 = date("n");
if (isset($_REQUEST['bln2']))
	$bln2 = $_REQUEST['bln2'];

$nis = "";
if (isset($_REQUEST['nis']))
    $nis = $_REQUEST['nis'];
$nama = "";
if (isset($_REQUEST['nama']))
    $nama = $_REQUEST['nama'];

OpenDb();
$tahun1 = date('Y') - 5;
$tahun2 = date('Y') + 1;

if ($nis != "")
{
	$sql = "SELECT t.tahunajaran, YEAR(t.tglmulai) AS tahun1, YEAR(t.tglakhir) AS tahun2 
              FROM tahunajaran t, kelas k, siswa s 
             WHERE k.idtahunajaran = t.replid 
               AND k.replid = s.idkelas 
               AND s.nis='$nis'";
	$result = QueryDb($sql);
	
	if ($row = mysqli_fetch_row($result)) {
        $tahun1 = $row[1];
        $tahun2 = $row[2];
    }
}

$n1 = JmlHari($bln1, $th1);
$n2 = JmlHari($bln2, $th2);

$tgl2 =$n1;
if (isset($_REQUEST['tgl2']))
    $tgl2 = $_REQUEST['tgl2'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Presensi Harian Siswa</title>
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
    <script language="javascript" src="../script/validasi.js"></script>
    <script language="javascript" src="../script/ajax.js"></script>
    <script language="javascript">
    function tampil() {
        var th2 = parseInt(document.getElementById('th2').value);
        var bln2 = parseInt(document.getElementById('bln2').value);
        var tgl2 = parseInt(document.getElementById('tgl2').value);
        var th1 = parseInt(document.getElementById('th1').value);
        var bln1 = parseInt(document.getElementById('bln1').value);
        var tgl1 = parseInt(document.getElementById('tgl1').value);
        var nis = document.getElementById('nis').value;
        
        if (nis.length == 0){
            alert ('NIS siswa tidak boleh kosong!');
            return false;
        }
        
        var validasi = validateTgl(tgl1,bln1,th1,tgl2,bln2,th2);
        if (validasi)
            document.getElementById('footer_frame').src = "lap_hariansiswa_footer.php?nis="+nis+"&tgl1="+tgl1+"&bln1="+bln1+"&th1="+th1+"&tgl2="+tgl2+"&bln2="+bln2+"&th2="+th2;
    } 

    function carisiswa() {
        newWindow('../library/siswa.php?flag=0', 'CariSiswa','600','618','resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function acceptSiswa(nis, nama) {
        var th2 = document.getElementById('th2').value;
        var bln2 = document.getElementById('bln2').value;
        var tgl2 = document.getElementById('tgl2').value;
        var th1 = document.getElementById('th1').value;
        var bln1 = document.getElementById('bln1').value;
        var tgl1 = document.getElementById('tgl1').value;
        
        document.location.href = "lap_hariansiswa_main.php?nis="+nis+"&nama="+nama+"&tgl1="+tgl1+"&bln1="+bln1+"&th1="+th1+"&tgl2="+tgl2+"&bln2="+bln2+"&th2="+th2;
    }

    function change_tgl1() {
        var th = parseInt(document.getElementById('th1').value);
        var bln = parseInt(document.getElementById('bln1').value);
        var tgl = parseInt(document.getElementById('tgl1').value);
        var namatgl = "tgl1";
        var namabln = "bln1";	
        sendRequestText("../library/gettanggal.php", show1, "tahun="+th+"&bulan="+bln+"&tgl="+tgl+"&namatgl="+namatgl+"&namabln="+namabln);	
    }

    function change_tgl2() {
        var th = parseInt(document.getElementById('th2').value);
        var bln = parseInt(document.getElementById('bln2').value);
        var tgl = parseInt(document.getElementById('tgl2').value);
        var namatgl = "tgl2";
        var namabln = "bln2";	
        sendRequestText("../library/gettanggal.php", show2, "tahun="+th+"&bulan="+bln+"&tgl="+tgl+"&namatgl="+namatgl+"&namabln="+namabln);	
    }

    function show1(x) {
        document.getElementById("InfoTgl1").innerHTML = x;
    }

    function show2(x) {
        document.getElementById("InfoTgl2").innerHTML = x;
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            if (elemName == 'tabel') {
                tampil();
            } else {
                document.getElementById(elemName).focus();
            }
            return false;
        }
        return true;
    }
    </script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" onload="document.getElementById('tgl1').focus()">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-user-clock text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Presensi</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">LAPORAN PRESENSI HARIAN SISWA</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../presensi.php?page=ph" target="content" class="text-emerald-700 hover:underline font-semibold">Presensi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Laporan Harian Siswa</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Siswa -->
                <div class="flex items-center gap-3">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Siswa</label>
                    <div class="flex gap-2">
                        <input name="nis" type="text" id="nis" value="<?=$nis?>" class="bg-slate-100 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-32 shadow-sm cursor-pointer" readonly onclick="carisiswa()" placeholder="NIS" />
                        <input name="nama" type="text" id="nama" value="<?=$nama?>" class="bg-slate-100 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-4 py-2.5 w-64 shadow-sm cursor-pointer" readonly onclick="carisiswa()" placeholder="Nama Siswa" />
                        <button onClick="carisiswa()" class="bg-emerald-100 text-emerald-700 p-2.5 rounded-xl hover:bg-emerald-200 transition-colors">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>

                <!-- Tanggal Awal -->
                <div class="flex items-center gap-3">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Mulai</label>
                    <div class="flex gap-1.5">
                        <div id="InfoTgl1" class="relative">
                            <select name="tgl1" id="tgl1" onChange="change_tgl1()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-16 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                <? for($i=1;$i<=$n1;$i++){ ?>
                                    <option value="<?=$i?>" <?=IntIsSelected($tgl1, $i)?>><?=$i?></option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="bln1" id="bln1" onChange="change_tgl1()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-24 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                <? for ($i=1;$i<=12;$i++) { ?>
                                    <option value="<?=$i?>" <?=IntIsSelected($bln1, $i)?>><?=$bulan[$i]?></option>	
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="th1" id="th1" onChange="change_tgl1()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-24 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                <? for ($i = $tahun1; $i <= $tahun2; $i++) { ?>
                                    <option value="<?=$i?>" <?=IntIsSelected($th1, $i)?>><?=$i?></option>	   
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sampai -->
                <div class="flex items-center gap-3">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Sampai</label>
                    <div class="flex gap-1.5">
                        <div id="InfoTgl2" class="relative">
                            <select name="tgl2" id="tgl2" onChange="change_tgl2()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-16 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                <? for($i=1;$i<=$n2;$i++){ ?>
                                    <option value="<?=$i?>" <?=IntIsSelected($tgl2, $i)?>><?=$i?></option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="bln2" id="bln2" onChange="change_tgl2()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-24 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                <? for ($i=1;$i<=12;$i++) { ?>
                                    <option value="<?=$i?>" <?=IntIsSelected($bln2, $i)?>><?=$bulan[$i]?></option>	
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="th2" id="th2" onChange="change_tgl2()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-24 pl-3 pr-6 py-2.5 shadow-sm cursor-pointer">
                                <? for ($i = $tahun1; $i <= $tahun2; $i++) { ?>
                                    <option value="<?=$i?>" <?=IntIsSelected($th2, $i)?>><?=$i?></option>	   
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[8px]"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5">
                <button id="tabel" onClick="tampil()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-magnifying-glass"></i> Tampilkan
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden relative">
            <iframe name="footer" id="footer_frame" src="blank_presensi_siswa.php?tipe=harian" class="w-full h-full border-none"></iframe>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
