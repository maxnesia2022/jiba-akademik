<?
 ?>
<?php
function ReadParams()
{
    global $replid, $kolom, $jenis, $keterangan, $departemen, $urutan;

    $replid = $_REQUEST['replid'];

    if (isset($_REQUEST['departemen']))
        $departemen = $_REQUEST['departemen'];

    if (isset($_REQUEST['kolom']))
        $kolom = CQ($_REQUEST['kolom']);

    if (isset($_REQUEST['jenis']))
        $jenis = $_REQUEST['jenis'];

    if (isset($_REQUEST['urutan']))
        $urutan = $_REQUEST['urutan'];

    if (isset($_REQUEST['keterangan']))
        $keterangan = CQ($_REQUEST['keterangan']);
}

function ReadData()
{
    global $replid, $kolom, $jenis, $keterangan, $departemen, $urutan;

    OpenDb();

    $sql = "SELECT kolom, jenis, keterangan, departemen, urutan 
              FROM tambahandata 
             WHERE replid = '$replid'";
    $result = QueryDb($sql);
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_row($result);
        $kolom = $row[0];
        $jenis = $row[1];
        $keterangan = $row[2];
        $departemen = $row[3];
        $urutan = $row[4];
    }

    CloseDb();
}

function SaveData()
{
    global $replid, $kolom, $jenis, $keterangan, $departemen, $urutan;

    global $ERROR_MSG;

    $ERROR_MSG = "";
    if (!isset($_REQUEST['Simpan']))
        return;

    OpenDb();

    $sql = "SELECT * 
              FROM tambahandata 
             WHERE kolom = '$kolom' 
               AND departemen = '$departemen'
               AND replid <> '$replid'";
    $result = QueryDb($sql);

    if (mysqli_num_rows($result) > 0)
    {
        CloseDb();
        $ERROR_MSG = "Nama kolom $kolom sudah digunakan!";
     }
    else
    {
        $sql = "UPDATE tambahandata
                   SET kolom = '$kolom',
                       jenis = '$jenis', 
                       keterangan = '$keterangan',
                       urutan = '$urutan'
                 WHERE replid = '$replid'";
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
