<?
 ?>
<?php
function ReadParams()
{
    global $idtambahan, $idpilihan, $pilihan, $urutan;

    $idtambahan = $_REQUEST['idtambahan'];

    if (isset($_REQUEST['idpilihan']))
        $idpilihan = $_REQUEST['idpilihan'];

    if (isset($_REQUEST['urutan']))
        $urutan = $_REQUEST['urutan'];

    if (isset($_REQUEST['pilihan']))
        $pilihan = CQ($_REQUEST['pilihan']);
}

function ReadData()
{
    global $idpilihan, $pilihan, $urutan;

    OpenDb();

    $sql = "SELECT pilihan, urutan 
              FROM pilihandata 
             WHERE replid = '$idpilihan'";
    $result = QueryDb($sql);
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_row($result);
        $pilihan = $row[0];
        $urutan = $row[1];
    }

    CloseDb();
}

function SaveData()
{
    global $idtambahan, $idpilihan, $pilihan, $urutan;

    global $ERROR_MSG;

    $ERROR_MSG = "";
    if (!isset($_REQUEST['Simpan']))
        return;

    OpenDb();

    $sql = "SELECT * 
              FROM pilihandata 
             WHERE pilihan = '$pilihan'
               AND idtambahan = '$idtambahan'
               AND replid <> '$idpilihan'";
    $result = QueryDb($sql);

    if (mysqli_num_rows($result) > 0)
    {
        CloseDb();
        $ERROR_MSG = "Pilihan $pilihan sudah digunakan!";
    }
    else
    {
        $sql = "UPDATE pilihandata
                   SET pilihan = '$pilihan', urutan = '$urutan' 
                 WHERE replid = '$idpilihan'";
        $result = QueryDb($sql);
        if ($result)
        { ?>
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
