<?
 ?>
<?
/*require_once('config.php');
require_once('db_functions.php');
require_once('common.php');
require_once('sessioninfo.php');
*/
function GetThemeDir() {
	OpenDb();
	$sql_tema="Select theme from hakakses where login='".SI_USER_ID()."' AND modul='SIMAKA'";
	$hasil=QueryDb($sql_tema);
	$row_tema=mysqli_fetch_array($hasil);
	$row_tema2=mysqli_num_rows($hasil);

	if ($row_tema2==0){
		$theme=3;
	} else {
		$theme=$row_tema['theme'];
	}
	if ($theme == 1) {
		return "theme/green/";
	} elseif ($theme == 2) {
		return "theme/pink/";
	} elseif ($theme == 3) {
		return "images/default/";
	} elseif ($theme == 4) {
		return "theme/apple/";
	} elseif ($theme == 5) {
		return "theme/vista/";
	} elseif ($theme == 6) {
		return "theme/kopi/";
	} elseif ($theme == 7) {
		return "theme/wood/";
	} elseif ($theme == 8) {
		return "theme/gold/";
	} elseif ($theme == 9) {
		return "theme/granite/";
	}
}
?>