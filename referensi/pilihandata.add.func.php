<?
 ?>
<?php
function ReadParams()
{
    global $idtambahan, $pilihan, $urutan;

    if (isset($_REQUEST['idtambahan']))
        $idtambahan = $_REQUEST['idtambahan'];

    if (isset($_REQUEST['urutan']))
        $urutan = $_REQUEST['urutan'];

    if (isset($_REQUEST['pilihan']))
        $pilihan = CQ($_REQUEST['pilihan']);
}

function SimpanData()
{
    global $ERROR_MSG;
    global $idtambahan, $pilihan, $urutan;

    $ERROR_MSG = "";
    if (!isset($_REQUEST['Simpan']))
        return;

    OpenDb();

    $sql = "SELECT replid 
              FROM pilihandata 
             WHERE pilihan = '$pilihan'
               AND idtambahan = '$idtambahan'";
    $result = QueryDb($sql);

    if (mysqli_num_rows($result) > 0)
    {
        CloseDb();
        $ERROR_MSG = "Pilihan $pilihan sudah digunakan!";
    }
    else
    {
        $sql = "INSERT INTO pilihandata 
                   SET idtambahan = '$idtambahan', pilihan = '$pilihan', urutan = '$urutan'";
        $result = QueryDb($sql);
        if ($result)
        { 	?>
            <script language="javascript">
                opener.refresh();
                window.close();
            </script>
            <?
        }
        CloseDb();
        exit();
    }
}
?>
