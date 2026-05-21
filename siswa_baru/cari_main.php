<?php
// =========================================================================
// INIT & INCLUDE FILES
// =========================================================================
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');

OpenDb();

// =========================================================================
// DEFINISI & PENANGKAPAN PARAMETER
// =========================================================================
$tipe = array(
    array("nopendaftaran","No. Pendaftaran"),
    array("nisn","N I S N"), 
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

$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$jenis      = isset($_REQUEST['jenis']) ? $_REQUEST['jenis'] : 'nopendaftaran';
$cari       = isset($_REQUEST['cari']) ? $_REQUEST['cari'] : '';
$action     = isset($_REQUEST['action']) ? $_REQUEST['action'] : ''; // Parameter penentu state view/blank

// Parameter paginasi dan sorting
$urut       = isset($_REQUEST['urut']) ? $_REQUEST['urut'] : "nopendaftaran";    
$urutan     = isset($_REQUEST['urutan']) ? $_REQUEST['urutan'] : "ASC";    
$varbaris   = isset($_REQUEST['varbaris']) ? $_REQUEST['varbaris'] : 20;
$page       = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
$hal        = isset($_REQUEST['hal']) ? $_REQUEST['hal'] : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Calon Siswa</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script language="javascript">
    // --- FUNGSI HEADER / FILTER ---
    function change_dep() {
        var departemen = document.getElementById('departemen').value;
        var jenis = document.getElementById('jenis').value;
        var cari = document.getElementById("cari").value;	
        document.location.href = "cari_main.php?cari="+encodeURIComponent(cari)+"&departemen="+encodeURIComponent(departemen)+"&jenis="+encodeURIComponent(jenis);	
    }

    function show_calon() {		
        var departemen = document.getElementById("departemen").value;
        var jenis = document.getElementById("jenis").value;		
        var cari = document.getElementById("cari").value;	
        
        if (cari == "") {
            alert ('Keyword tidak boleh kosong');
            document.getElementById("cari").focus();	
            return false;
        }
        
        if (jenis != 'kondisi' && jenis != 'status' && jenis != 'agama' && jenis != 'suku' && jenis != 'darah'){
            if (cari.length < 3 ){
                alert ('Keyword tidak boleh kurang dari 3 karakter');
                return false;
            }	
        }
        
        document.location.href = "cari_main.php?action=view&departemen="+encodeURIComponent(departemen)+"&jenis="+encodeURIComponent(jenis)+"&cari="+encodeURIComponent(cari);
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            if (elemName == 'tabel') {
                show_calon();
            } else {
                document.getElementById(elemName).focus();
            }
            return false;
        }
        return true;
    }

    // --- FUNGSI TABEL DATA ---
    var base_url = "cari_main.php?action=view";

    function refresh_content() {
        var departemen = document.getElementById('departemen').value;
        var jenis = document.getElementById('jenis').value;
        var cari = document.getElementById('cari').value;
        document.location.href = base_url + "&departemen="+encodeURIComponent(departemen)+"&jenis="+encodeURIComponent(jenis)+"&cari="+encodeURIComponent(cari);	
    }

    function tampil(replid) {
        window.open('../library/detail_calon.php?replid='+replid, 'DetailCalonSiswa'+replid,'width=790,height=610,resizable=1,scrollbars=1');
    }

    function edit(replid){
        window.open('calon_edit.php?replid='+replid,'UbahPendataanCalonSiswa','width=825,height=650,resizable=1,scrollbars=1');
    }

    function change_urut(urut_baru, urutan_lama) {		
        var departemen = document.getElementById('departemen').value;
        var jenis = document.getElementById('jenis').value;
        var cari = document.getElementById('cari').value;
        var urutan_baru = (urutan_lama == "ASC") ? "DESC" : "ASC";
        
        document.location.href = base_url + "&departemen="+encodeURIComponent(departemen)+"&jenis="+encodeURIComponent(jenis)+"&cari="+encodeURIComponent(cari)+"&urut="+urut_baru+"&urutan="+urutan_baru+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
    }

    function cetak() {
        var departemen = document.getElementById('departemen').value;
        var jenis = document.getElementById('jenis').value;
        var cari = document.getElementById('cari').value;
        var total = document.getElementById("total") ? document.getElementById("total").value : 0;
        
        window.open('cari_cetak.php?departemen='+encodeURIComponent(departemen)+'&jenis='+encodeURIComponent(jenis)+'&cari='+encodeURIComponent(cari)+'&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakCariCalonSiswa','width=790,height=650,resizable=1,scrollbars=1');
    }

    function cetak_excel() {	
        var departemen = document.getElementById('departemen').value;	
        var jenis = document.getElementById('jenis').value;
        var cari = document.getElementById('cari').value;
        
        window.open('cari_cetak_excel.php?departemen='+encodeURIComponent(departemen)+'&jenis='+encodeURIComponent(jenis)+'&cari='+encodeURIComponent(cari)+'&urut=<?=$urut?>&urutan=<?=$urutan?>', 'CetakCariCalonSiswaFormatExcel','width=790,height=650,resizable=1,scrollbars=1');
    }

    function change_hal() {
        var departemen = document.getElementById('departemen').value;
        var jenis = document.getElementById('jenis').value;
        var cari = document.getElementById('cari').value;
        var hal = document.getElementById("hal").value;
        var varbaris = document.getElementById("varbaris").value;
        
        document.location.href = base_url + "&departemen="+encodeURIComponent(departemen)+"&jenis="+encodeURIComponent(jenis)+"&cari="+encodeURIComponent(cari)+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }

    function change_baris() {
        var departemen = document.getElementById('departemen').value;
        var jenis = document.getElementById('jenis').value;
        var cari = document.getElementById('cari').value;
        var varbaris = document.getElementById("varbaris").value;
        
        document.location.href = base_url + "&departemen="+encodeURIComponent(departemen)+"&jenis="+encodeURIComponent(jenis)+"&cari="+encodeURIComponent(cari)+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
    }
    </script>
