<?
 ?>
<?php
$errmsg = array();

// Validasi DEPARTEMEN -----------------------------
$departemen = trim($sheetData[3]["C"]);
if (strlen($departemen) == 0)
{
    $errmsg[] = "Departemen belum ditentukan!";
}
else
{
    $sql = "SELECT COUNT(replid) FROM departemen WHERE departemen = '$departemen'";
    if (0 == (int) FetchSingle($sql))
        $errmsg[] = "Departemen $departemen tidak ditemukan!";
}

$sql = "SELECT replid 
          FROM semester 
         WHERE departemen = '$departemen' 
           AND aktif = 1";
$idsemester = (int) FetchSingle($sql);

// Validasi Id Kelas -------------------------------
$idkelas = trim($sheetData[4]["G"]);
if (strlen($idkelas) == 0)
{
    $errmsg[] = "Id Kelas belum ditentukan!";
}
else
{
    $sql = "SELECT COUNT(replid) FROM kelas WHERE replid = '$idkelas'";
    if (0 == (int) FetchSingle($sql))
        $errmsg[] = "Id Kelas $idkelas tidak ditemukan!";
}

$sql = "SELECT idtingkat 
          FROM kelas
         WHERE replid = '$idkelas'";
$idtingkat = (int) FetchSingle($sql);

// Validasi NIP ------------------------------------
$nip = trim($sheetData[5]["C"]);
if (strlen($nip) == 0)
{
    $errmsg[] = "NIP Guru belum ditentukan!";
}
else
{
    $sql = "SELECT COUNT(replid) FROM pegawai WHERE nip = '$nip'";
    if (0 == (int) FetchSingle($sql))
        $errmsg[] = "NIP Guru $nip tidak ditemukan!";
}

// Validasi Kode Ujian -------------------------------
$kodeujian = trim($sheetData[7]["C"]);
if (strlen($kodeujian) == 0)
{
    $errmsg[] = "Kode ujian belum ditentukan!";
}

// Validasi Tahun ------------------------------------
$tahun = trim($sheetData[8]["G"]);
if (strlen($tahun) != 4)
{
    $errmsg[] = "Tahun ujian belum ditentukan!";
}
else
{
    if (!is_numeric($tahun))
        $errmsg[] = "Tahun ujian harus berupa angka!";
}

// Validasi Bulan ------------------------------------
$bulan = trim($sheetData[8]["E"]);
if (strlen($bulan) == 0 || strlen($bulan) > 2)
{
    $errmsg[] = "Bulan ujian belum ditentukan!";
}
else
{
    if (!is_numeric($bulan))
        $errmsg[] = "Bulan ujian harus berupa angka!";

    if ($bulan < 0 || $bulan > 12)
        $errmsg[] = "Bulan ujian harus antara 1 dan 12!";
}

// Validasi Tanggal ----------------------------------
$tanggal = trim($sheetData[8]["C"]);
if (strlen($tanggal) == 0 || strlen($tanggal) > 2)
{
    $errmsg[] = "Tanggal ujian belum ditentukan!";
}
else
{
    if (!is_numeric($tanggal))
        $errmsg[] = "Tanggal ujian harus berupa angka!";

    $nday = GetMaxDay($tahun, $bulan);
    if ($tanggal < 0 || $tanggal > $nday)
        $errmsg[] = "Tanggal ujian harus antara 1 dan $nday!";
}

$nData = count($sheetData);
if ($nData < 14)
    $errmsg[] = "Data nilai ujian siswa tidak ditemukan!";

for($i = 14; $i <= $nData; $i++)
{
    $nis = trim($sheetData[$i]["B"]);
    if (strlen($nis) == 0) {
        $errmsg[] = "NIS Siswa baris ke-$i belum ditentukan";
    }
    else {
        $nis = str_replace("'", "`", $nis);
        $sql = "SELECT aktif FROM siswa WHERE nis = '$nis'";
        $res2 = QueryDb($sql);
        if (mysqli_num_rows($res2) == 0) {
            $errmsg[] = "NIS Siswa {$nis} baris ke-$i tidak ditemukan!";
        }
        else
        {
            $row2 = mysqli_fetch_row($res2);
            $aktif = $row2[0];
            if ($aktif != 1)
                $errmsg[] = "NIS Siswa {$nis} baris ke-$i tidak aktif!";
        }
    }

    $nilai = trim($sheetData[$i]["D"]);
    if (strlen($nilai) == 0)
        $errmsg[] = "Nilai siswa baris ke-$i belum ditentukan";

    if (!is_numeric($nilai))
        $errmsg[] = "Nilai siswa baris ke-$i harus berupa angka!";

    if ($nilai < 0)
        $errmsg[] = "Nilai siswa baris ke-$i harus lebih besar dari 0!";
}

$selpelajaran = trim($sheetData[6]["C"]);
$selaspek = trim($sheetData[6]["E"]);
$seljenis = trim($sheetData[6]["G"]);
$keterangan = trim($sheetData[11]["C"]);

if (count($errmsg) != 0)
{
    echo "<font style='color:red'><strong>PESAN KESALAHAN:</strong></font><br>";
    for ($i = 0; $i < count($errmsg); $i++)
    {
        echo "<font style='color:red'><strong>- " . $errmsg[$i] . "</strong></font><br>";
    }
    CloseDb();
    exit();
}

?>
