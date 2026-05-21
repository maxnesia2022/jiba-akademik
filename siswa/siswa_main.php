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
require_once('../include/exceldata.php');
require_once('../cek.php');

OpenDb();

// =========================================================================
// PENANGKAPAN PARAMETER (Menggabungkan header & content variables)
// =========================================================================
$departemen  = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$tahunajaran = isset($_REQUEST['tahunajaran']) ? $_REQUEST['tahunajaran'] : '';
$tingkat     = isset($_REQUEST['tingkat']) ? $_REQUEST['tingkat'] : '';
$kelas       = isset($_REQUEST['kelas']) ? $_REQUEST['kelas'] : '';
$action      = isset($_REQUEST['action']) ? $_REQUEST['action'] : ''; // Parameter baru untuk toggle blank_siswa / siswa_content

// Parameter paginasi dan sorting dari siswa_content
$varbaris = isset($_REQUEST['varbaris']) ? $_REQUEST['varbaris'] : 20;
$page     = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
$hal      = isset($_REQUEST['hal']) ? $_REQUEST['hal'] : 0;
$urut     = isset($_REQUEST['urut']) ? $_REQUEST['urut'] : "nama";    
$urutan   = isset($_REQUEST['urutan']) ? $_REQUEST['urutan'] : "ASC";    

// =========================================================================
// PROSES AKSI (HAPUS & UBAH STATUS AKTIF) DARI KONTEN LAMA
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

