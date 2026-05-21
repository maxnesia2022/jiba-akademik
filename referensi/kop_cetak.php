<?
 ?>
<?
require_once('../include/errorhandler.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/getheader.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');
require_once('../cek.php');
$departemen=$_REQUEST['departemen'];
$full_url = "../";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="../style/style.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JIBAS SIMAKA [Cetak Header]</title>
<style> 
 @page { 
   @top-left{
       font-family: Helvetica, Arial, sans-serif; 
       font-size: 18pt; 
       font-weight: bolder; 
       content: "XHTML-Print: A Proposal --- August 25, 2000"; 
   } 
 } 
</style>
</head>

<body>
<table border="0" cellpadding="10" cellpadding="5" width="780" align="left">
<tr><td align="left" valign="top">

<?=getHeader($departemen)?>

<center>

</td></tr></table>
</body>
<script language="javascript">
window.print();
</script>
</html>