<?
 ?>
<?php
function ReadParams()
{
    global $replid, $komentar, $no;

    if (isset($_REQUEST['replid']))
        $replid = $_REQUEST['replid'];

    if (isset($_REQUEST['komentar']))
        $komentar = CQ($_REQUEST['komentar']);

    if (isset($_REQUEST['no']))
        $no = CQ($_REQUEST['no']);

    $komentar = urldecode($komentar);
}

function ReadData()
{
    global $replid, $komentar;

    OpenDb();
    $sql = "SELECT komentar FROM pilihkomenpel WHERE replid = '$replid'";
    $res = QueryDb($sql);
    $row = mysqli_fetch_row($res);
    $komentar = $row[0];
    CloseDb();
}

function SimpanData()
{
    global $replid, $komentar, $no;

    OpenDb();
    $komentar = CQ($komentar);
    $sql = "UPDATE pilihkomenpel 
               SET komentar = '$komentar'
             WHERE replid = '$replid'";
    $result = QueryDb($sql);
    if ($result)
    { 	?>
        <script language="javascript">
            opener.refreshListKomentar(<?=$no?>);
            window.close();
        </script>
        <?
    }
    CloseDb();
    exit();

}
?>