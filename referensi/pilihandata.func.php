<?
 ?>
<?php
function ReadParams()
{
    global $idtambahan, $kolom, $op;

    $idtambahan = 0;
    if (isset($_REQUEST['idtambahan']))
        $idtambahan = $_REQUEST['idtambahan'];

    $op = "";
    if (isset($_REQUEST['op']))
        $op = $_REQUEST['op'];

    $sql = "SELECT kolom FROM tambahandata WHERE replid = '$idtambahan'";
    $kolom = FetchSingle($sql);
}

function ChangeAktif()
{
    $newaktif = $_REQUEST['newaktif'];
    $idpilihan = $_REQUEST['idpilihan'];

    $sql = "UPDATE pilihandata 
               SET aktif = '$newaktif' 
             WHERE replid = '$idpilihan'";
    QueryDb($sql);
}

function HapusData()
{
    $idpilihan = $_REQUEST['idpilihan'];

    $sql = "DELETE FROM pilihandata 
             WHERE replid = '$idpilihan'";
    QueryDb($sql);
}

function ShowDataPilihan($replid)
{

}

function ShowLinkPilihan($replid)
{
    echo "<a onclick='aturPilihan($replid)'>atur pilihan</a>";
}
?>
