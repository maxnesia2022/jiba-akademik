<?
 ?>
<?php
function ReadParams()
{
    global $idpelajaran, $idtingkat, $kdaspek, $komentar, $no;

    if (isset($_REQUEST['idpelajaran']))
        $idpelajaran = $_REQUEST['idpelajaran'];

    if (isset($_REQUEST['idtingkat']))
        $idtingkat = $_REQUEST['idtingkat'];

    if (isset($_REQUEST['kdaspek']))
        $kdaspek = CQ($_REQUEST['kdaspek']);

    if (isset($_REQUEST['komentar']))
        $komentar = CQ($_REQUEST['komentar']);

    if (isset($_REQUEST['no']))
        $no = CQ($_REQUEST['no']);

    $komentar = urldecode($komentar);
}

function SimpanData()
{
    global $idpelajaran, $idtingkat, $kdaspek, $komentar, $no;

    if (!isset($_REQUEST['Simpan']))
        return;

    OpenDb();
    $komentar = CQ($komentar);
    $sql = "INSERT INTO pilihkomenpel 
               SET idpelajaran = '$idpelajaran',
                   idtingkat = '$idtingkat',
                   dasarpenilaian = '$kdaspek',
                   komentar = '$komentar'";
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