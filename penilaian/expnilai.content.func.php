<?
 ?>
<?
function ReadParam()
{
    global $departemen, $tingkat, $kelas, $tahunajaran, $semester, $filename;

    $departemen="";
    if (isset($_REQUEST['departemen']))
        $departemen = $_REQUEST['departemen'];

    $tingkat = "";
    if (isset($_REQUEST['tingkat']))
        $tingkat = $_REQUEST['tingkat'];

    $kelas = "";
    if (isset($_REQUEST['kelas']))
        $kelas = $_REQUEST['kelas'];

    $tahunajaran = "";
    if (isset($_REQUEST['tahunajaran']))
        $tahunajaran = $_REQUEST['tahunajaran'];

    $semester = "";
    if (isset($_REQUEST['semester']))
        $semester = $_REQUEST['semester'];

    $filename = "";
    if (isset($_REQUEST['filename']))
        $filename = urldecode($_REQUEST['filename']);
}

function SafeName($name)
{
    $name = str_replace("'", "", $name);
    $name = str_replace("\"", "", $name);
    $name = str_replace("/", "", $name);
    $name = str_replace("!", "", $name);
    return $name;
}
?>