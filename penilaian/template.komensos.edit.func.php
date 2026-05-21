<?
 ?>
<?php
function ReadParams()
{
    global $replid, $komentar, $jenis;

    if (isset($_REQUEST['replid']))
        $replid = $_REQUEST['replid'];

    if (isset($_REQUEST['komentar']))
        $komentar = CQ($_REQUEST['komentar']);

    if (isset($_REQUEST['jenis']))
        $jenis = CQ($_REQUEST['jenis']);

    $komentar = urldecode($komentar);
}

function ReadData()
{
    global $replid, $komentar;

    OpenDb();
    $sql = "SELECT komentar FROM pilihkomensos WHERE replid = '$replid'";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $komentar = $row[0];
    CloseDb();
}

function SimpanData()
{
    global $replid, $komentar, $jenis;

    OpenDb();
    $komentar = CQ($komentar);
    $sql = "UPDATE pilihkomensos 
               SET komentar = '$komentar'
             WHERE replid = '$replid'";
    $result = QueryDb($sql);
    if ($result)
    { 	?>
        <script language="javascript">
            opener.refreshListKomentarSos('<?=$jenis?>');
            window.close();
        </script>
        <?
    }
    CloseDb();
    exit();

}
?>