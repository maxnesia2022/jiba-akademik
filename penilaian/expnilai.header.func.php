<?
 ?>
<?
function ReadParams()
{
    global $departemen, $tingkat, $kelas, $tahunajaran, $semester;

    $departemen="";
    if (isset($_REQUEST['departemen']))
        $departemen=$_REQUEST['departemen'];

    $tingkat = "";
    if (isset($_REQUEST['tingkat']))
        $tingkat=$_REQUEST['tingkat'];

    $kelas = "";
    if (isset($_REQUEST['kelas']))
        $kelas=$_REQUEST['kelas'];

    $tahunajaran = "";
    if (isset($_REQUEST['tahunajaran']))
        $tahunajaran=$_REQUEST['tahunajaran'];

    $semester = "";
    if (isset($_REQUEST['semester']))
        $semester=$_REQUEST['semester'];
}
?>
