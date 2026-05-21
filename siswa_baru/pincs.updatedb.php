<?
 ?>
<?
$sql = "SELECT COUNT(*)
          FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = 'jbsakad'
           AND TABLE_NAME = 'calonsiswa'
           AND COLUMN_NAME = 'pinsiswa'";
$res = QueryDb($sql);
$row = mysqli_fetch_row($res);
$ndata = $row[0];

if ($ndata == 0)
{
   $sql = "ALTER TABLE `jbsakad`.`calonsiswa` 
             ADD COLUMN `pinsiswa` VARCHAR(25) NOT NULL AFTER `foto`";
   QueryDb($sql);
   
   $sql = "SELECT replid FROM calonsiswa";
   $res = QueryDb($sql);
   while($row = mysqli_fetch_row($res))
   {
      $replid = $row[0];
      $pincs = random(5);
      $sql = "UPDATE calonsiswa SET pinsiswa = '$pincs' WHERE replid = '$replid'";
      QueryDb($sql);
   }
}
?>
