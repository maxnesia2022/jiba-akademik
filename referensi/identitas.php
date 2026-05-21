<?
require_once('../include/errorhandler.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../cek.php');

$departemen="";
if (isset($_REQUEST['departemen']))
	$departemen=$_REQUEST['departemen'];
	
$title = "Sekolah";
if ($departemen=='yayasan')
	$title = "";

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
if ($op == "delheader") 
{
	OpenDb();
	$sql = "SELECT foto FROM identitas WHERE departemen='$departemen'";
	$result = QueryDb($sql);
	$row = @mysqli_fetch_row($result);
	if ($row[0] != '')
		$sql = "UPDATE identitas SET nama=NULL, situs=NULL, email=NULL, alamat1=NULL, 
					   alamat2=NULL, telp1=NULL, telp2=NULL, telp3=NULL, telp4=NULL, fax1=NULL, fax2=NULL 
				 WHERE departemen = '$departemen'";
	else
		$sql = "DELETE FROM identitas WHERE departemen = '$departemen'";
	QueryDb($sql);		
	CloseDb();		
}

if ($op == "dellogo") 
{
	OpenDb();
	$sql = "SELECT nama FROM identitas WHERE departemen='$departemen'";
	$result = QueryDb($sql);
	$row = @mysqli_fetch_row($result);
	if ($row[0] != '')
		$sql = "UPDATE identitas SET foto=NULL WHERE departemen = '$departemen'";
	else
		$sql = "DELETE FROM identitas WHERE departemen = '$departemen'";
	QueryDb($sql);		
	CloseDb();		
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identitas Sekolah</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Modern Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
    function tambah_logo() {
        var departemen=document.getElementById('departemen').value;
        newWindow('logo2.php?departemen='+departemen, 'InputLogoSekolah','550','305','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function tambah() {
        var departemen=document.getElementById('departemen').value;
        newWindow('identitas_add.php?departemen='+departemen, 'InputIdentitasSekolah','675','430','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function getfresh() {
        var departemen=document.getElementById('departemen').value;
        document.location.href="identitas.php?departemen="+departemen;
    }

    function edit() {
        var departemen=document.getElementById('departemen').value;
        newWindow('identitas_edit.php?departemen='+departemen, 'UbahIdentitasSekolah','675','430','resizable=1,scrollbars=1,status=0,toolbar=0')
    }

    function hapus(bagian) {
        var departemen=document.getElementById('departemen').value;
        if (confirm("Apakah anda yakin akan menghapus identitas sekolah ini?")) {
            if (bagian=='header'){
                document.location.href = "identitas.php?op=delheader&departemen="+departemen;
            } else if (bagian=='logo'){
                document.location.href = "identitas.php?op=dellogo&departemen="+departemen;
            }
        }
    }
    function chg_dep(){
        var departemen=document.getElementById('departemen').value;
        document.location.href = "identitas.php?departemen="+departemen;
    }
    function cetak(){
        var departemen=document.getElementById('departemen').value;
        newWindow('kop_cetak.php?departemen='+departemen, 'CetakHeader','790','650','resizable=1,scrollbars=1,status=0,toolbar=0')
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">

    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10">

        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-school text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Referensi Akademik</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">IDENTITAS SEKOLAH</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../referensi.php" target="content" class="text-emerald-700 hover:underline font-semibold">Referensi</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Identitas Sekolah</span>
            </div>
        </div>

        <!-- Control Bar -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <label for="departemen" class="text-sm font-bold text-slate-700">Departemen</label>
                <div class="relative">
                    <select name="departemen" id="departemen" onchange="chg_dep()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-sm font-semibold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-48 pl-4 pr-10 py-2.5 shadow-sm transition-colors cursor-pointer">
                        <option value="yayasan" <?php echo StringIsSelected($departemen,'yayasan'); ?>>Umum</option>
                        <?php
                        OpenDb();
                        $res = QueryDb("SELECT departemen FROM departemen WHERE aktif=1 ORDER BY urutan");
                        while ($r = @mysqli_fetch_array($res)){
                            if ($departemen=="") $departemen=$r['departemen'];
                            echo "<option value='".$r['departemen']."' ".StringIsSelected($departemen,$r['departemen']).">".$r['departemen']."</option>";
                        }
                        ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onClick="cetak()" class="flex items-center gap-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs py-2.5 px-4 rounded-xl shadow-sm transition-all duration-200 active:scale-95">
                    <i class="fa-solid fa-print text-emerald-600"></i> Cetak KOP Surat
                </button>
            </div>
        </div>

        <?php
        $replid = 0;
        $sql="SELECT * FROM identitas WHERE departemen='$departemen' ORDER BY replid DESC LIMIT 1";
        $result=QueryDb($sql);
        $row=@mysqli_fetch_array($result);
        if (mysqli_num_rows($result) > 0) {
            $replid = $row['replid'];
        }
        ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Logo Card -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col items-center justify-center min-h-[300px]">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Logo <?php echo $title; ?></h3>
                
                <?php if ($row['foto'] == "") { ?>
                    <div class="flex flex-col items-center gap-4 text-center">
                        <div class="w-20 h-20 bg-rose-50 text-rose-300 rounded-full flex items-center justify-center text-3xl">
                            <i class="fa-solid fa-image-slash"></i>
                        </div>
                        <p class="text-xs font-semibold text-slate-500">Belum ada logo terunggah.</p>
                        <button onclick="JavaScript:tambah_logo()" class="text-emerald-700 hover:text-emerald-800 font-bold text-xs underline underline-offset-4">
                            Unggah Logo Sekarang
                        </button>
                    </div>
                <?php } else { ?>
                    <div class="relative group">
                        <div class="w-48 h-48 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden p-4">
                            <img src="../library/gambar.php?replid=<?php echo $replid; ?>&table=identitas" class="max-w-full max-h-full object-contain drop-shadow-md" alt="Logo">
                        </div>
                        <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-2">
                            <button onclick="JavaScript:tambah_logo()" class="w-9 h-9 bg-white text-emerald-600 rounded-xl shadow-lg border border-slate-100 flex items-center justify-center hover:scale-110 transition-transform">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="JavaScript:hapus('logo')" class="w-9 h-9 bg-white text-rose-600 rounded-xl shadow-lg border border-slate-100 flex items-center justify-center hover:scale-110 transition-transform">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Header Info Card -->
            <div class="md:col-span-2 bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative flex flex-col justify-center min-h-[300px]">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Informasi Header Surat</h3>

                <?php if ($row['nama'] != "") { ?>
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-3xl font-black text-slate-900 leading-tight"><?php echo $row['nama']; ?></h2>
                            <div class="mt-2 flex flex-wrap gap-3">
                                <?php if ($row['situs']) { ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg">
                                        <i class="fa-solid fa-globe"></i> <?php echo $row['situs']; ?>
                                    </span>
                                <?php } ?>
                                <?php if ($row['email']) { ?>
                                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-700 bg-sky-50 px-2.5 py-1 rounded-lg">
                                        <i class="fa-solid fa-envelope"></i> <?php echo $row['email']; ?>
                                    </span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pt-6 border-t border-slate-100">
                            <!-- Lokasi 1 -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2 text-emerald-900 font-extrabold text-[11px] uppercase tracking-wider">
                                    <i class="fa-solid fa-location-dot"></i> Lokasi Utama
                                </div>
                                <p class="text-sm font-semibold text-slate-600 leading-relaxed"><?php echo $row['alamat1']; ?></p>
                                <div class="text-xs font-medium text-slate-500 space-y-1">
                                    <?php if ($row['telp1'] || $row['telp2']) { ?>
                                        <p><i class="fa-solid fa-phone mr-1.5 opacity-50"></i> <?php echo $row['telp1'] . ($row['telp2'] ? ", " . $row['telp2'] : ""); ?></p>
                                    <?php } ?>
                                    <?php if ($row['fax1']) { ?>
                                        <p><i class="fa-solid fa-fax mr-1.5 opacity-50"></i> Fax. <?php echo $row['fax1']; ?></p>
                                    <?php } ?>
                                </div>
                            </div>

                            <!-- Lokasi 2 -->
                            <?php if ($row['alamat2']) { ?>
                            <div class="space-y-3">
                                <div class="flex items-center gap-2 text-emerald-900 font-extrabold text-[11px] uppercase tracking-wider">
                                    <i class="fa-solid fa-map-pin"></i> Lokasi Cabang
                                </div>
                                <p class="text-sm font-semibold text-slate-600 leading-relaxed"><?php echo $row['alamat2']; ?></p>
                                <div class="text-xs font-medium text-slate-500 space-y-1">
                                    <?php if ($row['telp3'] || $row['telp4']) { ?>
                                        <p><i class="fa-solid fa-phone mr-1.5 opacity-50"></i> <?php echo $row['telp3'] . ($row['telp4'] ? ", " . $row['telp4'] : ""); ?></p>
                                    <?php } ?>
                                    <?php if ($row['fax2']) { ?>
                                        <p><i class="fa-solid fa-fax mr-1.5 opacity-50"></i> Fax. <?php echo $row['fax2']; ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <?php if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                        <div class="flex items-center gap-3 pt-6">
                            <button onclick="JavaScript:edit()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2 px-4 rounded-xl shadow-md transition-all active:scale-95">
                                <i class="fa-solid fa-pen-to-square"></i> Edit Header
                            </button>
                            <button onclick="JavaScript:hapus('header')" class="flex items-center gap-2 bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-xs py-2 px-4 rounded-xl transition-all active:scale-95">
                                <i class="fa-solid fa-trash-can"></i> Hapus
                            </button>
                        </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="flex flex-col items-center gap-4 text-center">
                        <div class="w-16 h-16 bg-emerald-50 text-emerald-300 rounded-2xl flex items-center justify-center text-2xl">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <p class="text-xs font-semibold text-slate-500">Belum ada data identitas header sekolah.</p>
                        <button onclick="JavaScript:tambah()" class="inline-flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-3 px-6 rounded-2xl shadow-md transition-all active:scale-95">
                            <i class="fa-solid fa-plus"></i> Lengkapi Data Identitas
                        </button>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</body>
</html>
<?php CloseDb(); ?>
