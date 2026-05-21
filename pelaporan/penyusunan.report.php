<?
 ?>
<?
require_once('../include/sessioninfo.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/compatibility.php');
require_once('../include/getheader.php');
require_once('../include/rupiah.php');
require_once('../library/departemen.php');
require_once('../library/datearith.php');
require_once('../cek.php');
require_once('penyusunan.report.func.php');
require_once('colorfactory.php');

OpenDb();

$fname = GetFileName();

header("Content-Type: application/vnd.ms-excel"); //IE and Opera
header("Content-Type: application/w-msword"); // Other browsers  
header("Content-Disposition: attachment; filename=$fname");
header("Expires: 0");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

SetDocHeader($ndata, $fname);

$nisList = GetNisList($ndata);
if (strlen(trim($nisList)) == 0)
{
    echo "Tidak ada data siswa!";
    
    CloseDb();
    exit();
}

$idpengantar = $_REQUEST['pengantar'];
$sql = "SELECT pengantar
          FROM pengantarsurat
         WHERE replid = $idpengantar";
$res = QueryDb($sql);
$row = mysqli_fetch_row($res);
$pengantar = $row[0];

$lampiran = "";
if (isset($_REQUEST['chLampiran']))
{
    $idlampiran = $_REQUEST['lampiran'];
    $sql = "SELECT pengantar
              FROM lampiransurat
             WHERE replid = $idlampiran";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $lampiran = $row[0];
}

$showinfo = isset($_REQUEST['chNilai']) ||
            isset($_REQUEST['chKeuangan']) ||
            isset($_REQUEST['chPresensi']) ||
            isset($_REQUEST['chKegiatan']) ||
            isset($_REQUEST['chCbe']);

$alamat = 1 == (int)$_REQUEST['alamat'] ? "s.alamatsiswa AS alamat" : "s.alamatortu AS alamat";
$sql = "SELECT s.nis, UCASE(s.nama) AS nama, s.alamatsiswa, s.kodepossiswa, k.kelas, t.departemen, s.pinsiswa,
               IF(s.almayah = 0, CONCAT('Bapak ', UCASE(s.namaayah)), IF(s.almibu = 0, CONCAT('Ibu ', UCASE(s.namaibu)), '')) AS ortu
          FROM siswa s, kelas k, tingkat t
         WHERE s.idkelas = k.replid
           AND k.idtingkat = t.replid
           AND s.nis IN ($nisList)";

$res = QueryDb($sql);
$no = 0;
while($row = mysqli_fetch_array($res))
{
    $no += 1;
    
    $nis = $row['nis'];
    $nama = $row['nama'];
    $alamat = $row['alamatsiswa'];
    $kodepos = $row['kodepossiswa'];
    $kelas = $row['kelas'];
    $departemen = $row['departemen'];
    $pin = $row['pinsiswa'];
    $ortu = $row['ortu'];
    
    echo "<div class=Section$no>\r\n";
    SetHeader();
    SetAddress();
    SetPengantar();    
    echo "</div>\r\n";
    
    SectionBreak();
    
    if ($lampiran != "")
    {
        echo "<div class=SectionLampiran$no>\r\n";
        
        echo "<center>\r\n";
        echo "<font style='font-size:16px; font-family: Arial; font-weight: bold;'>LAMPIRAN</font><br>";
        echo "<font style='font-size:11px; color: #999; font-family: Arial; font-style: italic;'>$nis $nama ($kelas)</font>";
        echo "</center><br><br>\r\n";
    
        SetLampiran();
        
        echo "</div>\r\n";
        
        SectionBreak();
    }
    
    if ($showinfo)
    {
        echo "<div class=SectionInfo$no>\r\n";
        
        echo "<center>\r\n";
        echo "<font style='font-size:18px; font-family: Arial; font-weight: bold;'>INFORMASI</font><br>";
        echo "<font style='font-size:11px; color: #999; font-family: Arial; font-style: italic;'>$nis $nama ($kelas)</font>";
        echo "</center><br><br>\r\n";
    
        if (isset($_REQUEST['chNilai']))
            SetInfoNilai();
            
        if (isset($_REQUEST['chKeuangan']))
            SetInfoKeuangan();
            
        if (isset($_REQUEST['chPresensi']))
            SetInfoPresensi();
        
        if (isset($_REQUEST['chKegiatan']))
            SetInfoKegiatan();

        if (isset($_REQUEST['chCbe']))
            SetNilaiCbe();
            
        echo "</div>";
        
        SectionBreak();
    }
}

foreach($_REQUEST as $key => $val)
{
    //echo "$key = $val<br>";
}

SetDocFooter();

CloseDb();
?>
