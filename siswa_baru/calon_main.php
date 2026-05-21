<?php
// =========================================================================
// INIT & INCLUDE FILES
// =========================================================================
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/rupiah.php');
require_once('../library/departemen.php');
require_once('../cek.php');

OpenDb();

// =========================================================================
// PENANGKAPAN PARAMETER
// =========================================================================
$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$proses     = isset($_REQUEST['proses']) ? $_REQUEST['proses'] : 0;
$kelompok   = isset($_REQUEST['kelompok']) ? $_REQUEST['kelompok'] : 0;
$action     = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// Parameter paginasi dan sorting
$varbaris = isset($_REQUEST['varbaris']) ? $_REQUEST['varbaris'] : 20;
$page     = isset($_REQUEST['page']) ? $_REQUEST['page'] : 0;
$hal      = isset($_REQUEST['hal']) ? $_REQUEST['hal'] : 0;
$urut     = isset($_REQUEST['urut']) ? $_REQUEST['urut'] : "nama";    
$urutan   = isset($_REQUEST['urutan']) ? $_REQUEST['urutan'] : "ASC";    

// =========================================================================
// PROSES AKSI (HAPUS & UBAH STATUS AKTIF)
// =========================================================================
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

if ($op == "dw8dxn8w9ms8zs22") {
    $sql = "UPDATE calonsiswa SET aktif = '$_REQUEST[newaktif]' WHERE replid = '$_REQUEST[replid]' ";
    QueryDb($sql);
} 
else if ($op == "xm8r389xemx23xb2378e23") {
    $sql = "SELECT nopendaftaran FROM calonsiswa WHERE replid = '$_REQUEST[replid]'";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $no = $row[0];

    $sql = "DELETE FROM tambahandatacalon WHERE nopendaftaran = '$no'";
    QueryDb($sql);

    $sql = "DELETE FROM riwayatfoto WHERE nic = '$no'";
    QueryDb($sql);

    $sql = "DELETE FROM calonsiswa WHERE replid = '$_REQUEST[replid]'";     
    QueryDb($sql);

    // Redirect setelah hapus
    echo "<script>window.location.href='calon_main.php?action=view&departemen=".urlencode($departemen)."&proses=$proses&kelompok=$kelompok&page=$page&hal=$hal&varbaris=$varbaris';</script>";
    exit;
}

// Get default values if not set
if ($departemen == "") {
    $dep_list = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep_list[0];
}

// Get Process Info
if ($proses == 0) {
    $sql = "SELECT replid FROM prosespenerimaansiswa WHERE aktif=1 AND departemen='$departemen' LIMIT 1";
    $res = QueryDb($sql);
    if ($row = mysqli_fetch_array($res)) $proses = $row['replid'];
}

// Get Group Info
if ($kelompok == 0 && $proses != 0) {
    $sql = "SELECT replid FROM kelompokcalonsiswa WHERE idproses = '$proses' ORDER BY kelompok LIMIT 1";
    $res = QueryDb($sql);
    if ($row = mysqli_fetch_array($res)) $kelompok = $row['replid'];
}