// Aksi: Ubah Status Aktif
if ($op == "dw8dxn8w9ms8zs22") {
    $sql = "UPDATE siswa SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
    QueryDb($sql);
} 
// Aksi: Hapus Siswa
else if ($op == "xm8r389xemx23xb2378e23") {
    $success = true;
    BeginTrans();

    $sql = "SELECT nis FROM siswa WHERE replid = '$_REQUEST[replid]'";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $nis = $row[0];

    $sql = "DELETE FROM tambahandatasiswa WHERE nis = '$nis'";
    QueryDbTrans($sql, $success);

    if ($success) {
        $sql = "DELETE FROM riwayatfoto WHERE nis = '$nis'";
        QueryDbTrans($sql, $success);
    }

    if ($success) {
        $sql = "DELETE FROM siswa WHERE replid = '$_REQUEST[replid]'";
        QueryDbTrans($sql, $success);
    }

    if ($success) {
        $sql = "SELECT * FROM calonsiswa WHERE replidsiswa = '$_REQUEST[replid]'";
        $result = QueryDb($sql);
        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE calonsiswa SET replidsiswa = NULL WHERE replidsiswa = '$_REQUEST[replid]'";
            QueryDbTrans($sql, $success);
        }
    }

    if ($success) {
        CommitTrans();
    } else {
        RollbackTrans();
    }
    
    // Redirect setelah hapus
    if ($success) {    
        echo "<script>window.location.href='siswa_main.php?action=view&departemen=$departemen&tahunajaran=$tahunajaran&tingkat=$tingkat&kelas=$kelas&page=$page&hal=$hal&varbaris=$varbaris';</script>";
        exit;
    } 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Siswa</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SCRIPT GABUNGAN JAVASCRIPT (Header & Content) -->
    <script type="text/javascript">
        // --- Fungsi Header / Filter ---
        function change_dep() {
            var departemen = document.getElementById("departemen").value;
            window.location.href = "siswa_main.php?departemen=" + encodeURIComponent(departemen);
        }

        function change_tingkat() {
            var departemen = document.getElementById("departemen").value;
            var tahunajaran = document.getElementById("tahunajaran").value;
            var tingkat = document.getElementById("tingkat").value;    
            window.location.href = "siswa_main.php?tahunajaran=" + encodeURIComponent(tahunajaran) + "&tingkat=" + encodeURIComponent(tingkat) + "&departemen=" + encodeURIComponent(departemen);
        }

        function change_kelas() {    
            var departemen = document.getElementById("departemen").value;
            var tahunajaran = document.getElementById("tahunajaran").value;
            var tingkat = document.getElementById("tingkat").value;    
            var kelas = document.getElementById("kelas").value;    
            window.location.href = "siswa_main.php?tahunajaran=" + encodeURIComponent(tahunajaran) + "&tingkat=" + encodeURIComponent(tingkat) + "&departemen=" + encodeURIComponent(departemen) + "&kelas=" + encodeURIComponent(kelas);
        }

        function show_siswa() {
            var departemen = document.getElementById("departemen").value;
            var tahunajaran = document.getElementById("tahunajaran").value;
            var tingkat = document.getElementById("tingkat").value;    
            var kelas = document.getElementById("kelas").value;
            
            if (kelas == "") {
                alert('Kelas tidak boleh kosong');
                return false;
            }    
            window.location.href = "siswa_main.php?action=view&departemen=" + encodeURIComponent(departemen) + "&tahunajaran=" + encodeURIComponent(tahunajaran) + "&tingkat=" + encodeURIComponent(tingkat) + "&kelas=" + encodeURIComponent(kelas);
        }

        function focusNext(elemName, evt) {
            evt = (evt) ? evt : event;
            var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
            if (charCode == 13) {
                document.getElementById(elemName).focus();
                if (elemName == 'tabel') { show_siswa(); } 
                return false;
            } 
            return true;
        }

        // --- Fungsi Konten / Aksi Tabel ---
        var base_url = "siswa_main.php?action=view"; 

        function refresh_content() {    
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var kelas = document.getElementById('kelas').value;
            var tingkat = document.getElementById('tingkat').value;
            window.location.href = base_url + "&tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen;
        }

        function tambah() {
            var departemen = document.getElementById('departemen').value;
            var kelas = document.getElementById('kelas').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            // Gunakan window.open native sebagai ganti library lama jika error, tapi kita biarkan format lama jika function newWindow ada di tools.js
            window.open('siswa_add.php?departemen='+departemen+'&kelas='+kelas+'&tahunajaran='+tahunajaran+'&tingkat='+tingkat, 'TambahSiswa', 'width=905,height=650,resizable=1,scrollbars=1');
        }

        function edit(replid, nis) {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var kelas = document.getElementById('kelas').value;
            var tingkat = document.getElementById('tingkat').value;
            window.open('siswa_edit.php?replid='+replid+'&departemen='+departemen+'&tahunajaran='+tahunajaran+'&kelas='+kelas+'&tingkat='+tingkat, 'UbahSiswa', 'width=905,height=650,resizable=1,scrollbars=1');
        }

        function hapus(replid, nis) {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var kelas = document.getElementById('kelas').value;
            var tingkat = document.getElementById('tingkat').value;
            var urut = document.getElementById('urut').value;
            var urutan = document.getElementById('urutan').value;
            if (confirm('Apakah anda yakin akan menghapus siswa ini?')) {
                window.location.href = base_url + "&op=xm8r389xemx23xb2378e23&replid="+replid+"&tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&nis="+nis+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
            }
        }

        function change_urut(urut_baru, urutan_lama) {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var kelas = document.getElementById('kelas').value;
            var tingkat = document.getElementById('tingkat').value;
            var urutan_baru = (urutan_lama == "ASC") ? "DESC" : "ASC";
            window.location.href = base_url + "&tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&urut="+urut_baru+"&urutan="+urutan_baru+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
        }

        function cetak() {
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var kelas = document.getElementById('kelas').value;
            var tingkat = document.getElementById('tingkat').value;
            var urut = document.getElementById('urut').value;
            var urutan = document.getElementById('urutan').value;
            var total=document.getElementById("total").value;
            window.open('siswa_cetak.php?departemen='+departemen+'&tahunajaran='+tahunajaran+'&tingkat='+tingkat+'&kelas='+kelas+'&urut='+urut+'&urutan='+urutan+'&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakSiswa', 'width=790,height=650,resizable=1,scrollbars=1');
        }

        function exel(){
            var departemen = document.getElementById('departemen').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var kelas = document.getElementById('kelas').value;
            var tingkat = document.getElementById('tingkat').value;
            var urut = document.getElementById('urut').value;
            var urutan = document.getElementById('urutan').value;
            window.open('siswa_cetak_excel.php?departemen='+departemen+'&tahunajaran='+tahunajaran+'&tingkat='+tingkat+'&kelas='+kelas+'&urut='+urut+'&urutan='+urutan, 'CetakSiswaExcel', 'width=790,height=650,resizable=1,scrollbars=1');
        }

        function tampil(replid) {
            window.open('../library/detail_siswa.php?replid='+replid, 'DetailSiswa', 'width=790,height=650,resizable=1,scrollbars=1');
        }

        function setaktif(replid, aktif) {
            var msg, newaktif;
            var departemen = document.getElementById('departemen').value;
            var kelas = document.getElementById('kelas').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            var urut = document.getElementById('urut').value;
            var urutan = document.getElementById('urutan').value;
                
            if (aktif == 1) {
                msg = "Apakah anda yakin akan mengubah siswa ini menjadi TIDAK AKTIF?";
                newaktif = 0;
            } else {    
                msg = "Apakah anda yakin akan mengubah siswa ini menjadi AKTIF?";
                newaktif = 1;
            }
            
            if (confirm(msg)) {
                window.location.href = base_url + "&op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&urut="+urut+"&urutan="+urutan+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
            }
        }

        function change_hal() {
            var departemen = document.getElementById("departemen").value;
            var kelas = document.getElementById('kelas').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            var hal = document.getElementById("hal").value;
            var varbaris = document.getElementById("varbaris").value;
            window.location.href = base_url + "&tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
        }

        function change_baris() {
            var departemen = document.getElementById("departemen").value;
            var kelas = document.getElementById('kelas').value;
            var tahunajaran = document.getElementById('tahunajaran').value;
            var tingkat = document.getElementById('tingkat').value;
            var varbaris = document.getElementById("varbaris").value;
            window.location.href= base_url + "&tingkat="+tingkat+"&kelas="+kelas+"&tahunajaran="+tahunajaran+"&departemen="+departemen+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
        }
    </script>
