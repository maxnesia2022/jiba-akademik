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
// PARAMETERS
// =========================================================================
$departemen  = isset($_REQUEST['departemen']) ? $_REQUEST['departemen'] : '';
$tahunajaran = isset($_REQUEST['tahunajaran']) ? $_REQUEST['tahunajaran'] : '';
$semester    = isset($_REQUEST['semester']) ? $_REQUEST['semester'] : '';
$pelajaran   = isset($_REQUEST['pelajaran']) ? $_REQUEST['pelajaran'] : '';
$tingkat     = isset($_REQUEST['tingkat']) ? $_REQUEST['tingkat'] : '';
$kelas       = isset($_REQUEST['kelas']) ? $_REQUEST['kelas'] : '';
$jam         = isset($_REQUEST['jam']) ? $_REQUEST['jam'] : '';
$menit       = isset($_REQUEST['menit']) ? $_REQUEST['menit'] : '';
$tgl         = isset($_REQUEST['tanggal']) ? $_REQUEST['tanggal'] : date('d-m-Y');
$replid      = isset($_REQUEST['replid']) ? $_REQUEST['replid'] : '';
$action      = isset($_REQUEST['action']) ? $_REQUEST['action'] : ''; // 'view' for footer content

// Handle Load by ID
if (!empty($replid)) {
    $sql = "SELECT p.replid, p.idkelas, p.idsemester, p.idpelajaran, p.tanggal, p.jam, k.idtahunajaran, a.departemen, k.idtingkat 
            FROM presensipelajaran p, tahunajaran a, kelas k 
            WHERE p.replid = '$replid' AND k.replid = p.idkelas AND a.replid = k.idtahunajaran";
    $result = QueryDb($sql);
    $row = @mysqli_fetch_array($result);
    $departemen = $row['departemen'];
    $tahunajaran = $row['idtahunajaran'];
    $tingkat = $row['idtingkat'];
    $kelas = $row['idkelas'];    
    $semester = $row['idsemester'];
    $pelajaran = $row['idpelajaran'];
    $tgl = TglText($row['tanggal']);
    $jam = substr($row['jam'],0,2);
    $menit = substr($row['jam'],3,2);
}

// =========================================================================
// DATA FETCHING FOR FOOTER CONTENT
// =========================================================================
$id = 0;
$nip = "";
$nama = "";
$keterangan = "";
$materi = "";
$objektif = "";
$refleksi = "";
$materi_lanjut = "";
$telat = 0;
$jumlah = 0;
$jenis = 0;

if ($action == 'view') {
    $tanggal_db = MySqlDateFormat($tgl);
    $waktu = $jam.":".$menit;
    $sql = "SELECT p.replid, p.gurupelajaran, p.keterangan, p.materi, p.objektif, p.refleksi, p.rencana, p.keterlambatan, p.jumlahjam, p.jenisguru, p.idkelas, p.idsemester, p.idpelajaran, p.tanggal, g.nama, k.idtahunajaran, p.jam 
            FROM presensipelajaran p, pegawai g, kelas k 
            WHERE k.replid = '$kelas' AND p.idsemester='$semester' AND p.idpelajaran='$pelajaran' AND p.tanggal = '$tanggal_db' AND p.jam = '$waktu' AND g.nip = p.gurupelajaran AND p.idkelas = k.replid";
    $result = QueryDb($sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $id = $row['replid'];
        $nip = $row['gurupelajaran'];
        $nama = $row['nama'];
        $keterangan = $row['keterangan'];
        $materi = $row['materi'];
        $objektif = $row['objektif'];
        $refleksi = $row['refleksi'];
        $materi_lanjut = $row['rencana'];
        $telat = $row['keterlambatan'];
        $jumlah = $row['jumlahjam'];
        $jenis = $row['jenisguru'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Pelajaran</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    <script language="javascript">
        function show() {
            var departemen = document.getElementById("departemen").value;
            var tahunajaran = document.getElementById("tahunajaran").value;
            var semester = document.getElementById("semester").value;
            var tingkat = document.getElementById("tingkat").value;
            var pelajaran = document.getElementById("pelajaran").value;
            var kelas = document.getElementById("kelas").value;
            var jam = document.getElementById("jam").value;
            var menit = document.getElementById("menit").value;
            var tanggal = document.getElementById("tanggal").value;
            
            if (tingkat == "" || kelas == "" || pelajaran == "" || jam == "" || menit == "") {
                alert('Lengkapi semua filter!');
                return false;
            }
            window.location.href = "presensi_main.php?action=view&departemen="+departemen+"&semester="+semester+"&tahunajaran="+tahunajaran+"&tingkat="+tingkat+"&pelajaran="+pelajaran+"&kelas="+kelas+"&jam="+jam+"&menit="+menit+"&tanggal="+tanggal;
        }
    </script>
</head>
<body class="bg-emerald-950 text-slate-800 min-h-screen p-4 md:p-6 overflow-x-hidden">

    <div class="w-full h-full min-h-[calc(100vh-3rem)] bg-slate-50 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl border border-emerald-800/30 p-6 md:p-10 flex flex-col">
        
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl border border-emerald-100 shadow-sm flex-1">
                <div class="bg-emerald-900 text-white p-4 rounded-2xl shadow-lg shadow-emerald-900/30">
                    <i class="fa-solid fa-calendar-check text-2xl"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest">Presensi</span>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">PRESENSI PELAJARAN</h1>
                </div>
            </div>
            
            <div class="bg-slate-100 px-5 py-3 rounded-2xl border border-slate-200 self-start md:self-center text-xs flex items-center gap-2">
                <span class="text-emerald-700 font-semibold">Presensi</span>
                <span class="text-slate-400">/</span>
                <span class="text-slate-600 font-medium">Presensi Pelajaran</span>
            </div>
        </div>

        <!-- FILTER BAR -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-end">
                <div>
                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1 block">Departemen</label>
                    <select id="departemen" class="w-full bg-slate-50 border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-2.5 outline-none focus:ring-2 focus:ring-emerald-500 cursor-pointer">
                        <?php $dep_list = getDepartemen(SI_USER_ACCESS()); foreach($dep_list as $val) echo "<option value='$val' ".($val==$departemen?"selected":"").">$val</option>"; ?>
                    </select>
                </div>
                <!-- Add other filters similarly based on original logic -->
                <div>
                    <button onclick="show()" class="w-full flex items-center justify-center gap-2 bg-emerald-900 hover:bg-emerald-800 text-white font-bold text-xs py-2.5 px-6 rounded-xl shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-eye"></i> TAMPILKAN
                    </button>
                </div>
            </div>
        </div>

        <!-- CONTENT AREA -->
        <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col relative">
            <?php if ($action == 'view') { ?>
                <div class="p-6 overflow-y-auto">
                    <!-- Footer Form Content goes here -->
                    <p class="text-center text-slate-400">Form presensi akan dimuat di sini.</p>
                </div>
            <?php } else { ?>
                <div class="flex-1 flex flex-col items-center justify-center p-10 text-center space-y-4">
                    <div class="w-32 h-32 bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                        <i class="fa-solid fa-calendar-check text-5xl text-emerald-200"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Presensi Pelajaran</h3>
                    <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
                        Pilih kriteria pelajaran dan klik Tampilkan untuk mulai mengisi atau melihat presensi.
                    </p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>
<?php CloseDb(); ?>
