<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/compatibility.php');
require_once('komentar.sos.func.php');

$op = $_REQUEST['op'];

if ($op == "getlistkomentar")
{
    $idpelajaran = $_REQUEST['idpelajaran'];
    $idtingkat = $_REQUEST['idtingkat'];
    $jenis = $_REQUEST['jenis'];

    OpenDb();
    echo GetListKomentar($idpelajaran, $idtingkat, $jenis);
    CloseDb();

    http_response_code(200);
}
else if ($op == "getkomentar")
{
    $replid = $_REQUEST['replid'];

    OpenDb();
    echo GetKomentar($replid);
    CloseDb();

    http_response_code(200);
}
else if ($op == "delkomentar")
{
    $replid = $_REQUEST['replid'];

    $idpelajaran = $_REQUEST['idpelajaran'];
    $idtingkat = $_REQUEST['idtingkat'];
    $jenis = $_REQUEST['jenis'];

    OpenDb();
    $sql = "DELETE FROM pilihkomensos WHERE replid = '$replid'";
    QueryDb($sql);

    echo GetListKomentar($idpelajaran, $idtingkat, $jenis);
    CloseDb();

    http_response_code(200);
}
?>