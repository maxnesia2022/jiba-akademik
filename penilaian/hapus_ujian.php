<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/theme.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
?>

<?
OpenDb();
$query1 = "DELETE FROM ujian WHERE replid = '$_GET[id]'";
$result1 = QueryDb($query1);

$query2 = "DELETE FROM nau WHERE idujian = '$_GET[id]'";
$result2 = QueryDb($query2);

$query3 = "DELETE FROM rataus WHERE idujian = '$_GET[id]'";
$result3 = QueryDb($query3);

$row = @mysqli_fetch_array($result1);

if(mysqli_affected_rows($mysqlconnection) > 0) {
?>
    <script language="JavaScript">
        //alert("Jenis Penilaian Siswa berhasil dihapus");
        document.location.href="tampil_nilai_pelajaran.php?jenis_penilaian=<?=$_GET['jenis_penilaian'] ?>&departemen=<?=$_GET['departemen'] ?>&tahun=<?=$_GET[tahun] ?>&tingkat=<?=$_GET[tingkat] ?>&semester=<?=$_GET[semester] ?>&pelajaran=<?=$_GET[pelajaran] ?>&kelas=<?=$_GET[kelas] ?>";
    </script>
<?
}
else {
?>
    <script language="JavaScript">
        //alert('Ujian gagal dihapus!');
		document.location.href="tampil_nilai_pelajaran.php?jenis_penilaian=<?=$_GET['jenis_penilaian'] ?>&departemen=<?=$_GET['departemen'] ?>&tahun=<?=$_GET[tahun] ?>&tingkat=<?=$_GET[tingkat] ?>&semester=<?=$_GET[semester] ?>&pelajaran=<?=$_GET[pelajaran] ?>&kelas=<?=$_GET[kelas] ?>";
    </script>

<?
}
CloseDb();
?>