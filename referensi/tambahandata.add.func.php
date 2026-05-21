<?
 ?>
<?php
function ReadParams()
{
    global $kolom, $jenis, $keterangan, $departemen, $urutan;

    if (isset($_REQUEST['departemen']))
        $departemen = CQ($_REQUEST['departemen']);

    if (isset($_REQUEST['kolom']))
        $kolom = CQ($_REQUEST['kolom']);

    if (isset($_REQUEST['urutan']))
        $urutan = CQ($_REQUEST['urutan']);

    if (isset($_REQUEST['jenis']))
        $jenis = CQ($_REQUEST['jenis']);

    if (isset($_REQUEST['keterangan']))
        $keterangan = CQ($_REQUEST['keterangan']);
}

function SimpanData()
{
    global $ERROR_MSG;
    global $kolom, $jenis, $keterangan, $departemen, $urutan;

    $ERROR_MSG = "";
    if (!isset($_REQUEST['Simpan']))
        return;

    OpenDb();

    $sql = "SELECT replid 
              FROM tambahandata 
             WHERE kolom = '$kolom'
               AND departemen = '$departemen'";
    $result = QueryDb($sql);

    if (mysqli_num_rows($result) > 0)
    {
        CloseDb();
        $ERROR_MSG = "Nama kolom $kolom sudah digunakan!";
        $cek = 0;
    }
    else
    {
        $sql = "INSERT INTO tambahandata 
                   SET departemen = '$departemen', kolom = '$kolom', urutan = '$urutan',
                       jenis = '$jenis', aktif = 1, keterangan = '$keterangan'";
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
