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
require_once('presensikeg.siswa2.func.php');

try
{
    OpenDb();
    
    $op = $_REQUEST['op'];
    if ($op == "getcbactivity")
    {
        $aktif = $_REQUEST['aktif'];
        GetCbActivity($aktif);    
    }
    else if ($op == "getcbtingkat")
    {
        $departemen = $_REQUEST['departemen'];
        
        echo GetCbTingkat($departemen, 0);
    }
    else if ($op == "getcbkelas")
    {
        $idtingkat = $_REQUEST['idtingkat'];
        
        echo GetCbKelas($idtingkat, 0);
    }
    else if ($op == "getsiswa")
    {
        $idkegiatan = $_REQUEST['idkegiatan'];
        $bulan = $_REQUEST['bulan'];
        $tahun = $_REQUEST['tahun'];
        $idkelas = $_REQUEST['idkelas'];
        
        echo GetSiswa($idkegiatan, $bulan, $tahun, $idkelas);
    }
    else if ($op == "searchsiswa")
    {
        $idkegiatan = $_REQUEST['idkegiatan'];
        $bulan = $_REQUEST['bulan'];
        $tahun = $_REQUEST['tahun'];
        $filter = $_REQUEST['filter'];
        $keyword = $_REQUEST['keyword'];
        
        echo SearchSiswa($idkegiatan, $bulan, $tahun, $filter, $keyword);
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