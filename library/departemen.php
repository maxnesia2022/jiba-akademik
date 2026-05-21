<?
 ?>
<?
require_once('../include/common.php');
require_once('../include/config.php');
require_once('../include/db_functions.php');
require_once('../include/sessioninfo.php');

function getDepartemen($access)
{
	if ($access == "ALL")
	{
		$sql = "SELECT departemen FROM departemen where aktif=1 ORDER BY urutan ";
		$result = QueryDb($sql);
		$i = 0;
		while($row = mysqli_fetch_row($result))
		{
			$dep[$i] = $row[0];
			$i++;
		}
	}
	else
	{
		$i = 0;
		foreach($access as $value)
		{
			$dep[$i] = $value;
			$i++;
		}
	}
	
	return $dep;
}

function getDepartemenStringList($access)
{
	$depList = "";
	if ($access == "ALL")
	{
		$sql = "SELECT departemen FROM departemen where aktif=1 ORDER BY urutan ";
		$result = QueryDb($sql);
		$i = 0;
		while($row = mysqli_fetch_row($result))
		{
			if ($depList != "")
				$depList .= ",";
			
			$depList .= "'" . $row[0] . "'";	
		}
	}
	else
	{
		$i = 0;
		foreach($access as $value)
		{
			if ($depList != "")
				$depList .= ",";
				
			$depList .= "'" . $value . "'";		
		}
	}
	
	return $depList;
}
?>