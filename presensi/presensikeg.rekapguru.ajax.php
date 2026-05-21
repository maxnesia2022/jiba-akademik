<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/compatibility.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');
require_once('presensikeg.rekapguru.func.php');

try
{
    OpenDb();
    
    $op = $_REQUEST['op'];
    if ($op == "getpegawai")
    {
        $bulan = $_REQUEST['bulan'];
        $tahun = $_REQUEST['tahun'];
        $bagian = $_REQUEST['bagian'];
        
        echo GetPegawai($bulan, $tahun, $bagian);
    }
    else if ($op == "searchpegawai")
    {
        $bulan = $_REQUEST['bulan'];
        $tahun = $_REQUEST['tahun'];
        $filter = $_REQUEST['filter'];
        $keyword = $_REQUEST['keyword'];
        
        echo SearchPegawai($bulan, $tahun, $filter, $keyword);
    }
    
    CloseDb();
    
    http_response_code(200);
}
catch(DbException $dbe)
{
    CloseDb();
    
    http_response_code(500);
    echo $dbe->getMessage();
}
catch(Exception $e)
{
    CloseDb();
    
    http_response_code(500);
    echo $e->getMessage();
}   


?>