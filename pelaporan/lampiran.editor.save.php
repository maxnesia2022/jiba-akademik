<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/theme.php'); 
require_once('../cek.php');

OpenDb();

$petugas = SI_USER_ID() == "landlord" ? "NULL" : "'" . SI_USER_ID() . "'";

$mode = $_REQUEST['mode'];
$id = $_REQUEST['id'];
$departemen = $_REQUEST['departemen'];
$status = $_REQUEST['status'];

$judul = trim($_REQUEST['judul']);
$judul = str_replace("`", "'", $judul);
$judul = addslashes($judul);

$pengantar = trim($_REQUEST['pengantar']);
$pengantar = str_replace("`", "'", $pengantar);
$pengantar = addslashes($pengantar);

if ($id == 0)
{
    $sql = "INSERT INTO lampiransurat
               SET departemen = '$departemen',
                   tanggal = NOW(),
                   judul = '$judul',
                   pengantar = '$pengantar',
                   petugas = $petugas";
}
else
{
    $sql = "UPDATE lampiransurat
               SET tanggal = NOW(),
                   judul = '$judul',
                   pengantar = '$pengantar',
                   petugas = $petugas
             WHERE replid = $id";
}
QueryDb($sql);

CloseDb();
?>
<script>
    document.location.href = "lampiran.php?departemen=<?=$departemen?>&status=<?=$status?>";
</script>