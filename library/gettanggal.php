<?
 ?>
<?
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/common.php');

$th = $_REQUEST['tahun'];
$bln = $_REQUEST['bulan'];
$tgl = $_REQUEST['tgl'];
$namatgl = $_REQUEST['namatgl'];
$namabln = $_REQUEST['namabln'];

if ($bln == 4 || $bln == 6|| $bln == 9 || $bln == 11) 
	$n = 30;
else if ($bln == 2 && $th % 4 <> 0) 
	$n = 28;
else if ($bln == 2 && $th % 4 == 0) 
	$n = 29;
else 
	$n = 31;
?>
<select name="<?=$namatgl?>" id="<?=$namatgl?>"  onKeyPress="return focusNext('<?=$namabln?>', event)" onFocus="panggil('<?=$namatgl?>')">
    <option value="">[Tgl]</option>  
<? 	for($i=1;$i<=$n;$i++){ ?>      
    <option value="<?=$i?>" <?=IntIsSelected($tgl, $i)?>><?=$i?></option>
<?	} ?>           
</select>