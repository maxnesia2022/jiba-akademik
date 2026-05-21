<?
 ?>
<? 
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../library/departemen.php');

$departemen = $_REQUEST['departemen'];
OpenDb();
?>
<select name="departemen" id="departemen" onchange="change_dep()" style="width:280px">
<? 	$dep = getDepartemen(SI_USER_ACCESS());    
 	foreach($dep as $value) {
		if ($departemen == "")
			$departemen = $value; ?>
  	<option value="<?=$value ?>" <?=StringIsSelected($value, $departemen) ?> >
  <?=$value ?>
  </option>
  <?	} ?>
</select>