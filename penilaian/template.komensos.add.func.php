<?
 ?>
<?php
function ReadParams()
{
    global $idpelajaran, $idtingkat, $komentar, $jenis;

    if (isset($_REQUEST['idpelajaran']))
        $idpelajaran = $_REQUEST['idpelajaran'];

    if (isset($_REQUEST['idtingkat']))
        $idtingkat = $_REQUEST['idtingkat'];

    if (isset($_REQUEST['komentar']))
        $komentar = CQ($_REQUEST['komentar']);

    if (isset($_REQUEST['jenis']))
        $jenis = CQ($_REQUEST['jenis']);

    $komentar = urldecode($komentar);
}

function SimpanData()
{
    global $idpelajaran, $idtingkat, $komentar, $jenis;

    if (!isset($_REQUEST['Simpan']))
        return;

    OpenDb();
    $komentar = CQ($komentar);
    $sql = "INSERT INTO pilihkomensos 
               SET idpelajaran = '$idpelajaran',
                   idtingkat = '$idtingkat',
                   jenis = '$jenis',
                   komentar = '$komentar'";
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