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

OpenDb();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Jenis Pengujian</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome for Premium Colorful Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script language="javascript" src="../script/tables.js"></script>
    <script language="javascript" src="../script/tools.js"></script>
    <script language="javascript">
    function refresh() {	
        document.location.reload();
    }

    function tampil() {		
        var departemen = document.getElementById('departemen').value;
        document.location.href = "jenis_pengujian_menu.php?departemen="+departemen;
        parent.document.getElementById('content_frame').src = "blank_pengujian.php";
    }

    function pilih(id,nama_dep,nama_pel) {		
        parent.document.getElementById('content_frame').src = "jenis_pengujian_content.php?id="+id+"&nama_dep="+nama_dep+"&nama_pel="+nama_pel;
        
        // Highlight selected row
        var rows = document.querySelectorAll('tr[data-id]');
        rows.forEach(row => {
            row.classList.remove('bg-emerald-50', 'border-emerald-200');
            row.classList.add('hover:bg-slate-50');
        });
        var selectedRow = document.querySelector('tr[data-id="'+id+'"]');
        if (selectedRow) {
            selectedRow.classList.add('bg-emerald-50', 'border-emerald-200');
            selectedRow.classList.remove('hover:bg-slate-50');
        }
    }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: white;
        }
        /* Hide scrollbar but keep functionality */
        ::-webkit-scrollbar {
            width: 4px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</head>
<body class="p-4 overflow-x-hidden" onload="document.getElementById('departemen').focus()">
    <!-- Departemen Filter -->
    <div class="mb-6">
        <label for="departemen" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2 block">Departemen</label>
        <div class="relative">
            <select name="departemen" id="departemen" onChange="tampil()" class="appearance-none bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-3 pr-8 py-2.5 shadow-sm transition-colors cursor-pointer">
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

    <div class="space-y-2">
        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-2 mb-2">Daftar Pelajaran</h3>
        
        <?
        $sql = "SELECT replid,nama,departemen,kode FROM pelajaran WHERE departemen = '$departemen' ORDER BY nama";
        $result = QueryDb($sql);
        if (@mysqli_num_rows($result) > 0) {
            while ($row = @mysqli_fetch_array($result)) {
        ?>
            <div data-id="<?=$row[0]?>" onClick="pilih('<?=$row[0]?>','<?=$row[2]?>','<?=$row[1]?>')" class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent hover:bg-slate-50 transition-all cursor-pointer active:scale-[0.98]">
                <div class="w-10 h-10 bg-slate-100 group-hover:bg-white flex items-center justify-center rounded-xl text-emerald-700 font-bold text-xs shadow-sm transition-colors uppercase">
                    <?=$row[3]?>
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-xs font-bold text-slate-800 truncate"><?=$row[1]?></p>
                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-tighter italic"><?=$row[2]?></p>
                </div>
                <div class="text-slate-300 group-hover:text-emerald-500 transition-colors">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </div>
            </div>
        <? } } else { ?>
            <div class="p-8 text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                <i class="fa-solid fa-face-meh text-slate-300 text-2xl mb-2"></i>
                <p class="text-[10px] font-bold text-slate-400 uppercase leading-tight">Tidak ada pelajaran</p>
            </div>
        <? } ?>
    </div>
</body>
</html>
<? CloseDb(); ?>