</head>

<!-- Body dan Wrapper selaras dengan siswa_main.php -->
<body class="bg-gray-100 font-sans p-4" onload="document.getElementById('cari').focus()">

<div class="max-w-7xl mx-auto space-y-4">

    <!-- ========================================================================= -->
    <!-- BAGIAN 1: HEADER / FILTER                                                 -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-lg shadow-sm border border-emerald-100 p-5">
        
        <!-- Breadcrumb / Title -->
        <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
            <h2 class="text-xl font-bold text-emerald-900 flex items-center gap-2">
                <i class="fas fa-search text-emerald-500"></i> Pencarian Calon Siswa
            </h2>
            <div class="text-sm text-gray-500 hidden sm:block">
                PSB <i class="fas fa-chevron-right text-xs mx-1"></i> Pencarian Calon
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <!-- Departemen -->
            <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Departemen</label>
                <select name="departemen" id="departemen" onChange="change_dep()" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                    <?php $dep = getDepartemen(SI_USER_ACCESS());    
                    foreach($dep as $value) {
                        if ($departemen == "") $departemen = $value; ?>
                        <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Jenis Pencarian -->
            <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Berdasarkan</label>
                <select name="jenis" id="jenis" onChange="change_dep()" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                    <?php foreach($tipe as $value) { ?>
                        <option value="<?=$value[0]?>" <?=StringIsSelected($value[0], $jenis)?> ><?=$value[1]?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Kata Kunci -->
            <div class="md:col-span-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kata Kunci</label>
                <?php
                // Dinamis Input berdasarkan "jenis"
                if ($jenis == 'darah') {
                    $row = array('A','O','B','AB');
                    $jum = 4; ?>
                    <select name="cari" id="cari" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                        <?php for ($i=0;$i<$jum;$i++) { ?>
                            <option value="<?=$row[$i]?>" <?=StringIsSelected($row[$i], $cari)?> ><?=$row[$i]?></option>
                        <?php } ?>
                    </select>
                <?php } elseif ($jenis == 'kondisi' || $jenis == 'status' || $jenis == 'agama' || $jenis == 'suku') {	
                    if ($jenis == 'kondisi') { $query = "SELECT kondisi FROM kondisisiswa ORDER BY kondisi "; } 
                    elseif ($jenis == 'status') { $query = "SELECT status FROM statussiswa ORDER BY status "; } 
                    elseif ($jenis == 'suku') {	$query = "SELECT suku FROM suku ORDER BY suku"; } 
                    elseif ($jenis == 'agama') { $query = "SELECT agama FROM agama ORDER BY urutan"; }
                    $result_q = QueryDb($query); ?>
                    <select name="cari" id="cari" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                        <?php while ($row_q = mysqli_fetch_row($result_q)) { ?>
                            <option value="<?=$row_q[0]?>" <?=StringIsSelected($row_q[0], $cari)?> ><?=$row_q[0]?></option>
                        <?php } ?>
                    </select>
                <?php } else { ?>
                    <input type="text" name="cari" id="cari" value="<?=$cari?>" placeholder="Ketik di sini..." onKeyPress="return focusNext('tabel', event)" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" />
                <?php } ?>
            </div>

            <!-- Tombol Cari -->
            <div class="md:col-span-2">
                <button type="button" id="tabel" onClick="show_calon()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out flex items-center justify-center gap-2">
                    <i class="fa-solid fa-search"></i> Cari Data
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- BAGIAN 2: CONTENT AREA                                                    -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-lg shadow-sm border border-emerald-100 p-5">
        
        <?php if ($action == 'view' && !empty($cari)) { ?>
            <!-- ===================== MODE: TAMPILKAN DATA ===================== -->
            
            <?php
            // Logic Query
            if ($jenis!="kondisi" && $jenis!="status" && $jenis!="agama" && $jenis!="suku" && $jenis!="darah") {
                $sql_tot = "SELECT c.replid,c.nopendaftaran,c.nama,p.departemen,k.kelompok,c.aktif,c.nisn FROM calonsiswa c,kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.$jenis like '%$cari%' AND p.departemen='$departemen' AND c.idkelompok = k.replid AND c.idproses = p.replid AND p.replid = k.idproses";
                $sql = "SELECT c.replid,c.nopendaftaran,c.nama,p.departemen,k.kelompok,c.aktif,c.nisn FROM calonsiswa c,kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.$jenis like '%$cari%' AND p.departemen='$departemen' AND c.idkelompok = k.replid AND c.idproses = p.replid AND p.replid = k.idproses ORDER BY $urut $urutan, nama ASC LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
            } else { 
                $sql_tot = "SELECT c.replid,c.nopendaftaran,c.nama,p.departemen,k.kelompok,c.aktif,c.nisn FROM calonsiswa c,kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.$jenis = '$cari' AND p.departemen='$departemen' AND c.idkelompok = k.replid AND c.idproses = p.replid AND p.replid = k.idproses";
                $sql = "SELECT c.replid,c.nopendaftaran,c.nama,p.departemen,k.kelompok,c.aktif,c.nisn FROM calonsiswa c,kelompokcalonsiswa k, prosespenerimaansiswa p WHERE c.$jenis = '$cari' AND p.departemen='$departemen' AND c.idkelompok = k.replid AND c.idproses = p.replid AND p.replid = k.idproses ORDER BY $urut $urutan, nama ASC LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
            }
            
            $result_tot = QueryDb($sql_tot);
            $total = ceil(mysqli_num_rows($result_tot)/(int)$varbaris);
            $jumlah = mysqli_num_rows($result_tot);
            
            $result = QueryDb($sql);
                
            if (mysqli_num_rows($result) > 0) { 
            ?>
                <input type="hidden" name="total" id="total" value="<?=$total?>"/>
                
                <!-- Toolbar Aksi -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                    <div class="text-sm text-gray-600">
                        Ditemukan: <span class="font-bold text-gray-900"><?=$jumlah?></span> Data Calon Siswa
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <button onClick="refresh_content()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium py-1.5 px-3 rounded shadow-sm border border-gray-300 transition flex items-center gap-2">
                            <i class="fa-solid fa-sync-alt"></i> Refresh
                        </button>
                        <button onClick="cetak_excel()" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-1.5 px-3 rounded shadow-sm transition flex items-center gap-2">
                            <i class="fa-solid fa-file-excel"></i> Cetak Excel
                        </button>
                        <button onClick="cetak()" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-1.5 px-3 rounded shadow-sm transition flex items-center gap-2">
                            <i class="fa-solid fa-print"></i> Cetak
                        </button>
                    </div>
                </div>

                <!-- Tabel Data Responsif -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-emerald-50">
                            <tr>        
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider w-12">No</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('nopendaftaran','<?=$urutan?>')">
                                    No. Pendaftaran <?=($urut=='nopendaftaran') ? ($urutan=='ASC' ? '<i class="fa-solid fa-sort-down ml-1"></i>':'<i class="fa-solid fa-sort-up ml-1"></i>') : ''?>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('nisn','<?=$urutan?>')">
                                    NISN <?=($urut=='nisn') ? ($urutan=='ASC' ? '<i class="fa-solid fa-sort-down ml-1"></i>':'<i class="fa-solid fa-sort-up ml-1"></i>') : ''?>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('nama','<?=$urutan?>')">
                                    Nama Calon Siswa <?=($urut=='nama') ? ($urutan=='ASC' ? '<i class="fa-solid fa-sort-down ml-1"></i>':'<i class="fa-solid fa-sort-up ml-1"></i>') : ''?>
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('kelompok','<?=$urutan?>')">
                                    Kelompok <?=($urut=='kelompok') ? ($urutan=='ASC' ? '<i class="fa-solid fa-sort-down ml-1"></i>':'<i class="fa-solid fa-sort-up ml-1"></i>') : ''?>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('aktif','<?=$urutan?>')">
                                    Status <?=($urut=='aktif') ? ($urutan=='ASC' ? '<i class="fa-solid fa-sort-down ml-1"></i>':'<i class="fa-solid fa-sort-up ml-1"></i>') : ''?>
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                            $cnt = ($page==0) ? 0 : (int)$page*(int)$varbaris;
                            while ($row = @mysqli_fetch_array($result)) {
                            ?>
                            <tr class="hover:bg-emerald-50 transition duration-150">
                                <td class="px-4 py-2 text-center text-gray-500"><?=++$cnt ?></td>
                                <td class="px-4 py-2 text-gray-800 font-medium"><?=$row['nopendaftaran'] ?></td>
                                <td class="px-4 py-2 text-gray-600"><?=$row['nisn'] ?></td>
                                <td class="px-4 py-2 text-gray-900 font-bold"><?=$row['nama']?></td>
                                <td class="px-4 py-2 text-gray-600"><?=$row['kelompok'] ?></td>
                                <td class="px-4 py-2 text-center">
                                    <?php if ($row['aktif']==1) { ?>
                                        <span class="inline-flex px-2 py-1 text-xs leading-4 font-semibold rounded-full bg-emerald-100 text-emerald-800">Aktif</span>
                                    <?php } elseif ($row['aktif']==0) { ?>
                                        <span class="inline-flex px-2 py-1 text-xs leading-4 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>
                                    <?php } ?>	
                                </td>
                                <td class="px-4 py-2 text-center flex justify-center gap-3">
                                    <button onClick="tampil(<?=$row['replid']?>)" class="text-blue-500 hover:text-blue-700 transition" title="Detail Calon Siswa">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <button onClick="edit(<?=$row['replid']?>)" class="text-amber-500 hover:text-amber-700 transition" title="Ubah Calon Siswa">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                </td>        
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!-- Paginasi -->
                <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm bg-gray-50 p-3 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600">Halaman</span>
                        <select name="hal" id="hal" onChange="change_hal()" class="border border-gray-300 rounded px-2 py-1 bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                        <?php for ($m=0; $m<$total; $m++) {?>
                            <option value="<?=$m?>" <?=IntIsSelected($hal,$m)?>><?=$m+1?></option>
                        <?php } ?>
                        </select>
                        <span class="text-gray-600">dari <?=$total?> halaman</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-gray-600">Tampilkan</span>
                        <select name="varbaris" id="varbaris" onChange="change_baris()" class="border border-gray-300 rounded px-2 py-1 bg-white focus:ring-2 focus:ring-emerald-500 outline-none">
                        <?php for ($m=10; $m <= 100; $m=$m+10) { ?>
                            <option value="<?=$m?>" <?=IntIsSelected($varbaris,$m)?>><?=$m?></option>
                        <?php } ?>
                        </select>
                        <span class="text-gray-600">baris per halaman</span>
                    </div>
                </div>

            <?php } else { ?>
                <!-- State Tidak Ada Hasil Pencarian -->
                <div class="flex flex-col items-center justify-center p-10 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <i class="fa-solid fa-magnifying-glass-minus text-5xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium text-gray-600">Data Tidak Ditemukan</p>
                    <p class="text-sm text-gray-500 mt-1">Silakan ulangi pencarian dengan kata kunci yang berbeda.</p>
                </div>
            <?php } ?>

        <?php } else { ?>
            <!-- ===================== MODE: BLANK STATE ===================== -->
            <div class="flex flex-col items-center justify-center p-16 text-center bg-emerald-50 rounded-lg border border-emerald-100">
                <?php 	
                $sql_dep = "SELECT * FROM departemen";    
                $result_dep = QueryDb($sql_dep);
                if (@mysqli_num_rows($result_dep) > 0) {
                ?>	
                    <i class="fa-solid fa-search text-6xl text-emerald-200 mb-4"></i>
                    <h3 class="text-xl font-bold text-emerald-800 mb-2">Mulai Pencarian Data</h3>
                    <p class="text-emerald-600 max-w-md">
                        Silakan tentukan <strong>Departemen, Jenis Pencarian,</strong> dan masukkan <strong>Kata Kunci</strong> pada form di atas, lalu klik tombol <strong class="text-emerald-800"><i class="fa-solid fa-search"></i> Cari Data</strong>.
                    </p>
                <?php } else { ?>
                    <i class="fa-solid fa-exclamation-triangle text-6xl text-red-200 mb-4"></i>
                    <h3 class="text-xl font-bold text-red-800 mb-2">Departemen Belum Diatur</h3>
                    <p class="text-red-600 max-w-md">Belum ada data Departemen. Silahkan isi terlebih dahulu di menu Departemen pada bagian Referensi.</p>
                <?php } ?>
            </div>
        <?php } ?>

    </div>

</div>

<?php CloseDb(); ?>
</body>
</html>