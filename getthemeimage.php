<?
 ?>
<?
require_once('include/common.php');
require_once('include/sessioninfo.php');
require_once('include/config.php');
require_once('include/db_functions.php');
	$id=$_REQUEST['id'];
	$dir=$_REQUEST['dir'];
	OpenDb();
	$res=QueryDb("SELECT replid FROM hakakses WHERE modul='INFOGURU' AND login='".SI_USER_ID()."'");
	$row=@mysqli_fetch_array($res);
	$replid=$row['replid'];
	CloseDb();
	OpenDb();
		$sql="UPDATE hakakses SET theme=$id WHERE replid=$replid";
		//echo $sql;
		//exit;
		$res=QueryDb($sql);
	if ($res){
		unset($_SESSION['theme']);
		$_SESSION['theme']=$id;
	}	
	CloseDb();

?>
<img src="<?=$dir?>" width="320" height="240" align="left"/>