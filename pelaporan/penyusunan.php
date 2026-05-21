<?
require_once('../include/sessioninfo.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../library/departemen.php');
require_once('../library/datearith.php');
require_once('../cek.php');
require_once('penyusunan.func.php');

OpenDb();

$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : "";
// Get default values if not set
if ($departemen == "") {
    $dep = getDepartemen(SI_USER_ACCESS());
    $departemen = $dep[0];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyusunan Surat</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../script/themes/ui-lightness/jquery.ui.all.css" />
    
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
        .section-card { @apply bg-white p-6 rounded-3xl border border-slate-100 shadow-sm mb-6; }
        .section-title { @apply text-sm font-extrabold text-slate-900 uppercase tracking-tight mb-6 flex items-center gap-3 border-l-4 border-emerald-500 pl-4; }
        .form-label { @apply text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2; }
        .info-row { @apply flex items-start gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100; }
    </style>

    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript" src="../script/jquery-1.9.1.js"></script>
    <script language="javascript" src="../script/jquery-ui-1.10.3.custom.min.js"></script>
    <script language="javascript" src="penyusunan.js"></script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col overflow-y-auto">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-pen-nib text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Pelaporan</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PENYUSUNAN SURAT</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../pelaporanmenu.php" target="content" class="text-emerald-700 hover:underline font-semibold">Pelaporan</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Penyusunan</span>
            </div>
        </div>

        <form name='main' method='post' action='penyusunan.report.php' onsubmit="return validate()">
            
            <!-- SECTION 1: TUJUAN SURAT -->
            <div class="section-card">
                <h2 class="section-title">
                    <i class="fa-solid fa-bullseye text-emerald-600"></i> Tujuan Surat
                </h2>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <!-- Departemen -->
                        <div>
                            <label class="form-label">Departemen</label>
                            <div class="relative max-w-xs">
                                <select name="departemen" id="departemen" onChange="changeCbDepartemen()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm transition-colors cursor-pointer">
                                    <? $dep = getDepartemen(SI_USER_ACCESS());    
                                    foreach($dep as $value) {
                                        $sel = $departemen == $value ? "selected" : "";	?>
                                        <option value="<?=$value?>" <?=$sel?> ><?=$value ?></option>
                                    <? } ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Tipe Tujuan -->
                        <div class="space-y-4">
                            <!-- Berdasarkan Kelas -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 group transition-all">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" id="tipe_1" onchange="changeType(1)" name="tipe" value="1" checked="checked" class="w-4 h-4 text-emerald-600 bg-white border-slate-300 focus:ring-emerald-500">
                                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Berdasarkan Kelas</span>
                                </label>
                                <div id="divPanelKelas" class="mt-4 flex flex-wrap gap-4 pl-7">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Tingkat</span>
                                        <span id="divCbTingkat"><? ShowCbTingkat($departemen) ?></span>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Kelas</span>
                                        <span id="divCbKelas"><? ShowCbKelas(0) ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Berdasarkan NIS -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 group transition-all">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input type="radio" id="tipe_2" onchange="changeType(2)" name="tipe" value="2" class="w-4 h-4 text-emerald-600 bg-white border-slate-300 focus:ring-emerald-500">
                                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider">Berdasarkan Daftar NIS</span>
                                </label>
                                <div id="divPanelNis" class="mt-4 pl-7 opacity-50 pointer-events-none">
                                    <textarea id="nisinfo" name="nisinfo" rows="3" class="w-full bg-white border border-slate-200 text-xs font-bold text-slate-700 rounded-xl px-4 py-3 focus:ring-emerald-500 outline-none placeholder:italic" placeholder="Masukkan NIS, pisahkan dengan koma..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Alamat -->
                        <div>
                            <label class="form-label">Alamat yang digunakan</label>
                            <div class="relative max-w-xs">
                                <select id="alamat" name="alamat" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm cursor-pointer">
                                    <option value='1'>Alamat Siswa</option>
                                    <option value='2'>Alamat Orangtua</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Posisi Cetak -->
                        <div>
                            <label class="form-label">Posisi Cetak Alamat</label>
                            <div class="relative max-w-xs">
                                <select id="posisi" name="posisi" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 block w-full pl-4 pr-10 py-3 shadow-sm cursor-pointer">
                                    <option value='1'>Kanan Atas</option>
                                    <option value='2'>Kiri Atas</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: PENGANTAR SURAT -->
            <div class="section-card">
                <h2 class="section-title">
                    <i class="fa-solid fa-paragraph text-emerald-600"></i> Pengantar Surat
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <label class="form-label mb-0">Pilih Pengantar</label>
                        <span id="divCbPengantar" class="flex-1">
                            <? $idpengantar = ShowCbPengantar($departemen) ?>
                        </span>
                    </div>
                    <div id='divPengantar' class="w-full bg-slate-50 border border-slate-200 rounded-3xl p-6 text-xs text-slate-600 leading-relaxed overflow-auto max-h-48 min-h-[100px]">
                        <? ShowPengantar($idpengantar) ?>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: LAMPIRAN SURAT -->
            <div class="section-card">
                <h2 class="section-title">
                    <i class="fa-solid fa-paperclip text-emerald-600"></i> Lampiran Surat
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" id="chLampiran" name="chLampiran" onchange='changeLampiran()' class="w-5 h-5 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500">
                            <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Gunakan Halaman Lampiran</span>
                        </label>
                        <span id='divCbLampiran' class="flex-1">
                            <? $idlampiran = ShowCbLampiran($departemen) ?>
                        </span>
                    </div>
                    <div id='divLampiran' class="w-full bg-slate-100 border border-slate-200 rounded-3xl p-6 text-xs text-slate-500 leading-relaxed overflow-auto max-h-48 min-h-[100px] transition-all italic">
                        <? ShowLampiran($idlampiran) ?>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: INFORMASI SURAT -->
            <div class="section-card">
                <h2 class="section-title">
                    <i class="fa-solid fa-circle-info text-emerald-600"></i> Informasi Pelengkap (JIBAS Ecosystem)
                </h2>
                
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
                    <!-- Nilai Harian -->
                    <div class="info-row">
                        <input type="checkbox" id="chNilai" name="chNilai" onchange="changeCbInfo('chNilai', 'cbNilai')" class="w-5 h-5 mt-1 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-slate-900">Nilai Harian Siswa</div>
                            <div class="text-[10px] text-emerald-600 font-medium italic mb-2">Data dari JIBAS Akademik</div>
                            <div class="flex items-center gap-2"><? ShowCbDateRange('cbNilai', false) ?></div>
                        </div>
                    </div>

                    <!-- Pembayaran -->
                    <div class="info-row">
                        <input type="checkbox" id="chKeuangan" name="chKeuangan" onchange="changeCbInfo('chKeuangan', 'cbKeuangan')" class="w-5 h-5 mt-1 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-slate-900">Pembayaran Siswa</div>
                            <div class="text-[10px] text-emerald-600 font-medium italic mb-2">Data dari JIBAS Keuangan</div>
                            <div class="flex items-center gap-2"><? ShowCbDateRange('cbKeuangan', false) ?></div>
                        </div>
                    </div>

                    <!-- Presensi Harian -->
                    <div class="info-row">
                        <input type="checkbox" id="chPresensi" name="chPresensi" onchange="changeCbInfo('chPresensi', 'cbPresensi')" class="w-5 h-5 mt-1 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-slate-900">Presensi Harian Siswa</div>
                            <div class="text-[10px] text-emerald-600 font-medium italic mb-2">Data dari JIBAS SPT Fingerprint</div>
                            <div class="flex items-center gap-2"><? ShowCbDateRange('cbPresensi', false) ?></div>
                        </div>
                    </div>

                    <!-- Presensi Kegiatan -->
                    <div class="info-row">
                        <input type="checkbox" id="chKegiatan" name="chKegiatan" onchange="changeCbInfo('chKegiatan', 'cbKegiatan')" class="w-5 h-5 mt-1 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-slate-900">Presensi Kegiatan Siswa</div>
                            <div class="text-[10px] text-emerald-600 font-medium italic mb-2">Data dari JIBAS SPT Fingerprint</div>
                            <div class="flex items-center gap-2"><? ShowCbDateRange('cbKegiatan', false) ?></div>
                        </div>
                    </div>

                    <!-- Nilai CBE -->
                    <div class="info-row lg:col-span-2">
                        <input type="checkbox" id="chCbe" name="chCbe" onchange="changeCbInfo('chCbe', 'cbCbe')" class="w-5 h-5 mt-1 text-emerald-600 bg-white border-slate-300 rounded focus:ring-emerald-500">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-slate-900">Nilai Computer Based Exam</div>
                            <div class="text-[10px] text-emerald-600 font-medium italic mb-2">Data dari JIBAS Computer Based Exam (Ujian Khusus)</div>
                            <div class="flex items-center gap-2"><? ShowCbDateRange('cbCbe', false) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="mt-8 flex justify-center pb-10">
                <button type="submit" class="flex items-center gap-3 bg-emerald-900 hover:bg-emerald-800 text-white font-extrabold text-sm py-4 px-12 rounded-[2rem] shadow-xl shadow-emerald-900/30 transition-all duration-300 active:scale-95 uppercase tracking-widest">
                    <i class="fa-solid fa-file-pdf text-xl"></i> BUAT SURAT SEKARANG
                </button>
            </div>
            
        </form>

    </div>
</body>
</html>
<? CloseDb(); ?>
