<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

$departemen=$_REQUEST['departemen'];
$tingkat=$_REQUEST['tingkat'];
$tahunajaran=$_REQUEST['tahunajaran'];

$urut = "kelas";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];

$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];
	
$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

OpenDb();
$sql_get_tingkat="SELECT tingkat FROM tingkat WHERE replid='$tingkat'";
$result_get_tingkat = QueryDB($sql_get_tingkat);
$row_get_tingkat = @mysqli_fetch_row($result_get_tingkat);
$nama_tingkat=$row_get_tingkat[0];
	
$sql_get_tahunajaran = "SELECT tahunajaran FROM tahunajaran WHERE replid='$tahunajaran'";  
$result_get_tahunajaran = QueryDB($sql_get_tahunajaran);
$row_get_tahunajaran = @mysqli_fetch_row($result_get_tahunajaran);
$nama_tahunajaran=$row_get_tahunajaran[0];
CloseDb();

$op = "";
if (isset($_REQUEST['op']))
	$op = $_REQUEST['op'];

	
if ($op == "dw8dxn8w9ms8zs22") {
	$replid = "";
	if (isset($_REQUEST['replid']))
		$replid = $_REQUEST['replid'];
		
	OpenDb();
	$sql = "UPDATE kelas SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
	$result=QueryDb($sql);
	if ($result)
		CloseDb();
			
} else if ($op == "xm8r389xemx23xb2378e23") {
		$replid = "";
		if (isset($_REQUEST['replid']))
		$replid = $_REQUEST['replid'];
	OpenDb();
	$sql = "DELETE FROM kelas WHERE replid = '$_REQUEST[replid]'";
	QueryDb($sql);
	$result=QueryDb($sql);
	if ($result) { 
	CloseDb();
	?>
    <script language="javascript">
    document.location.href="bottomkelas.php?departemen=<?=$departemen?>&tingkat=<?=$tingkat?>&tahunajaran=<?=$tahunajaran?>";
    </script>
	<?			 }
	
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kelas</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
<link rel="stylesheet" type="text/css" href="../style/tooltips.css">
<script language="javascript" src="../script/tooltips.js"></script>
<script language="javascript" src="../script/tables.js"></script>
<script language="javascript" src="../script/tools.js"></script>
<script language="javascript">
function carisiswa(replid) {	
	newWindow('../library/lihatsiswa.php?replid='+replid, 'LihatSiswa','790','650','resizable=1,scrollbars=1,status=0,toolbar=0');
}

function tambah() {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	
	newWindow('kelas_add.php?departemen='+departemen+'&tingkat='+tingkat+'&tahunajaran='+tahunajaran, 'TambahKelas','500','395','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function refresh() {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	
	document.location.href = "bottomkelas.php?tingkat="+tingkat+"&departemen="+departemen+"&tahunajaran="+tahunajaran;
}

function setaktif(replid, aktif) {
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var departemen = document.getElementById('departemen').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
	
	var msg;
	var newaktif;
	
	if (aktif == 1) {
		msg = "Apakah anda yakin akan mengubah kelas ini menjadi TIDAK AKTIF?";
		newaktif = 0;
	} else	{	
		msg = "Apakah anda yakin akan mengubah kelas ini menjadi AKTIF?";
		newaktif = 1;
	}
	
	if (confirm(msg)) 
		document.location.href = "bottomkelas.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+'&departemen='+departemen+'&tingkat='+tingkat+'&tahunajaran='+tahunajaran+'&urut='+urut+'&urutan='+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function edit(replid) {
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var departemen = document.getElementById('departemen').value;	
	
	newWindow('kelas_edit.php?replid='+replid+'&departemen='+departemen+'&tingkat='+tingkat+'&tahunajaran='+tahunajaran, 'UbahKelas','500','395','resizable=1,scrollbars=1,status=0,toolbar=0')
}

function hapus(replid) {
	var tingkat = document.getElementById('tingkat').value;
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var urut = document.getElementById('urut').value;
	var urutan = document.getElementById('urutan').value;
		
	if (confirm("Apakah anda yakin akan menghapus kelas ini?"))
		document.location.href = "bottomkelas.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
}

function cetak(urut,urutan) {
	var namatahunajaran = document.getElementById('namatahunajaran').value;
	var namatingkat = document.getElementById('namatingkat').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var departemen = document.getElementById('departemen').value;
	var total=document.getElementById("total").value;
	
	newWindow('kelas_cetak.php?departemen='+departemen+'&tingkat='+tingkat+'&tahunajaran='+tahunajaran+'&namatahunajaran='+namatahunajaran+'&namatingkat='+namatingkat+'&urut='+urut+'&urutan='+urutan+'&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakKelas','790','650','resizable=1,scrollbars=1,status=0,toolbar=0');
	
}

function change_urut(urut,urutan) {		
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var varbaris=document.getElementById("varbaris").value;
	
	if (urutan =="ASC"){
		urutan="DESC"
	} else {
		urutan="ASC"
	}
	
	document.location.href = "bottomkelas.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris="+varbaris;
}

function change_page(page) {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="bottomkelas.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&page="+page+"&hal="+page+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function change_hal() {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var hal = document.getElementById("hal").value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="bottomkelas.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}

function change_baris() {
	var departemen = document.getElementById('departemen').value;
	var tahunajaran = document.getElementById('tahunajaran').value;
	var tingkat = document.getElementById('tingkat').value;
	var varbaris=document.getElementById("varbaris").value;
	
	document.location.href="bottomkelas.php?departemen="+departemen+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
}
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 select-none overflow-x-hidden p-2">

<input type="hidden" name="departemen" id="departemen" value="<?=$departemen?>"/>
<input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran?>"/>
<input type="hidden" name="tingkat" id="tingkat" value="<?=$tingkat?>"/>
<input type="hidden" name="namatahunajaran" id="namatahunajaran" value="<?=$nama_tahunajaran?>"/>
<input type="hidden" name="namatingkat" id="namatingkat" value="<?=$nama_tingkat?>"/>
<input type="hidden" name="urut" id="urut" value="<?=$urut?>"/>
<input type="hidden" name="urutan" id="urutan" value="<?=$urutan?>"/>

<? 
	OpenDb();
	$sql_tot = "SELECT k.replid FROM kelas k, tahunajaran t, jbssdm.pegawai p WHERE t.replid='$tahunajaran' AND k.idtahunajaran=t.replid AND k.nipwali=p.nip AND t.departemen='$departemen' AND k.idtingkat='$tingkat' GROUP BY k.replid";
	$result_tot = QueryDb($sql_tot);
	$total = ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
	$jumlah = mysqli_num_rows($result_tot);
	$akhir = ceil($jumlah/5)*5;
	
	$sql_kelas = "SELECT k.replid, k.kelas, k.idtahunajaran, k.kapasitas, k.nipwali, k.aktif, k.keterangan, t.replid, t.tahunajaran, t.departemen, p.nama FROM kelas k, tahunajaran t, jbssdm.pegawai p WHERE t.replid='$tahunajaran' AND k.idtahunajaran=t.replid AND k.nipwali=p.nip AND t.departemen='$departemen' AND k.idtingkat='$tingkat' GROUP BY k.replid ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
	$result_kelas = QueryDb($sql_kelas);
	
	if (@mysqli_num_rows($result_kelas) > 0){
?>
<input type="hidden" name="total" id="total" value="<?=$total?>"/>

<!-- Actions Bar -->
<div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-4 flex items-center justify-between">
    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Daftar Kelas</span>
    <div class="flex items-center gap-2">
        <button onClick="refresh()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-[10px] py-2 px-3 rounded-xl transition-all">
            <i class="fa-solid fa-arrows-rotate text-emerald-600"></i> Refresh
        </button>
        <button onClick="JavaScript:cetak('<?=$urut?>','<?=$urutan?>')" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-[10px] py-2 px-3 rounded-xl transition-all">
            <i class="fa-solid fa-print text-sky-600"></i> Cetak
        </button>
        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
        <button onClick="JavaScript:tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-[10px] py-2 px-4 rounded-xl shadow-md transition-all active:scale-95">
            <i class="fa-solid fa-plus"></i> Tambah Kelas
        </button>
        <? } ?>
    </div>
</div>

<!-- Premium Table -->
<div class="overflow-hidden border border-slate-100 rounded-2xl shadow-sm bg-white mb-4">
    <table class="w-full text-left border-collapse" id="table">
        <thead>
            <tr class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase text-[10px] font-bold tracking-wider">
                <th class="py-3 px-4 text-center w-12">No</th>
                <th class="py-3 px-4 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('kelas','<?=$urutan?>')">Kelas</th>
                <th class="py-3 px-4 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('p.nama','<?=$urutan?>')">Wali Kelas</th>
                <th class="py-3 px-4 text-center w-24" onClick="change_urut('kapasitas','<?=$urutan?>')">Kapasitas</th>
                <th class="py-3 px-4 text-center w-20">Terisi</th>
                <th class="py-3 px-4">Keterangan</th>
                <th class="py-3 px-4 text-center w-28">Status</th>
                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                <th class="py-3 px-4 text-center w-28">Aksi</th>
                <? } ?>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs font-medium text-slate-800">
 <?	
	if ($page==0)
		$cnt = 0;
	else 
		$cnt = (int)$page*(int)$varbaris;

	while ($row_kelas = @mysqli_fetch_row($result_kelas)) {
		$kelas=$row_kelas[0];
		$sql_get_jumsiswa = "SELECT COUNT(*) FROM jbsakad.siswa s WHERE s.idkelas='$kelas' AND s.aktif=1";
		$result_get_jumsiswa = QueryDB($sql_get_jumsiswa);
		if ($row_get_jumsiswa = mysqli_fetch_row($result_get_jumsiswa)){
			$terisi = $row_get_jumsiswa[0];
		} else {
			$terisi = 0;
		}
?>
<tr class="hover:bg-slate-50/50 transition-colors duration-150">
    <td class="py-2.5 px-4 text-center text-slate-400 font-semibold"><?=++$cnt ?></td>
    <td class="py-2.5 px-4 text-emerald-850 font-bold"><?=$row_kelas[1]?></td>
    <td class="py-2.5 px-4"><?=$row_kelas[4] . " " . $row_kelas[10] ?></td>
    <td class="py-2.5 px-4 text-center font-bold"><?=$row_kelas[3] ?></td>
    <td class="py-2.5 px-4 text-center">
        <div class="flex items-center justify-center gap-1.5">
            <span class="font-bold <?php echo $terisi > 0 ? 'text-emerald-700' : 'text-slate-400'; ?>"><?php echo $terisi; ?></span>
            <? if ($terisi > 0) { ?>
                <button onClick="JavaScript:carisiswa(<?=$row_kelas[0]?>)" class="text-slate-400 hover:text-emerald-600 transition-colors">
                    <i class="fa-solid fa-circle-info"></i>
                </button>
            <? } ?>
        </div>
    </td>
    <td class="py-2.5 px-4 text-slate-500 text-[10px]"><?= $row_kelas[6] ?></td>
    <td class="py-2.5 px-4 text-center">  
<?		if (SI_USER_LEVEL() == $SI_USER_STAFF) {  
			if ($row_kelas[5] == 1) { ?> 
                <span class="inline-flex items-center gap-1 py-1 px-2 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                    <span class="w-1 h-1 rounded-full bg-emerald-600"></span> Aktif
                </span>
<?			} else { ?>                
                <span class="inline-flex items-center gap-1 py-1 px-2 rounded-lg bg-slate-100 text-slate-500 text-[10px] font-bold">
                    <span class="w-1 h-1 rounded-full bg-slate-400"></span> Nonaktif
                </span>
<?			}
		} else { 
			if ($row_kelas[5] == 1) { ?>
                <button onClick="JavaScript:setaktif(<?=$row_kelas[0] ?>, <?=$row_kelas[5] ?>)" class="inline-flex items-center gap-1 py-1 px-2 rounded-lg bg-emerald-100 hover:bg-emerald-200 text-emerald-800 text-[10px] font-bold shadow-sm transition-colors">
                    <span class="w-1 h-1 rounded-full bg-emerald-600"></span> Aktif
                </button>
<?			} else { ?>
                <button onClick="JavaScript:setaktif(<?=$row_kelas[0] ?>, <?=$row_kelas[5] ?>)" class="inline-flex items-center gap-1 py-1 px-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 text-[10px] font-bold border border-slate-200 transition-colors">
                    <span class="w-1 h-1 rounded-full bg-slate-400"></span> Nonaktif
                </button>
<?			} //end if
		} //end if ?>        
    </td>
    <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>     
    <td class="py-2.5 px-4 text-center">
        <div class="flex items-center justify-center gap-1">
            <button onClick="JavaScript:edit(<?=$row_kelas[0] ?>)" class="p-1.5 text-sky-600 hover:bg-sky-50 rounded-lg transition-colors">
                <i class="fa-solid fa-pen-to-square"></i>
            </button>
            <button onClick="JavaScript:hapus(<?=$row_kelas[0] ?>)" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </div>
    </td>
    <? } ?> 
</tr>
<?	} ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-2 text-xs text-slate-600 font-semibold">
        <span>Halaman</span>
        <div class="relative">
            <select name="hal" id="hal" onChange="change_hal()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 font-bold rounded-lg pl-2 pr-6 py-1 focus:ring-emerald-500 cursor-pointer">
                <?	for ($m=0; $m<$total; $m++) {?>
                     <option value="<?=$m ?>" <?=IntIsSelected($hal,$m) ?>><?=$m+1 ?></option>
                <? } ?>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-400">
                <i class="fa-solid fa-chevron-down text-[8px]"></i>
            </div>
        </div>
        <span>dari <strong class="text-slate-900"><?=$total?></strong> halaman</span>
    </div>

    <div class="flex items-center gap-2 text-xs text-slate-600 font-semibold">
        <span>Baris per halaman</span>
        <div class="relative">
            <select name="varbaris" id="varbaris" onChange="change_baris()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 font-bold rounded-lg pl-2 pr-6 py-1 focus:ring-emerald-500 cursor-pointer">
                <? 	for ($m=5; $m <= $akhir; $m=$m+5) { ?>
                    <option value="<?=$m ?>" <?=IntIsSelected($varbaris,$m) ?>><?=$m ?></option>
                <? 	} ?>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1.5 text-slate-400">
                <i class="fa-solid fa-chevron-down text-[8px]"></i>
            </div>
        </div>
    </div>
</div>

<?	} else { ?>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-md p-10 text-center mt-10">
        <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center text-xl mx-auto mb-4">
            <i class="fa-solid fa-folder-open"></i>
        </div>
        <h3 class="text-sm font-bold text-slate-800 mb-1">Tidak ditemukan adanya data</h3>
        <p class="text-[10px] text-slate-500 mb-4">Silakan periksa filter Anda atau buat data kelas baru.</p>
        <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
            <button onClick="JavaScript:tambah()" class="inline-flex items-center gap-2 bg-emerald-950 hover:bg-emerald-900 text-white font-bold text-[10px] py-2 px-4 rounded-xl shadow-md transition-all active:scale-95">
                <i class="fa-solid fa-plus"></i> Tambah Kelas Baru
            </button>
        <? } ?>
    </div>
<? } ?> 

</body>
</html>