<?php
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/theme.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../cek.php');

OpenDb();
if (isset($_REQUEST['departemen']))
	$departemen = $_REQUEST['departemen'];
if (isset($_REQUEST['tingkat']))
	$tingkat = $_REQUEST['tingkat'];
if (isset($_REQUEST['tahunajaran']))
	$tahunajaran = $_REQUEST['tahunajaran'];
if (isset($_REQUEST['kelas']))
	$kelas = CQ($_REQUEST['kelas']);	
if (isset($_REQUEST['kapasitas']))
	$kapasitas = $_REQUEST['kapasitas'];
if (isset($_REQUEST['nipwali']))
	$nipwali = $_REQUEST['nipwali'];
if (isset($_REQUEST['namawali']))
	$namawali = $_REQUEST['namawali'];
if (isset($_REQUEST['keterangan']))
	$keterangan = CQ($_REQUEST['keterangan']);	

$ERROR_MSG = "";
if (isset($_REQUEST['Simpan'])) {
	$sql_cek = "SELECT * FROM kelas WHERE kelas = '$_REQUEST[kelas]' AND idtahunajaran = '$_REQUEST[tahunajaran]' AND idtingkat = '$_REQUEST[tingkat]'";
	$result_cek = QueryDb($sql_cek);
	
	if (@mysqli_num_rows($result_cek) > 0) {
		CloseDb();
		$ERROR_MSG = "Kelas ".$kelas." sudah digunakan!";
	} else {
		$sql = "INSERT INTO kelas SET kelas='$kelas', idtahunajaran='$tahunajaran', kapasitas=$kapasitas, idtingkat='$tingkat', nipwali='$nipwali', keterangan='$keterangan'";
		$result = QueryDb($sql);
		if ($result) { ?>
			<script language="javascript">
				opener.refresh();
				window.close();
			</script> 
<?php		}
	}
}

OpenDb();
$sql_get_namatahunajaran = "SELECT tahunajaran FROM tahunajaran WHERE replid = '$tahunajaran'";
$result_get_namatahunajaran = QueryDb($sql_get_namatahunajaran);	
$row_get_namatahunajaran =@mysqli_fetch_array($result_get_namatahunajaran);