</head>
<body class="bg-gray-100 font-sans p-4" onload="document.getElementById('departemen').focus()">

<div class="max-w-7xl mx-auto space-y-4">

    <!-- ========================================================================= -->
    <!-- BAGIAN 1: HEADER / FILTER (Pengganti siswa_header.php)                    -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-lg shadow-sm border border-emerald-100 p-5">
        
        <!-- Breadcrumb / Title -->
        <div class="flex justify-between items-center mb-4 border-b border-gray-100 pb-3">
            <h2 class="text-xl font-bold text-emerald-900 flex items-center gap-2">
                <i class="fas fa-user-graduate text-emerald-500"></i> Pendataan Siswa
            </h2>
            <div class="text-sm text-gray-500 hidden sm:block">
                Kesiswaan <i class="fas fa-chevron-right text-xs mx-1"></i> Pendataan Siswa
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <!-- Departemen -->
            <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Departemen</label>
                <select name="departemen" id="departemen" onchange="change_dep()" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" onKeyPress="return focusNext('tingkat', event)">
                    <?php    
                    $dep = getDepartemen(SI_USER_ACCESS());    
                    foreach($dep as $value) {
                        if ($departemen == "") $departemen = $value; 
                        $selected = ($value == $departemen) ? "selected" : "";
                    ?>
                        <option value="<?=$value?>" <?=$selected?>><?=$value?></option>
                    <?php } ?>
                </select>
            </div>

            <!-- Tahun Ajaran -->
            <div class="md:col-span-3">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Ajaran</label>
                <?php  
                $sql = "SELECT replid,tahunajaran FROM tahunajaran WHERE departemen = '$departemen' AND aktif=1 ORDER BY replid DESC";
                $result = QueryDb($sql);
                $row = @mysqli_fetch_array($result);    
                $tahunajaran_id = $row['replid']; 
                ?>
                <input type="text" readonly class="w-full bg-gray-100 border border-gray-300 text-gray-600 rounded-md px-3 py-2 text-sm cursor-not-allowed" value="<?=$row['tahunajaran']?>"/>
                <input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran_id?>">
            </div>

            <!-- Tingkat & Kelas -->
            <div class="md:col-span-4 flex gap-2">
                <div class="w-1/3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tingkat</label>
                    <select name="tingkat" id="tingkat" onchange="change_tingkat()" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" onKeyPress="return focusNext('kelas', event)">
                        <?php 
                        $sql = "SELECT replid,tingkat FROM tingkat where departemen='$departemen' AND aktif = 1 ORDER BY urutan";
                        $result = QueryDb($sql);
                        while ($row = @mysqli_fetch_array($result)) {
                            if ($tingkat == "") $tingkat = $row['replid'];    
                            $selected = ($row['replid'] == $tingkat) ? "selected" : "";
                        ?>
                            <option value="<?=urlencode($row['replid'])?>" <?=$selected?>><?=$row['tingkat']?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="w-2/3">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                    <select name="kelas" id="kelas" onchange="change_kelas()" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition" onKeyPress="return focusNext('tabel', event)">
                        <?php    
                        $sql = "SELECT replid, kelas, kapasitas FROM kelas where idtingkat='$tingkat' AND idtahunajaran='$tahunajaran_id' AND aktif = 1 ORDER BY kelas";
                        $result = QueryDb($sql);
                        while ($row = @mysqli_fetch_array($result)) {
                            if ($kelas == "") $kelas = $row['replid'];
                            $sql1 = "SELECT COUNT(*) FROM siswa WHERE idkelas = '$row[0]' AND aktif = 1";                
                            $result1 = QueryDb($sql1);
                            $row1 = @mysqli_fetch_row($result1); 
                            $selected = ($row['replid'] == $kelas) ? "selected" : "";
                        ?>
                            <option value="<?=urlencode($row['replid'])?>" <?=$selected?> >
                                <?=$row['kelas']?> (Sisa: <?=(int)$row['kapasitas'] - (int)$row1[0]?>)
                            </option>
                        <?php } ?>
                    </select> 
                </div>
            </div>

            <!-- Tombol Tampilkan -->
            <div class="md:col-span-2">
                <button type="button" id="tabel" onclick="show_siswa()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-md shadow-sm transition duration-150 ease-in-out flex items-center justify-center gap-2">
                    <i class="fas fa-search"></i> Tampilkan
                </button>
            </div>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- BAGIAN 2: CONTENT AREA                                                    -->
    <!-- ========================================================================= -->
    <div class="bg-white rounded-lg shadow-sm border border-emerald-100 p-5">
        <?php if ($action == 'view' && !empty($kelas)) { ?>
            <!-- ===================== MODE: TAMPILKAN DATA (siswa_content.php) ===================== -->
            
            <input type="hidden" name="urut" id="urut" value="<?=$urut ?>" />
            <input type="hidden" name="urutan" id="urutan" value="<?=$urutan ?>" />

            <?php
            // Query Total Data
            $sql_tot = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,s.aktif,DAY(tgllahir),MONTH(tgllahir),YEAR(tgllahir),s.replid,s.nisn FROM siswa s, kelas k, tahunajaran t WHERE s.idkelas = '$kelas' AND k.idtahunajaran = '$tahunajaran' AND k.idtingkat = '$tingkat' AND s.idkelas = k.replid AND t.replid = k.idtahunajaran AND s.alumni=0 ORDER BY replid ";
            $result_tot = QueryDb($sql_tot);
            
            if (@mysqli_num_rows($result_tot) > 0) { 
                $total = ceil(mysqli_num_rows($result_tot) / (int)$varbaris);
                $jumlah = mysqli_num_rows($result_tot);
                
                // Query Data dengan Limit dan Order
                $sql = "SELECT nis,nama,asalsekolah,tmplahir,tgllahir,s.aktif,DAY(tgllahir),MONTH(tgllahir),YEAR(tgllahir),s.replid,s.statusmutasi,s.alumni,s.nisn FROM siswa s, kelas k, tahunajaran t WHERE s.idkelas = '$kelas' AND k.idtahunajaran = '$tahunajaran' AND k.idtingkat = '$tingkat' AND s.idkelas = k.replid AND t.replid = k.idtahunajaran AND s.alumni=0 ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
                $result = QueryDb($sql);

                $sql_kapasitas = "SELECT kapasitas FROM kelas WHERE replid = '$kelas'";
                $result_kapasitas = QueryDb($sql_kapasitas);
                $row_kapasitas = mysqli_fetch_row($result_kapasitas);
                $kapasitas = $row_kapasitas[0];
                
                $sql_siswa = "SELECT COUNT(*) FROM siswa WHERE idkelas = '$kelas' AND aktif = 1";
                $result_siswa = QueryDb($sql_siswa);
                $row_siswa = mysqli_fetch_row($result_siswa);
                $isi = $row_siswa[0];
            ?>
                <input type="hidden" name="total" id="total" value="<?=$total?>"/>
                <input type="hidden" name="kapasitas" id="kapasitas" value="<?=$kapasitas?>"/>
                <input type="hidden" name="isi" id="isi" value="<?=$isi?>"/>

                <!-- Action Toolbar -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                    <div class="text-sm text-gray-600">
                        Total: <span class="font-bold text-gray-900"><?=$jumlah?> Siswa</span> | 
                        Kapasitas: <span class="font-bold text-emerald-600"><?=$kapasitas?></span> | 
                        Terisi: <span class="font-bold text-orange-500"><?=$isi?></span>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <button onclick="refresh_content()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium py-1.5 px-3 rounded shadow-sm border border-gray-300 transition">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                        <button onclick="exel()" class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium py-1.5 px-3 rounded shadow-sm transition">
                            <i class="fas fa-file-excel"></i> Cetak Excel
                        </button>
                        <button onclick="cetak()" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-1.5 px-3 rounded shadow-sm transition">
                            <i class="fas fa-print"></i> Cetak
                        </button>
                        <button onclick="tambah()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium py-1.5 px-3 rounded shadow-sm transition">
                            <i class="fas fa-plus"></i> Tambah Data
                        </button>
                    </div>
                </div>

                <!-- Table Data -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-emerald-50">
                            <tr>        
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider w-12">No</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('nis','<?=$urutan?>')">NIS</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('nisn','<?=$urutan?>')">NISN</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('nama','<?=$urutan?>')">Nama Siswa</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('asalsekolah','<?=$urutan?>')">Asal Sekolah</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('tgllahir','<?=$urutan?>')">Tempat, Tgl Lahir</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider cursor-pointer hover:bg-emerald-100 transition" onClick="change_urut('aktif','<?=$urutan?>')">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php 
                            $cnt = ($page == 0) ? 1 : ((int)$page * (int)$varbaris + 1);
                            while ($row = @mysqli_fetch_row($result)) {
                            ?>    
                            <tr class="hover:bg-emerald-50 transition duration-150">                    
                                <td class="px-4 py-2 text-center text-gray-500"><?=$cnt?></td>
                                <td class="px-4 py-2 text-gray-800 font-medium"><?=$row[0]?></td>
                                <td class="px-4 py-2 text-gray-600"><?=$row[12]?></td>
                                <td class="px-4 py-2 text-gray-900 font-bold"><?=$row[1]?></td>
                                <td class="px-4 py-2 text-gray-600 truncate max-w-xs" title="<?=$row[2]?>"><?=$row[2]?></td>
                                <td class="px-4 py-2 text-gray-600"><?=$row[3].', '.$row[6].' '.NamaBulan($row[7]).' '.$row[8]?></td>
                                
                                <!-- Kolom Status -->
                                <td class="px-4 py-2 text-center">
                                    <?php if ($row[10] == 0) { ?>
                                        <?php if (SI_USER_LEVEL() == $SI_USER_STAFF) {  
                                            if ($row[5] == 1) { echo '<span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-emerald-100 text-emerald-800">Aktif</span>'; }
                                            else { echo '<span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-red-100 text-red-800">Tidak Aktif</span>'; }
                                        } else {    
                                            if ($row[5] == 1) { ?>
                                                <button onclick="setaktif(<?=$row[9]?>, <?=$row[5]?>)" class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition" title="Klik untuk Non-Aktifkan">Aktif</button>
                                            <?php } else { 
                                                if ($kapasitas > $isi) { ?>
                                                    <button onclick="setaktif(<?=$row[9]?>, <?=$row[5]?>)" class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition" title="Klik untuk Aktifkan">Tidak Aktif</button>
                                            <?php } else { ?>
                                                    <span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-red-100 text-red-800 cursor-not-allowed" title="Kapasitas Kelas Penuh">Tidak Aktif</span>
                                            <?php }
                                            } 
                                        } 
                                    } else {
                                        if ($row[5] == 1) { echo '<span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-emerald-100 text-emerald-800">Aktif</span>'; }
                                        else { echo '<span class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-amber-100 text-amber-800" title="Sudah Mutasi">Mutasi</span>'; }
                                    } ?>            
                                </td>
                                
                                <!-- Kolom Aksi -->
                                <td class="px-4 py-2 text-center flex justify-center gap-3">
                                    <button onclick="tampil(<?=$row[9]?>)" class="text-blue-500 hover:text-blue-700 transition" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button onclick="edit(<?=$row[9]?>)" class="text-amber-500 hover:text-amber-700 transition" title="Ubah">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>                
                                        <button onclick="hapus(<?=$row[9]?>,'<?=$row[0]?>')" class="text-red-500 hover:text-red-700 transition" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php $cnt++; } ?>            
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Area -->
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
                <!-- Alert Jika Data Kelas Kosong -->
                <div class="flex flex-col items-center justify-center p-10 text-center bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <i class="fas fa-folder-open text-5xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium text-gray-600">Tidak ditemukan adanya data siswa.</p>
                    <button onclick="tambah()" class="mt-4 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded shadow transition">
                        <i class="fas fa-plus mr-1"></i> Isi Data Baru
                    </button>
                </div>
            <?php } ?> 

        <?php } else { ?>
            <!-- ===================== MODE: BLANK STATE (blank_siswa.php) ===================== -->
            <div class="flex flex-col items-center justify-center p-16 text-center bg-emerald-50 rounded-lg border border-emerald-100">
                <i class="fas fa-users text-6xl text-emerald-200 mb-4"></i>
                <h3 class="text-xl font-bold text-emerald-800 mb-2">Pilih Kriteria Kelas</h3>
                <p class="text-emerald-600 max-w-md">
                    Silakan tentukan <strong>Departemen, Tahun Ajaran, Tingkat,</strong> dan <strong>Kelas</strong> pada form di atas, lalu klik tombol <strong class="text-emerald-800"><i class="fas fa-search"></i> Tampilkan</strong> untuk melihat daftar siswa.
                </p>
            </div>
        <?php } ?>
    </div>

</div>

<?php CloseDb(); ?>
</body>
</html>