// Get labels for display
$nama_proses = "";
if ($proses != 0) {
    $row = @mysqli_fetch_row(QueryDb("SELECT proses FROM prosespenerimaansiswa WHERE replid='$proses'"));
    $nama_proses = $row[0];
}
$nama_kelompok = "";
if ($kelompok != 0) {
    $row = @mysqli_fetch_row(QueryDb("SELECT kelompok FROM kelompokcalonsiswa WHERE replid='$kelompok'"));
    $nama_kelompok = $row[0];
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendataan Calon Siswa</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script type="text/javascript">
        function change_dep() {
            var departemen = document.getElementById("departemen").value;
            window.location.href = "calon_main.php?departemen=" + encodeURIComponent(departemen);
        }

        function change_proses() {
            var departemen = document.getElementById("departemen").value;
            var proses = document.getElementById("proses_select").value;
            window.location.href = "calon_main.php?departemen=" + encodeURIComponent(departemen) + "&proses=" + proses;
        }

        function change_kelompok() {
            var departemen = document.getElementById("departemen").value;
            var proses = document.getElementById("proses_select").value;
            var kelompok = document.getElementById("kelompok_select").value;
            window.location.href = "calon_main.php?departemen=" + encodeURIComponent(departemen) + "&proses=" + proses + "&kelompok=" + kelompok;
        }

        function show_calon() {
            var departemen = document.getElementById("departemen").value;
            var proses = document.getElementById("proses_select").value;
            var kelompok = document.getElementById("kelompok_select").value;
            
            if (proses == 0) {
                alert('Proses Penerimaan tidak boleh kosong!');
                return false;
            }
            if (kelompok == 0) {
                alert('Kelompok tidak boleh kosong!');
                return false;
            }
            window.location.href = "calon_main.php?action=view&departemen=" + encodeURIComponent(departemen) + "&proses=" + proses + "&kelompok=" + kelompok;
        }

        function tambah() {
            var departemen = document.getElementById('departemen').value;
            var proses = "<?=$proses?>";
            var kelompok = "<?=$kelompok?>";
            window.open('calon_add.php?departemen='+departemen+'&proses='+proses+'&kelompok='+kelompok, 'TambahCalonSiswa', 'width=825,height=650,resizable=1,scrollbars=1');
        }

        function edit(replid) {
            window.open('calon_edit.php?replid='+replid, 'UbahPendataanCalonSiswa', 'width=825,height=650,resizable=1,scrollbars=1');
        }

        function detail(replid) {
            window.open('../library/detail_calon.php?replid='+replid, 'DetailCalonSiswa'+replid, 'width=790,height=610,resizable=1,scrollbars=1');
        }

        function hapus(replid) {
            if (confirm("Apakah anda yakin akan menghapus calon siswa ini?")) {
                var departemen = document.getElementById('departemen').value;
                var proses = "<?=$proses?>";
                var kelompok = "<?=$kelompok?>";
                window.location.href = "calon_main.php?action=view&op=xm8r389xemx23xb2378e23&replid="+replid+"&departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
            }
        }

        function setaktif(replid, aktif) {
            var departemen = document.getElementById('departemen').value;
            var proses = "<?=$proses?>";
            var kelompok = "<?=$kelompok?>";
            var msg = (aktif == 1) ? "Non-aktifkan calon siswa ini?" : "Aktifkan calon siswa ini?";
            var newaktif = (aktif == 1) ? 0 : 1;
            
            if (confirm(msg)) {
                window.location.href = "calon_main.php?action=view&op=dw8dxn8w9ms8zs22&replid="+replid+"&newaktif="+newaktif+"&departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
            }
        }

        function change_urut(urut_baru, urutan_lama) {		
            var departemen = document.getElementById('departemen').value;
            var proses = "<?=$proses?>";
            var kelompok = "<?=$kelompok?>";
            var urutan_baru = (urutan_lama == "ASC") ? "DESC" : "ASC";
            window.location.href = "calon_main.php?action=view&departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok+"&urut="+urut_baru+"&urutan="+urutan_baru+"&page=<?=$page?>&hal=<?=$hal?>&varbaris=<?=$varbaris?>";
        }

        function cetak() {
            var departemen = document.getElementById('departemen').value;
            var proses = "<?=$proses?>";
            var kelompok = "<?=$kelompok?>";
            var total = document.getElementById("total") ? document.getElementById("total").value : 0;
            window.open('calon_cetak.php?departemen='+departemen+'&proses='+proses+'&kelompok='+kelompok+'&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris=<?=$varbaris?>&page=<?=$page?>&total='+total, 'CetakCalonSiswa', 'width=790,height=650,resizable=1,scrollbars=1');
        }

        function exel() {
            var departemen = document.getElementById('departemen').value;
            var proses = "<?=$proses?>";
            var kelompok = "<?=$kelompok?>";
            window.open('calon_cetak_excel.php?departemen='+departemen+'&proses='+proses+'&kelompok='+kelompok+'&urut=<?=$urut?>&urutan=<?=$urutan?>', 'CetakCalonSiswaExcel', 'width=790,height=650,resizable=1,scrollbars=1');
        }

        function change_hal() {
            var departemen = document.getElementById("departemen").value;
            var proses = "<?=$proses?>";
            var kelompok = "<?=$kelompok?>";
            var hal = document.getElementById("hal").value;
            var varbaris = document.getElementById("varbaris").value;
            window.location.href = "calon_main.php?action=view&departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok+"&page="+hal+"&hal="+hal+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
        }

        function change_baris() {
            var departemen = document.getElementById("departemen").value;
            var proses = "<?=$proses?>";
            var kelompok = "<?=$kelompok?>";
            var varbaris = document.getElementById("varbaris").value;
            window.location.href = "calon_main.php?action=view&departemen="+departemen+"&proses="+proses+"&kelompok="+kelompok+"&urut=<?=$urut?>&urutan=<?=$urutan?>&varbaris="+varbaris;
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-emerald-950 text-slate-800 min-h-screen p-4 md:p-6 overflow-x-hidden">

    <div class="w-full h-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-emerald-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- HEADER SECTION -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-emerald-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-address-book text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Penerimaan Siswa Baru</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PENDATAAN CALON SISWA</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">PSB</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Pendataan Calon</span>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Departemen</label>
                    <select id="departemen" onChange="change_dep()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php 
                        $dep_list = getDepartemen(SI_USER_ACCESS());    
                        foreach($dep_list as $value) {
                            if ($departemen == "") $departemen = $value; 
                            $selected = ($value == $departemen) ? "selected" : "";
                            echo "<option value=\"$value\" $selected>$value</option>";
                        } ?>
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Proses Penerimaan</label>
                    <select id="proses_select" onChange="change_proses()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php
                        $sql_p = "SELECT replid, proses, aktif FROM prosespenerimaansiswa WHERE departemen='$departemen'";
                        $res_p = QueryDb($sql_p);
                        while ($row_p = mysqli_fetch_array($res_p)) {
                            $tag = ($row_p['aktif'] == 1) ? " (A)" : "";
                            $selected = ($row_p['replid'] == $proses) ? "selected" : "";
                            echo "<option value=\"{$row_p['replid']}\" $selected>{$row_p['proses']}$tag</option>";
                        } ?>
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Kelompok</label>
                    <select id="kelompok_select" onChange="change_kelompok()" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 transition-all cursor-pointer">
                        <?php 
                        $sql_k = "SELECT replid, kelompok, kapasitas FROM kelompokcalonsiswa WHERE idproses = '$proses' ORDER BY kelompok";
                        $res_k = QueryDb($sql_k);
                        while ($row_k = mysqli_fetch_array($res_k)) {
                            $isi = @mysqli_fetch_row(QueryDb("SELECT COUNT(replid) FROM calonsiswa WHERE idkelompok = '{$row_k['replid']}' AND aktif = 1"))[0];
                            $selected = ($row_k['replid'] == $kelompok) ? "selected" : "";
                            echo "<option value=\"{$row_k['replid']}\" $selected>{$row_k['kelompok']} (Kap: {$row_k['kapasitas']}, Isi: $isi)</option>";
                        } ?>
                    </select>
                </div>

                <div>
                    <button onclick="show_calon()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-eye"></i> TAMPILKAN CALON
                    </button>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
            <?php if ($action == 'view' && !empty($kelompok)) { ?>
                
                <div class="p-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50/30">
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Daftar Calon: <span class="text-emerald-700"><?=$nama_kelompok?></span></h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest"><?=$departemen?> &bull; <?=$nama_proses?></p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="window.location.reload()" class="bg-white border border-slate-200 text-slate-600 p-2.5 rounded-2xl hover:bg-slate-50 shadow-sm transition-all" title="Refresh">
                            <i class="fa-solid fa-rotate"></i>
                        </button>
                        <button onclick="exel()" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-2.5 rounded-2xl hover:bg-emerald-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-file-excel"></i> EXCEL
                        </button>
                        <button onclick="cetak()" class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-5 py-2.5 rounded-2xl hover:bg-emerald-100 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-print"></i> CETAK
                        </button>
                        <?php 
                        $sql_cap = "SELECT kapasitas FROM kelompokcalonsiswa WHERE replid = '$kelompok'";
                        $cap = @mysqli_fetch_row(QueryDb($sql_cap))[0];
                        $isi = @mysqli_fetch_row(QueryDb("SELECT COUNT(replid) FROM calonsiswa WHERE idkelompok = '$kelompok' AND aktif = 1"))[0];
                        if ($cap > $isi) { ?>
                        <button onclick="tambah()" class="bg-emerald-900 text-white px-5 py-2.5 rounded-2xl hover:bg-emerald-800 shadow-sm font-bold text-xs flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-plus"></i> TAMBAH CALON
                        </button>
                        <?php } ?>
                    </div>
                </div>

                <div class="flex-1 overflow-auto p-6">
                    <?php
                    $sql_tot = "SELECT c.replid FROM calonsiswa c WHERE c.idproses = '$proses' AND c.idkelompok = '$kelompok'";
                    $res_tot = QueryDb($sql_tot);
                    $jumlah = mysqli_num_rows($res_tot);
                    $total_hal = ceil($jumlah / $varbaris);

                    // Fetch dynamic column headers from settingpsb
                    $sql_set = "SELECT * FROM settingpsb WHERE idproses = '$proses'";
                    $res_set = QueryDb($sql_set);
                    $rowset = @mysqli_fetch_array($res_set);
                    $headers = array(
                        'sum1' => @$rowset['kdsum1'] ?: 'Sumb#1',
                        'sum2' => @$rowset['kdsum2'] ?: 'Sumb#2',
                        'ujian1' => @$rowset['kdujian1'] ?: 'Uji#1',
                        'ujian2' => @$rowset['kdujian2'] ?: 'Uji#2',
                        'ujian3' => @$rowset['kdujian3'] ?: 'Uji#3',
                        'ujian4' => @$rowset['kdujian4'] ?: 'Uji#4',
                        'ujian5' => @$rowset['kdujian5'] ?: 'Uji#5',
                        'ujian6' => @$rowset['kdujian6'] ?: 'Uji#6',
                        'ujian7' => @$rowset['kdujian7'] ?: 'Uji#7',
                        'ujian8' => @$rowset['kdujian8'] ?: 'Uji#8',
                        'ujian9' => @$rowset['kdujian9'] ?: 'Uji#9',
                        'ujian10' => @$rowset['kdujian10'] ?: 'Uji#10',
                    );

                    $sql_calon = "SELECT * FROM calonsiswa WHERE idproses = '$proses' AND idkelompok = '$kelompok' 
                                  ORDER BY $urut $urutan LIMIT ".(int)$page*(int)$varbaris.",$varbaris";
                    $res_calon = QueryDb($sql_calon);

                    if (mysqli_num_rows($res_calon) > 0) {
                    ?>
                        <input type="hidden" id="total" value="<?=$total_hal?>">
                        <div class="overflow-x-auto rounded-2xl border border-slate-100">
                            <table class="min-w-full divide-y divide-slate-100 text-xs">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-3 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-12">No</th>
                                        <th class="px-3 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest w-32 cursor-pointer hover:text-emerald-700" onclick="change_urut('nopendaftaran','<?=$urutan?>')">No Daftar</th>
                                        <th class="px-3 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest w-24">PIN</th>
                                        <th class="px-3 py-3 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest cursor-pointer hover:text-emerald-700" onclick="change_urut('nama','<?=$urutan?>')">Nama Calon</th>
                                        <th class="px-3 py-3 text-right text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?=$headers['sum1']?></th>
                                        <th class="px-3 py-3 text-right text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?=$headers['sum2']?></th>
                                        <?php for($i=1;$i<=10;$i++) { echo "<th class='px-2 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest'>{$headers['ujian'.$i]}</th>"; } ?>
                                        <th class="px-3 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-20">Status</th>
                                        <th class="px-3 py-3 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest w-28">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 bg-white">
                                    <?php 
                                    $cnt = ($page * $varbaris) + 1;
                                    while ($row = mysqli_fetch_array($res_calon)) { ?>
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="px-3 py-3 text-center text-slate-400 font-bold"><?=$cnt++?></td>
                                            <td class="px-3 py-3 font-mono text-[10px] text-slate-500"><?=$row['nopendaftaran']?></td>
                                            <td class="px-3 py-3 font-mono text-[10px] text-slate-500"><?=$row['pinsiswa']?></td>
                                            <td class="px-3 py-3 font-bold text-slate-800"><?=$row['nama']?></td>
                                            <td class="px-3 py-3 text-right text-emerald-700 font-bold"><?=FormatRupiah($row['sum1'])?></td>
                                            <td class="px-3 py-3 text-right text-emerald-700 font-bold"><?=FormatRupiah($row['sum2'])?></td>
                                            <?php for($i=1;$i<=10;$i++) { echo "<td class='px-2 py-3 text-center text-slate-600 font-semibold'>{$row['ujian'.$i]}</td>"; } ?>
                                            <td class="px-3 py-3 text-center">
                                                <button onclick="setaktif(<?=$row['replid']?>, <?=$row['aktif']?>)" class="transition-opacity hover:opacity-80">
                                                    <i class="fa-solid <?= $row['aktif'] == 1 ? 'fa-toggle-on text-emerald-600' : 'fa-toggle-off text-slate-300' ?> text-2xl"></i>
                                                </button>
                                            </td>
                                            <td class="px-3 py-3 text-center">
                                                <div class="flex justify-center gap-1.5">
                                                    <button onclick="detail(<?=$row['replid']?>)" class="p-1.5 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" title="Detail"><i class="fa-solid fa-eye"></i></button>
                                                    <button onclick="edit(<?=$row['replid']?>)" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Ubah"><i class="fa-solid fa-pen-to-square"></i></button>
                                                    <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                                                    <button onclick="hapus(<?=$row['replid']?>)" class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus"><i class="fa-solid fa-trash-can"></i></button>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION -->
                        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100 text-xs font-bold text-slate-500">
                            <div class="flex items-center gap-2">
                                <span>Halaman</span>
                                <select id="hal" onChange="change_hal()" class="bg-white border border-slate-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-emerald-500">
                                    <?php for ($m=0; $m<$total_hal; $m++) {?>
                                        <option value="<?=$m?>" <?=IntIsSelected($hal,$m)?>><?=$m+1?></option>
                                    <?php } ?>
                                </select>
                                <span>dari <?=$total_hal?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>Baris</span>
                                <select id="varbaris" onChange="change_baris()" class="bg-white border border-slate-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-emerald-500">
                                    <?php for ($m=10; $m <= 100; $m+=10) { ?>
                                        <option value="<?=$m?>" <?=IntIsSelected($varbaris,$m)?>><?=$m?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="flex flex-col items-center justify-center p-16 text-center space-y-4 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                            <i class="fa-solid fa-folder-open text-5xl text-slate-200"></i>
                            <p class="text-slate-500 font-medium">Belum ada data calon siswa untuk kelompok ini.</p>
                            <?php if ($cap > $isi) { ?>
                            <button onclick="tambah()" class="bg-emerald-900 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-emerald-800 transition-colors">
                                <i class="fa-solid fa-plus mr-1"></i> Tambah Calon Baru
                            </button>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>

            <?php } else { ?>
                <!-- BLANK STATE -->
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                    <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-address-book text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Manajemen Data Calon Siswa</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Silakan tentukan <strong>Departemen, Proses,</strong> dan <strong>Kelompok</strong> pada filter di atas, lalu klik tombol <strong>Tampilkan Calon</strong>.
                    </p>
                </div>
            <?php } ?>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>
