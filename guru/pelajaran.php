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

$varbaris=10;
if (isset($_REQUEST['varbaris']))
	$varbaris = $_REQUEST['varbaris'];
	
$page=0;
if (isset($_REQUEST['page']))
	$page = $_REQUEST['page'];

$hal=0;
if (isset($_REQUEST['hal']))
	$hal = $_REQUEST['hal'];

$urut = "nama";	
if (isset($_REQUEST['urut']))
	$urut = $_REQUEST['urut'];	

$urutan = "ASC";	
if (isset($_REQUEST['urutan']))
	$urutan = $_REQUEST['urutan'];

$op = "";
if (isset($_REQUEST['op']))
    $op = $_REQUEST['op'];

if ($op == "dw8dxn8w9ms8zs22") {
	$newaktif=(int)$_REQUEST['newaktif'];
	$replid=(int)$_REQUEST['replid'];
	OpenDb();
	$sql = "UPDATE pelajaran SET aktif = '$newaktif' WHERE replid = '$replid' ";
	QueryDb($sql);
	CloseDb();
} else if ($op == "xm8r389xemx23xb2378e23") {
	$replid=(int)$_REQUEST['replid'];
	OpenDb();
	$sql = "DELETE FROM pelajaran WHERE replid = '$replid'";
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
    <title>Daftar Pelajaran</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
    function tambah() {
        var departemen = document.getElementById('departemen').value;	
        newWindow('pelajaran_add.php?departemen='+departemen, 'TambahDaftarPelajaran','500','340','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function refresh() {
        var departemen = document.getElementById('departemen').value;
        document.location.href = "pelajaran.php?departemen="+departemen;	
    }

    function tampil() {
        var departemen = document.getElementById('departemen').value;
        document.location.href = "pelajaran.php?departemen="+departemen;
    }

    function setaktif(replid, aktif) {
        var msg;
        var newaktif;
        var departemen = document.getElementById('departemen').value;
        var urut = document.getElementById('urut').value;
        var urutan = document.getElementById('urutan').value;
        
        if (aktif == 1) {
            msg = "Apakah anda yakin akan mengubah daftar pelajaran ini menjadi TIDAK AKTIF?";
            newaktif = 0;
        } else	{	
            msg = "Apakah anda yakin akan mengubah daftar pelajaran ini menjadi AKTIF?";
            newaktif = 1;
        }
        
        if (confirm(msg)) 
        document.location.href = "pelajaran.php?op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
    }

    function edit(replid) {
        newWindow('pelajaran_edit.php?replid='+replid, 'UbahDaftarPelajaran','500','340','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function hapus(replid) {
        var departemen = document.getElementById('departemen').value;
        var urut = document.getElementById('urut').value;
        var urutan = document.getElementById('urutan').value;
        if (confirm("Apakah anda yakin akan menghapus daftar pelajaran ini?"))
            document.location.href = "pelajaran.php?op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
    }

    function cetak(urut,urutan) {
        var departemen = document.getElementById('departemen').value;
        var total = document.getElementById('total').value;
        newWindow('pelajaran_cetak.php?departemen='+departemen+'&urut='+urut+'&urutan='+urutan+'&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakDaftarPelajaran','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function change_urut(urut,urutan) {		
        var departemen = document.getElementById('departemen').value;
        var varbaris=document.getElementById("varbaris").value;
        
        if (urutan =="ASC"){
            urutan="DESC"
        } else {
            urutan="ASC"
        }
        
        document.location.href = "pelajaran.php?departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris="+varbaris;	
    }

    function change_hal() {
        var departemen = document.getElementById("departemen").value;
        var hal = document.getElementById("hal").value;
        var varbaris=document.getElementById("varbaris").value;
        
        document.location.href="pelajaran.php?departemen="+departemen+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }

    function change_baris() {
        var departemen = document.getElementById("departemen").value;
        var varbaris=document.getElementById("varbaris").value;
        
        document.location.href="pelajaran.php?departemen="+departemen+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <input type="hidden" name="urut" id="urut" value="<?=$urut ?>" />
    <input type="hidden" name="urutan" id="urutan" value="<?=$urutan ?>" />

    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <!-- Background icon emerald-900 -->
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-book text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Guru & Pelajaran</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">DAFTAR PELAJARAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../guru.php?page=p" target="content" class="text-emerald-700 hover:underline font-semibold">Guru & Pelajaran</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Pelajaran</span>
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
            </div>

            <? 	
            $sql_tot = "SELECT replid FROM pelajaran WHERE departemen='$departemen'";    
            $result_tot = QueryDb($sql_tot);
            $total = @ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
            $jumlah = @mysqli_num_rows($result_tot);
            $akhir = @ceil($jumlah/5)*5;
            
            $sql = "SELECT p.replid, p.kode, p.nama, p.sifat, p.keterangan, p.aktif, k.kelompok 
                      FROM pelajaran p, kelompokpelajaran k
                     WHERE p.idkelompok = k.replid
                       AND p.departemen = '$departemen' 
                     ORDER BY $urut $urutan LIMIT " . (int)$page * (int)$varbaris . ", $varbaris";
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
                    <i class="fa-solid fa-plus"></i> Tambah Pelajaran
                </button>
            </div>
        </div>

        <!-- Premium Modern Table -->
        <div class="overflow-hidden border border-slate-100 rounded-3xl shadow-sm bg-white mb-6">
            <table class="w-full text-left border-collapse" id="table">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-700 uppercase text-xs font-bold tracking-wider select-none">
                        <th class="py-4 px-6 text-center w-16">No</th>       
                        <th class="py-4 px-6 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('p.kode','<?=$urutan?>')">
                            Singkatan <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-6 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('p.nama','<?=$urutan?>')">
                            Nama <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-6 text-center cursor-pointer hover:bg-slate-100 transition-colors w-32" onClick="change_urut('p.sifat','<?=$urutan?>')">
                            Sifat <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-6 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('k.kelompok','<?=$urutan?>')">
                            Kelompok <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-6">Keterangan</th>
                        <th class="py-4 px-6 text-center w-24 cursor-pointer hover:bg-slate-100 transition-colors" onClick="change_urut('p.aktif','<?=$urutan?>')">
                            Status <i class="fa-solid fa-sort ml-1 text-slate-400"></i>
                        </th>
                        <th class="py-4 px-6 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-800">
                    <?    
                    if ($page==0)
                        $cnt = 0;
                    else 
                        $cnt = (int)$page*(int)$varbaris;
                        
                    while ($row = @mysqli_fetch_array($result)) {
                    ?>
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                        <td class="py-3.5 px-6 text-center text-slate-400 font-semibold"><?=++$cnt?></td>
                        <td class="py-3.5 px-6 text-emerald-800 font-bold"><?=$row['kode']?></td>
                        <td class="py-3.5 px-6 text-slate-900 font-extrabold"><?=$row['nama']?></td>
                        <td class="py-3.5 px-6 text-center">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider <?=$row['sifat'] == 1 ? 'bg-blue-50 text-blue-600 border border-blue-100' : 'bg-slate-100 text-slate-600 border border-slate-200'?>">
                                <?=$row['sifat'] == 1 ? 'Wajib' : 'Tambahan'?>
                            </span>
                        </td>
                        <td class="py-3.5 px-6 text-slate-700"><?=$row['kelompok']?></td>
                        <td class="py-3.5 px-6 text-slate-500 italic text-xs"><?=$row['keterangan']?></td>
                        <td class="py-3.5 px-6 text-center">
                            <button onClick="JavaScript:setaktif(<?=$row['replid'] ?>, <?=$row['aktif'] ?>)" class="transition-transform active:scale-90">
                                <? if ($row['aktif'] == 1) { ?>
                                    <i class="fa-solid fa-toggle-on text-2xl text-emerald-500"></i>
                                <? } else { ?>
                                    <i class="fa-solid fa-toggle-off text-2xl text-slate-300"></i>
                                <? } ?>
                            </button>
                        </td>
                        <td class="py-3.5 px-6 text-center">    
                            <div class="flex items-center justify-center gap-2">
                                <button onClick="JavaScript:edit(<?=$row['replid'] ?>)" class="p-2 text-sky-600 hover:bg-sky-50 rounded-xl transition-colors" title="Ubah">
                                    <i class="fa-solid fa-pen-to-square text-base"></i>
                                </button>
                                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                    <button onClick="JavaScript:hapus(<?=$row['replid'] ?>)" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus">
                                        <i class="fa-solid fa-trash-can text-base"></i>
                                    </button>
                                <? } ?>
                            </div>
                        </td>   
                    </tr>
                    <? } ?>
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
                <p class="text-xs text-slate-500 mb-6">Silakan buat data pelajaran baru untuk departemen <strong class="text-slate-800 font-bold"><?=$departemen?></strong>.</p>
                <button onClick="JavaScript:tambah()" class="inline-flex items-center gap-2 bg-emerald-950 hover:bg-emerald-900 text-white font-bold text-xs py-3 px-6 rounded-2xl shadow-md transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-plus"></i> Tambah Pelajaran Baru
                </button>
            </div>
        <? } ?>

    </div>
</body>
</html>
<? CloseDb(); ?>
