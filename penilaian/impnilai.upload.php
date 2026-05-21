<?
 ?>
<?
require_once('../include/compatibility.php');

$fexcel = $_FILES['fexcel'];

$rand = "";
$dict = "0123456789abcdefghijklmnopqrstuvwxyz";
$dictLen = strlen($dict);
for($i = 0; $i < 32; $i++)
    $rand .= $dict[rand(0, $dictLen - 1)];

$upFile = "../tmp/$rand.xlsx";
move_uploaded_file($fexcel["tmp_name"], $upFile);

echo $upFile;
http_response_code(200);
?>
