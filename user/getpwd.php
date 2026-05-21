<?
 ?>
<?
require_once("../include/theme.php");
require_once('../include/errorhandler.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../cek.php');
$nip = $_REQUEST['nip'];
OpenDb();
$sql = "SELECT * FROM login WHERE login='$nip'";
//echo $sql;
$result = QueryDb($sql);
$num = @mysqli_num_rows($result);
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<?
if ($num==0){
?>
<tr>
<td width="158"><strong>Password</strong></td>
<td width="1073"><input type="password" size="25" maxlength="100" name="password" <?=$dis ?> id="password" onKeyPress="return focusNext('konfirmasi', event)" onFocus="panggil('password')" value="<?=$_REQUEST['password']?>"></td>
</tr>
<tr>
<td width="158"><strong>Konfirmasi</strong></td>
<td><input type="password" size="25" maxlength="100" name="konfirmasi" <?=$dis ?> id="konfirmasi" onKeyPress="return focusNext('status_user', event)" onFocus="panggil('konfirmasi')" value="<?=$_REQUEST['konfirmasi']?>" ></td>
</tr>
<input type="hidden" id="haspwd" value="0" />
<? } else { ?>
<tr>
<td colspan="2" align="center"><span style="color: #FF9900; font-weight: bold;">Pengguna sudah memiliki password</span></td>
</tr>
<input type="hidden" id="haspwd" value="1" />
<? } ?>
</table>