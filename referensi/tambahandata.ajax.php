<?
 ?>
<?php
require_once('../include/db_functions.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/compatibility.php');
require_once('tambahandata.func.php');

$op = $_REQUEST['op'];

if ($op == "getdatapilihan")
{
    $idtambahan = $_REQUEST['idtambahan'];

    OpenDb();
    echo GetDataPilihan($idtambahan);
    CloseDb();

    http_response_code(200);
}
?>