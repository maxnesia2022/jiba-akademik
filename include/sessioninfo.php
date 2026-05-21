<?
 ?>
<?
session_name("jbsakad");
session_start();

$SI_USER_LANDLORD = 0;
$SI_USER_MANAGER = 1;
$SI_USER_STAFF = 2;
$STAFF_DEPT = $_SESSION['departemen'];

function SI_USER_NAME()
{
	return $_SESSION['namasimaka'];
}

function SI_USER_ID()
{
	return $_SESSION['login'];
}

function SI_USER_THEME()
{
	return $_SESSION['temasimaka'];
}

function SI_USER_LEVEL()
{
	switch ($_SESSION['tingkatsimaka']){
	case 0:
		{
	global $SI_USER_LANDLORD;
	return $SI_USER_LANDLORD;
	break;
		}
		case 1:
		{
	global $SI_USER_MANAGER;
	return $SI_USER_MANAGER;
	break;
		}
		case 2:
		{
	global $SI_USER_STAFF;
	return $SI_USER_STAFF;
	break;
		}
	}
}

function SI_USER_ACCESS() {
	if ($_SESSION['tingkatsimaka']==3){
		return '';
	} else if ($_SESSION['tingkatsimaka']==2){
		return $_SESSION['departemensimaka'];
		
	} else {
		return "ALL";
	}
}
?>