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

$proses = "";
if (isset($_REQUEST['proses']))
	$proses = $_REQUEST['proses'];

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];

$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

$urut = "kelompok";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];
	
$op = "";
if (isset($_REQUEST['op']))
	$op = $_REQUEST['op'];

if ($op == "xm8r389xemx23xb2378e23") {
	OpenDb();
	$sql = "DELETE FROM kelompokcalonsiswa WHERE replid = '$_REQUEST[replid]'";
	QueryDb($sql);
	CloseDb();	
$page=0;
$hal=0;
}	
OpenDb();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelompok Calon Siswa</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="../script/SpryValidationSelect.js" type="text/javascript"></script>
    <link href="../script/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    <script language="javascript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
    function tambah() {
        var departemen = document.getElementById('departemen').value;
        var id = document.getElementById('proses').value;
        newWindow('kelompok_add.php?departemen='+departemen+'&id='+id, 'TambahKelompokCalonSiswa','500','340','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function refresh() {
        var departemen = document.getElementById('departemen').value;
        var proses= document.getElementById('proses').value;

        document.location.href = "kelompok.php?departemen="+departemen+"&proses="+proses;	
    }

    function tampil() {
        var departemen = document.getElementById('departemen').value;
        document.location.href = "kelompok.php?departemen="+departemen+"&varbaris=<?=$varbaris?>";
    }

    function edit(replid) {
        newWindow('kelompok_edit.php?replid='+replid, 'UbahKelompokCalonSiswa','500','340','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function hapus(replid) {
        var departemen = document.getElementById('departemen').value;
        var proses = document.getElementById('proses').value;
        var urut = document.getElementById('urut').value;
        var urutan = document.getElementById('urutan').value;
        if (confirm("Apakah anda yakin akan menghapus kelompok ini?"))
            document.location.href = "kelompok.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&proses="+proses+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
    }

    function lihat(replid) {
        var departemen = document.getElementById('departemen').value;
        var proses = document.getElementById('proses').value;
        newWindow('kelompok_detail.php?replid='+replid+'&departemen='+departemen+'&proses='+proses, 'DaftarCalonSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function cetak(urut,urutan) {
        var departemen = document.getElementById('departemen').value;
        var proses = document.getElementById('proses').value;
        var total=document.getElementById("total").value;
            
        newWindow('kelompok_cetak.php?departemen='+departemen+'&proses='+proses+'&urut='+urut+'&urutan='+urutan+'&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakKelompokCalonSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function change_urut(urut,urutan) {		
        var departemen = document.getElementById('departemen').value;
        var proses= document.getElementById('proses').value;
        var varbaris=document.getElementById("varbaris").value;
            
        if (urutan =="ASC"){
            urutan="DESC"
        } else {
            urutan="ASC"
        }
        
        document.location.href = "kelompok.php?departemen="+departemen+"&proses="+proses+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris="+varbaris;
    }

    function change_page(page) {
        var departemen=document.getElementById("departemen").value;
        var proses= document.getElementById('proses').value;
        var varbaris=document.getElementById("varbaris").value;
        
        document.location.href="kelompok.php?departemen="+departemen+"&proses="+proses+"&page="+page+"&hal="+page+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }

    function change_hal() {
        var departemen = document.getElementById("departemen").value;
        var proses= document.getElementById('proses').value;
        var hal = document.getElementById("hal").value;
        var varbaris=document.getElementById("varbaris").value;
        
        document.location.href="kelompok.php?departemen="+departemen+"&proses="+proses+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }

    function change_baris() {
        var departemen = document.getElementById("departemen").value;
        var proses= document.getElementById('proses').value;
        var varbaris=document.getElementById("varbaris").value;
        
        document.location.href="kelompok.php?departemen="+departemen+"&proses="+proses+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden" onload="document.getElementById('departemen').focus()">
    <input type="hidden" name="urut" id="urut" value="<?=$urut ?>" />
    <input type="hidden" name="urutan" id="urutan" value="<?=$urutan ?>" />

    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <!-- Background icon emerald-900 -->
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-users-viewfinder text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Penerimaan Siswa Baru</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">KELOMPOK CALON SISWA</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../siswa_baru.php" target="content" class="text-emerald-700 hover:underline font-semibold">PSB</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Kelompok Calon</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Departemen -->
                <div class="flex items-center gap-3">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="tampil()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                            <? $dep = getDepartemen(SI_USER_ACCESS());    
                            foreach($dep as $value) {
                                if ($departemen == "")
                                    $departemen = $value; ?>
                                <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Proses Penerimaan -->
                <div class="flex items-center gap-3">
                    <label class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Proses Penerimaan</label>
                    <? $sql = "SELECT replid,proses FROM prosespenerimaansiswa WHERE aktif=1 AND departemen='$departemen'";				
                    $result = QueryDb($sql);
                    if (@mysqli_num_rows($result)>0){
                        $row = mysqli_fetch_array($result);
                        $proses = $row['replid'];
                    } else {
                        $proses = "";
                    } ?>
                    <input type="text" name="nama_proses" id="nama_proses" class="bg-slate-100 border border-slate-200 text-slate-500 text-xs font-bold rounded-xl px-4 py-2.5 w-56 focus:outline-none" value="<?=@$row['proses']?>" readonly />
                    <input type="hidden" name="proses" id="proses" value="<?=$proses?>" />
                </div>
            </div>

            <?
            OpenDb();
            if ($proses!="") {
                $sql_tot = "SELECT replid,kelompok,kapasitas,keterangan FROM kelompokcalonsiswa WHERE idproses='$proses'";
                $result_tot = QueryDb($sql_tot);
                $total = @ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
                $jumlah = @mysqli_num_rows($result_tot);
                                    
                $sql = "SELECT replid,kelompok,kapasitas,keterangan FROM kelompokcalonsiswa WHERE idproses='$proses' ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris"; 						
                $akhir = @ceil($jumlah/5)*5;
                
                $result = QueryDb($sql);
                if (@mysqli_num_rows($result) > 0) {
            ?>
            <input type="hidden" name="total" id="total" value="<?=$total?>"/>

            <!-- Action Buttons -->
            <div class="flex flex-wrap items-center gap-2.5">
                <button onClick="refresh()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-arrows-rotate text-emerald-600"></i> Refresh
                </button>
                <button onClick="JavaScript:cetak('<?=$urut?>','<?=$urutan?>')" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-print text-sky-600"></i> Cetak
                </button>
                <button onClick="JavaScript:tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-4 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-plus"></i> Tambah Kelompok
                </button>
            </div>
        </div>

        <!-- Premium Modern Table -->
        <div class="overflow-hidden border border-slate-100 rounded-3xl shadow-sm bg-white mb-6">
            <table class="w-full text-left border-collapse" id="table">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase text-xs font-bold tracking-wider select-none">
                        <th class="py-4 px-6 text-center w-16">No</th>       
                        <th class="py-4 px-6 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('kelompok','<?=$urutan?>')">
                            Kelompok <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-6 text-center cursor-pointer hover:bg-slate-100 transition-colors w-32" onClick="change_urut('kapasitas','<?=$urutan?>')">
                            Kapasitas <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-6 text-center w-36">Terisi</th>
                        <th class="py-4 px-6">Keterangan</th>
                        <th class="py-4 px-6 text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-800">
                    <?    
                    if ($page==0)
                        $i = 0;
                    else 
                        $i = (int)$page*(int)$varbaris;
                        
                    while ($row = @mysqli_fetch_array($result)) {
                    ?>
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td class="py-3.5 px-6 text-center text-slate-400 font-semibold"><?=++$i?></td>
                        <td class="py-3.5 px-6 text-slate-900 font-extrabold"><?=$row['kelompok']?></td>
                        <td class="py-3.5 px-6 text-center text-emerald-800 font-bold bg-emerald-50/20"><?=$row['kapasitas']?></td>
                        <td class="py-3.5 px-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <?	$sql1 = "SELECT COUNT(*) FROM calonsiswa WHERE idkelompok='$row[replid]' AND aktif = 1";
                                $result1 = QueryDb($sql1);
                                $row1 = @mysqli_fetch_row($result1); ?>
                                <span class="bg-slate-100 px-2.5 py-1 rounded-lg text-xs font-bold text-slate-700">
                                    <?=$row1[0];?>
                                </span>
                                <? if ($row1[0] > 0 ) { ?>  
                                    <button onClick="JavaScript:lihat(<?=$row['replid']?>)" class="p-1.5 text-emerald-700 hover:bg-emerald-50 rounded-lg transition-colors" title="Lihat Daftar Calon Siswa">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                    </button>
                                <? } ?>
                            </div>
                        </td>        
                        <td class="py-3.5 px-6 text-slate-500"><?=$row['keterangan']?></td>
                        <td class="py-3.5 px-6 text-center">    
                            <div class="flex items-center justify-center gap-2">
                                <button onClick="JavaScript:edit(<?=$row['replid'] ?>)" class="p-2 text-sky-600 hover:bg-sky-50 rounded-xl transition-colors" title="Ubah Kelompok">
                                    <i class="fa-solid fa-pen-to-square text-base"></i>
                                </button>
                                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                    <button onClick="JavaScript:hapus(<?=$row['replid'] ?>)" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus Kelompok">
                                        <i class="fa-solid fa-trash-can text-base"></i>
                                    </button>
                                <? } ?>
                            </div>
                        </td>   
                    </tr>
                    <? } CloseDb(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination & Row Count Control Bar -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-2.5 text-sm text-slate-600 font-semibold">
                <span>Halaman</span>
                <div class="relative">
                    <select name="hal" id="hal" onChange="change_hal()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl pl-3 pr-8 py-1.5 focus:ring-emerald-500 shadow-sm cursor-pointer">
                        <?	for ($m=0; $m<$total; $m++) {?>
                             <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
                        <? } ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
                <span>dari <strong class="text-slate-900"><?=$total?></strong> halaman</span>
            </div>

            <div class="flex items-center gap-2.5 text-sm text-slate-600 font-semibold">
                <span>Jumlah baris per halaman</span>
                <div class="relative">
                    <select name="varbaris" id="varbaris" onChange="change_baris()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-bold rounded-xl pl-3 pr-8 py-1.5 focus:ring-emerald-500 shadow-sm cursor-pointer">
                        <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
                            <option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
                        <? 	} ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </div>
        </div>

        <?	} else { ?>
            <!-- Fallback No Data State -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-12 text-center max-w-xl mx-auto mt-12">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-inner">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-2">Tidak ditemukan adanya data</h3>
                <p class="text-xs text-slate-500 mb-6">Silakan buat kelompok calon siswa baru untuk mendaftarkan kuota penerimaan kelas.</p>
                <button onClick="JavaScript:tambah()" class="inline-flex items-center gap-2 bg-emerald-950 hover:bg-emerald-900 text-white font-bold text-xs py-3 px-6 rounded-2xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-plus"></i> Tambah Kelompok Baru
                </button>
            </div>
        <? } 
        } else { ?>
            <!-- Fallback No Process Warning State -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-md p-12 text-center max-w-xl mx-auto mt-12">
                <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-2xl mx-auto mb-6 shadow-inner">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <? if ($departemen != "") { ?>  
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Proses Penerimaan Belum Ada</h3>
                    <p class="text-xs text-slate-500">Silakan isi terlebih dahulu data Proses Penerimaan Siswa Baru untuk Departemen <strong class="text-slate-800 font-bold"><?=$departemen?></strong> pada bagian PSB.</p>
                <? } else { ?>
                    <h3 class="text-lg font-bold text-slate-800 mb-2">Belum ada data Departemen</h3>
                    <p class="text-xs text-slate-500">Silakan isi terlebih dahulu di menu Departemen pada bagian Referensi.</p>
                <? } ?>    
            </div>
        <? } ?>

    </div>
</body>
</html>
<script language="javascript">
var spryselect = new Spry.Widget.ValidationSelect("departemen");
</script>