$sql_get_namatingkat = "SELECT tingkat FROM tingkat WHERE replid = '$tingkat'";
$result_get_namatingkat = QueryDb($sql_get_namatingkat);
$row_get_namatingkat =@mysqli_fetch_array($result_get_namatingkat);
CloseDb();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIBAS SIMAKA [Tambah Kelas]</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="../style/tooltips.css">
    <script language="JavaScript" src="../script/tooltips.js"></script>
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript" src="../script/validasi.js"></script>
    <script language="javascript">

    function caripegawai() {
        newWindow('../library/pegawai.php?flag=0&bagian=Akademik', 'CariPegawai','600','618','resizable=1,scrollbars=1,status=0,toolbar=0');
    }

    function acceptPegawai(nip, nama, flag) {
        document.getElementById('nipwali').value = nip;
        document.getElementById('nip').value = nip;
        document.getElementById('nama').value = nama;
        document.getElementById('namawali').value = nama;
        document.getElementById('kapasitas').focus();
    }

    function tutup() {
        document.getElementById('kapasitas').focus();
    }

    function validate() {
        return validateEmptyText('kelas', 'Nama Kelas') && 
               validateEmptyText('nip', 'NIP dan Nama Wali Kelas') &&
               validateEmptyText('kapasitas', 'Kapasitas Kelas') &&
               validateNumber('kapasitas', 'Kapasitas Kelas') &&
               validateMaxText('keterangan', 255, 'Keterangan');
    }

    function focusNext(elemName, evt) {
        evt = (evt) ? evt : event;
        var charCode = (evt.charCode) ? evt.charCode :
            ((evt.which) ? evt.which : evt.keyCode);
        if (charCode == 13) {
            document.getElementById(elemName).focus();
            if (elemName == 'nip')
                caripegawai();
            return false;
        } 
        return true;
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 p-4 md:p-6 select-none overflow-x-hidden" onLoad="document.getElementById('kelas').focus()">

    <div class="max-w-2xl mx-auto bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-emerald-900 px-8 py-5 flex items-center justify-between border-b border-emerald-800">
            <div class="flex items-center gap-4 text-white">
                <div class="w-10 h-10 bg-emerald-800 rounded-full flex items-center justify-center shadow-inner">
                    <i class="fa-solid fa-plus text-lg"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold tracking-tight">Tambah Kelas</h2>
                    <p class="text-xs text-emerald-200 font-medium uppercase tracking-wider mt-0.5">Pendataan Baru</p>
                </div>
            </div>
            <button onClick="window.close()" class="w-8 h-8 flex items-center justify-center rounded-full bg-emerald-800 text-emerald-200 hover:bg-rose-500 hover:text-white transition-colors duration-200" title="Tutup">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form Content -->
        <div class="p-8 bg-slate-50">
            <form name="main" onSubmit="return validate()" class="flex flex-col gap-6">
                
                <input type="hidden" name="urut" id="urut" value="<?=$urut ?? ''?>"/>
                <input type="hidden" name="urutan" id="urutan" value="<?=$urutan ?? ''?>"/>
                <input type="hidden" name="departemen" id="departemen" value="<?=$departemen?>"/>
                <input type="hidden" name="tingkat" id="tingkat" value="<?=$tingkat?>"/>
                <input type="hidden" name="tahunajaran" id="tahunajaran" value="<?=$tahunajaran?>"/>
                <input type="hidden" name="nipwali" id="nipwali" value="<?=$nipwali ?? ''?>"/>
                <input type="hidden" name="namawali" id="namawali" value="<?=$namawali ?? ''?>"/>

                <!-- Info Readonly Fields -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-5 bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Departemen</label>
                        <div class="font-semibold text-sm text-slate-800 px-3 py-2 bg-slate-50 rounded-xl border border-slate-100"><?=$departemen?></div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tingkat</label>
                        <div class="font-semibold text-sm text-slate-800 px-3 py-2 bg-slate-50 rounded-xl border border-slate-100"><?=$row_get_namatingkat['tingkat'] ?? ''?></div>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tahun Ajaran</label>
                        <div class="font-semibold text-sm text-slate-800 px-3 py-2 bg-slate-50 rounded-xl border border-slate-100"><?=$row_get_namatahunajaran['tahunajaran'] ?? ''?></div>
                    </div>
                </div>

                <!-- Input Fields -->
                <div class="flex flex-col gap-5">
                    
                    <!-- Kelas -->
                    <div>
                        <label for="kelas" class="block text-sm font-bold text-slate-700 mb-1.5">Nama Kelas <span class="text-rose-500">*</span></label>
                        <input type="text" name="kelas" id="kelas" value="<?=$kelas ?? ''?>" onKeyPress="return focusNext('nip', event)"
                            class="w-full px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none" 
                            placeholder="Contoh: X-A" autocomplete="off" />
                    </div>

                    <!-- Wali Kelas -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Wali Kelas <span class="text-rose-500">*</span></label>
                        <div class="flex gap-2">
                            <input type="text" name="nip" id="nip" value="<?=$nipwali ?? ''?>" readonly onClick="caripegawai()"
                                class="w-1/3 px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 cursor-pointer outline-none" placeholder="NIP" />
                            <div class="relative w-2/3 flex gap-2">
                                <input type="text" name="nama" id="nama" value="<?=$namawali ?? ''?>" readonly onClick="caripegawai()"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 cursor-pointer outline-none" placeholder="Nama Pegawai" />
                                <button type="button" onClick="caripegawai()" class="absolute right-1.5 top-1.5 bottom-1.5 px-3 bg-emerald-100 text-emerald-700 hover:bg-emerald-200 rounded-lg text-xs font-bold transition-colors">
                                    <i class="fa-solid fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Kapasitas -->
                    <div>
                        <label for="kapasitas" class="block text-sm font-bold text-slate-700 mb-1.5">Kapasitas <span class="text-rose-500">*</span></label>
                        <div class="relative w-32">
                            <input type="text" name="kapasitas" id="kapasitas" value="<?=$kapasitas ?? ''?>" maxlength="3" onKeyPress="return focusNext('keterangan', event)"
                                class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none text-right" 
                                placeholder="0" autocomplete="off" />
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">org</span>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div>
                        <label for="keterangan" class="block text-sm font-bold text-slate-700 mb-1.5">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" onKeyPress="return focusNext('Simpan', event)"
                            class="w-full px-4 py-3 bg-white border border-slate-300 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none resize-none" 
                            placeholder="Opsional, maksimal 255 karakter..."><?=htmlspecialchars($keterangan ?? '')?></textarea>
                    </div>

                </div>

                <!-- Footer Actions -->
                <div class="mt-4 pt-6 border-t border-slate-200 flex items-center justify-end gap-3">
                    <button type="button" onClick="window.close()" class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm rounded-xl transition-all duration-200 active:scale-95">
                        Batal
                    </button>
                    <button type="submit" name="Simpan" id="Simpan" value="Simpan" class="px-8 py-2.5 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-900/20 transition-all duration-200 active:scale-95 flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Tampilkan error jika ada -->
    <?php if (strlen($ERROR_MSG) > 0) { ?>
    <script language="javascript">
        alert('<?=$ERROR_MSG?>');
    </script>
    <?php } ?>

</body>
</html>