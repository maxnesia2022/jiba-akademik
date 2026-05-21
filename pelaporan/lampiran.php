<?
require_once('../include/sessioninfo.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../library/departemen.php');
require_once('../cek.php');
require_once('lampiran.func.php');

$departemen = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : "";
$status = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : 2;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "";

OpenDb();
if ($op == "cqiqywpxwq")
{
	$id = $_REQUEST['id'];
	$sql = "DELETE FROM lampiransurat WHERE replid = $id";
	QueryDb($sql);		 
}
elseif ($op == "mxd238mhde2")
{
	$id = $_REQUEST['id'];
	$newstatus = $_REQUEST['newstatus'];
	
	$sql = "UPDATE lampiransurat SET aktif = $newstatus WHERE replid = $id";
	QueryDb($sql);		 
}

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
    <title>Lampiran Surat</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
        .penyusunan-table th { @apply px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest border-b border-slate-100 bg-slate-50; }
        .penyusunan-table td { @apply px-6 py-4 text-xs border-b border-slate-50; }
    </style>

    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript" src="../script/jquery-1.9.1.js"></script>
    <script language="javascript" src="lampiran.js"></script>
</head>
<body class="bg-green-950 text-slate-800 min-h-screen p-4 md:p-6 select-none overflow-x-hidden">
    <!-- KARTU KONTEN UTAMA (FLOATING CANVAS) -->
    <div class="w-full h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-green-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-green-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-paperclip text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Pelaporan</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">LAMPIRAN SURAT</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <a href="../pelaporanmenu.php" target="content" class="text-emerald-700 hover:underline font-semibold">Pelaporan</a>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Lampiran Surat</span>
            </div>
        </div>

        <!-- Filter Controls Row -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-6">
                <!-- Departemen -->
                <div class="flex items-center gap-3">
                    <label for="departemen" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Departemen</label>
                    <div class="relative">
                        <select name="departemen" id="departemen" onChange="changeSelect()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                            <? $dep = getDepartemen(SI_USER_ACCESS());    
                            foreach($dep as $value) { ?>
                                <option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> ><?=$value ?></option>
                            <? } ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-center gap-3">
                    <label for="status" class="text-sm font-bold text-slate-700 uppercase tracking-wider text-xs">Status</label>
                    <div class="relative">
                        <select name="status" id="status" onChange="changeSelect()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-44 pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
                            <option value='2' <?= IntIsSelected($status, 2)?>>(Semua)</option>
                            <option value='1' <?= IntIsSelected($status, 1)?>>Aktif</option>
                            <option value='0' <?= IntIsSelected($status, 0)?>>Non Aktif</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-slate-500">
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5">
                <button onClick="refresh();" class="p-2.5 bg-slate-100 text-slate-600 rounded-xl hover:bg-slate-200 transition-colors" title="Refresh">
                    <i class="fa-solid fa-rotate-right"></i>
                </button>
                <? if (SI_USER_LEVEL() != $SI_USER_STAFF) { ?>
                    <button onClick="tambah()" class="flex items-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all duration-200 active:scale-95">
                        <i class="fa-solid fa-plus"></i> Tambah Lampiran
                    </button>
                <? } ?>
            </div>
        </div>

        <!-- Content Area (Table) -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="overflow-y-auto flex-1 p-1">
                <table class="w-full text-left border-separate border-spacing-0 penyusunan-table">
                    <thead>
                        <tr class="bg-slate-50 sticky top-0 z-10">
                            <th class="rounded-tl-2xl text-center" width="50">No</th>
                            <th width="200">Tanggal/Petugas</th>
                            <th width="*">Judul/Lampiran Surat</th>
                            <th class="text-center" width="100">Aktif</th>
                            <th class="rounded-tr-2xl text-center" width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <? ShowList() ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
<? CloseDb(); ?>
