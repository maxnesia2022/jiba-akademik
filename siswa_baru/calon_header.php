<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

$departemen = "";
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];

if (isset($_REQUEST['proses'])) 
	$proses = $_REQUEST['proses'];
	
if (isset($_REQUEST['kelompok']))
	$kelompok = $_REQUEST['kelompok'];

OpenDb();	
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Calon Siswa - Header</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Modern Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    
    <script language="JavaScript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/ajax.js"></script>
    <script language="javascript">
    var win = null;
    function newWindow(mypage,myname,w,h,features) {
          var winl = (screen.width-w)/2;
          var wint = (screen.height-h)/2;
          if (winl < 0) winl = 0;
          if (wint < 0) wint = 0;
          var settings = 'height=' + h + ',';
          settings += 'width=' + w + ',';
          settings += 'top=' + wint + ',';
          settings += 'left=' + winl + ',';
          settings += features;
          win = window.open(mypage,myname,settings);
          win.window.focus();
    }

    function change_dep() {
        var departemen = document.getElementById("departemen").value;
        parent.header.location.href = "calon_header.php?departemen="+departemen;
        parent.footer.location.href = "blank_calon.php";
    }

    function change_proses() {
        var departemen = document.getElementById("departemen").value;	
        var proses = document.getElementById("proses").value;
        
        parent.header.location.href = "calon_header.php?departemen="+departemen+"&proses="+proses;
        parent.footer.location.href = "blank_calon.php";
    }

    function show_calon() {	
        var departemen = document.getElementById("departemen").value;
        var proses = document.getElementById("proses").value;
        var kelompok = document.getElementById("kelompok").value;	
        
        if (proses.length == 0) {
            alert ('Pastikan Proses Penerimaan ada dan statusnya aktif!');	
            document.getElementById("departemen").focus();
            return false;
        }	
        if (kelompok.length == 0) {
            alert ('Kelompok Calon Siswa tidak boleh kosong!');	
            document.getElementById("departemen").focus();
            return false;
        }	
        parent.footer.location.href = "calon_content.php?departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok;
    }

    function tampil_kelompok() {
        var departemen = document.getElementById("departemen").value;
        var proses = document.getElementById("proses").value;
        
        newWindow('kelompok_tampil.php?departemen='+departemen+'&proses='+proses,'tampilKelompok','750','450','resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function kelompok_kiriman(a,b,c) {
        document.getElementById("a").value=a;
        document.getElementById("b").value=b;
        document.getElementById("c").value=c;
        setTimeout("change_kelompok(1)",1);	
    }

    function change_kelompok(aktif) {	
        var departemen = document.getElementById("departemen").value;
        var proses = document.getElementById("proses").value;
        var kelompok = document.getElementById("kelompok").value;	
        if (aktif == 0) {
            parent.header.location.href = "calon_header.php?kelompok="+kelompok+"&proses="+proses+"&departemen="+departemen;
        } else {
            var a = document.getElementById("a").value;
            var b = document.getElementById("b").value;
            var c = document.getElementById("c").value;
            parent.header.location.href = "calon_header.php?kelompok="+a+"&proses="+c+"&departemen="+c;
        }
        
        parent.footer.location.href = "blank_calon.php";
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            document.getElementById(elemName).focus();
            if (elemName == 'tabel') {
                show_calon();
                panggil('tabel');
            } 
            return false;
        } 
        return true;
    }

    function panggil(elem){
        var lain = new Array('departemen','kelompok');
        for (i=0;i<lain.length;i++) {
            if (lain[i] == elem) {
                document.getElementById(elem).style.background='#d1fae5'; // soft emerald hover
            } else {
                document.getElementById(lain[i]).style.background='#FFFFFF';
            }
        }
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<!-- Menggunakan m-0 p-0 dan bg-green-950 agar menyatu mulus dengan layout luar -->
<body class="bg-green-950 text-slate-800 select-none overflow-hidden m-0 p-0" onLoad="document.getElementById('departemen').focus()">
    <input type="hidden" name="a" id="a">
    <input type="hidden" name="b" id="b">
    <input type="hidden" name="c" id="c">

    <!-- 
      KARTU ATAS (TOP SPLIT-CARD):
      - Menggunakan rounded-t-[2.5rem] md:rounded-t-[3rem] (hanya melengkung di sudut atas).
      - Menghilangkan padding bawah agar menyatu mulus dengan frame di bawahnya.
    -->
    <div class="px-4 md:px-6 pt-4 md:pt-6 h-screen">
        <div class="bg-slate-50 rounded-t-[2.5rem] md:rounded-t-[3rem] border-t border-x border-green-800/30 p-5 md:px-8 pb-3 shadow-2xl h-full flex flex-col justify-between">
            
            <!-- Breadcrumbs / Title Row -->
            <div class="flex items-center justify-between text-xs pb-2 border-b border-slate-200/60 mb-2">
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    <span class="font-extrabold text-slate-900 tracking-tight text-sm uppercase">Pendataan Calon Siswa</span>
                </div>
                <div class="text-slate-500 font-semibold flex items-center gap-1.5">
                    <a href="../siswa_baru.php" target="content" class="text-emerald-700 hover:underline">Penerimaan Siswa Baru</a>
                    <span>/</span>
                    <span class="text-slate-600 font-medium">Pendataan Calon</span>
                </div>
            </div>

            <!-- Filter Controls Row -->
            <div class="flex items-center justify-between gap-4">
                <div class="flex items-center flex-wrap gap-4 flex-1">
                    
                    <!-- Departemen -->
                    <div class="flex items-center gap-2">
                        <label for="departemen" class="text-xs font-extrabold text-slate-700 uppercase">Departemen</label>
                        <div class="relative">
                            <select name="departemen" id="departemen" onchange="change_dep()" onKeyPress="return focusNext('kelompok', event)" onfocus="panggil('departemen')" class="appearance-none bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2 shadow-sm transition-all cursor-pointer">
                                <? $dep = getDepartemen(SI_USER_ACCESS());    
                                foreach($dep as $value) {
                                    if ($departemen == "")
                                        $departemen = $value; ?>
                                    <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> > <?=$value ?> </option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Proses Penerimaan (Read-only status) -->
                    <div class="flex items-center gap-2">
                        <label class="text-xs font-extrabold text-slate-700 uppercase">Proses</label>
                        <? $sql = "SELECT replid,proses FROM prosespenerimaansiswa WHERE aktif=1 AND departemen='$departemen'";				
                        $result = QueryDb($sql);
                        $proses = 0;
                        $namaproses = "";
                        if (mysqli_num_rows($result) > 0)
                        {
                            $row = mysqli_fetch_array($result);
                            $proses = $row['replid'];
                            $namaproses = $row['proses'];
                        } ?>
                        <input type="text" name="nama_proses" id="nama_proses" class="bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-xl px-3 py-2 w-44 focus:outline-none" value="<?=$namaproses?>" readonly />
                        <input type="hidden" name="proses" id="proses" value="<?=$proses?>" />
                    </div>

                    <!-- Kelompok -->
                    <div class="flex items-center gap-2">
                        <label for="kelompok" class="text-xs font-extrabold text-slate-700 uppercase">Kelompok</label>
                        <div class="relative flex items-center gap-1.5">
                            <select name="kelompok" id="kelompok" onchange="change_kelompok(0)" onKeyPress="return focusNext('tabel', event)" onfocus="panggil('kelompok')" class="appearance-none bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-64 pl-3 pr-8 py-2 shadow-sm transition-all cursor-pointer">
                                <? $sql = "SELECT replid,kelompok,kapasitas FROM kelompokcalonsiswa WHERE idproses = '$proses' ORDER BY kelompok";
                                $result = QueryDb($sql);	
                                while ($row = @mysqli_fetch_array($result)) 
                                {
                                    if ($kelompok == "") 
                                        $kelompok = $row['replid'];
                                    
                                    $sql1 = "SELECT COUNT(replid) FROM calonsiswa WHERE idkelompok = '$row[replid]' AND aktif = 1";
                                    $result1 = QueryDb($sql1);				
                                    $row1 = mysqli_fetch_row($result1);	?>
                                    <option value="<?=urlencode($row['replid'])?>" <?=IntIsSelected($row['replid'], $kelompok)?> ><?=$row['kelompok'].', Kapasitas: '.$row['kapasitas'] .', Terisi: '.$row1[0]?></option>
                                <? } ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-7 flex items-center px-2 text-slate-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </div>
                            
                            <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                <button type="button" onclick="tampil_kelompok();" class="p-2 bg-emerald-900 hover:bg-emerald-800 text-white rounded-xl transition-all shadow-md active:scale-95 flex items-center justify-center w-8 h-8" onMouseOver="showhint('Tambah Kelompok!', this, event, '60px')">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            <? } ?>
                        </div>
                    </div>

                </div>

                <!-- Search/View Button (emerald-900) -->
                <div>
                    <button type="button" onclick="show_calon()" id="tabel" name="tabel" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-extrabold text-xs py-2.5 px-5 rounded-xl shadow-lg shadow-emerald-900/30 transition-all duration-200 active:scale-95" onmouseover="showhint('Klik untuk menampilkan data calon siswa!', this, event, '120px')">
                        <i class="fa-solid fa-magnifying-glass"></i> TAMPILKAN DATA
                    </button>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
<?
CloseDb();
?>