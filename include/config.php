<?
 ?>
<?

// ------------------------------------------------------------
// PATCH MANAGEMENT FRAMEWORK                                  
// ------------------------------------------------------------

if (file_exists('../include/global.patch.manager.php'))
{
	require_once('../include/global.patch.manager.php');
	ApplyGlobalPatch("..");	
}
elseif (file_exists('../../include/global.patch.manager.php'))
{
	require_once('../../include/global.patch.manager.php');
	ApplyGlobalPatch("../..");
}
elseif (file_exists('../../../include/global.patch.manager.php'))
{
	require_once('../../../include/global.patch.manager.php');
	ApplyGlobalPatch("../../..");
}

require_once('module.patch.manager.php');
ApplyModulePatch();

// ------------------------------------------------------------
// MAIN CONFIGURATION                                          
// ------------------------------------------------------------
	
if (file_exists('../include/mainconfig.php'))
{
	require_once('../include/mainconfig.php');
}
elseif (file_exists('../../include/mainconfig.php'))
{
	require_once('../../include/mainconfig.php');
}
elseif (file_exists('../../../include/mainconfig.php'))
{
	require_once('../../../include/mainconfig.php');
}

// ------------------------------------------------------------
// DEFAULT CONSTANTS                                           
// ------------------------------------------------------------

$G_ENABLE_QUERY_ERROR_LOG = false;
$db_name = "maxkeuangan";
$full_url = "http://$G_SERVER_ADDR/akademik/";

// ------------------------------------------------------------
// FORMAT SPECIAL CHARACTERS WITHIN ALL REQUEST
// ------------------------------------------------------------

function FmtReq_PreventInjection($value)
{
    $result = $value;
    $loValue = strtolower($result);

    $arrKeyFound = array();
    $arrKey = array("union ", "union*", "select ", "select*", "-- ");
    for($i = 0; $i < count($arrKey); $i++)
    {
        $key = $arrKey[$i];
        $keyLen = strlen($key);

        $pos = strpos($loValue, $key);
        if ($pos === false)
            continue;

        $search = substr($result, $pos, $keyLen);
        $arrKeyFound[] = $search;
    }

    for($i = 0; $i < count($arrKeyFound); $i++)
    {
        $search = $arrKeyFound[$i];
        $replace = substr($search, 0, 1) . " " . substr($search, 1);
        $result = str_replace($search, $replace, $result);
    }

    return $result;
}


function FmtReq_FormatValue($value)
{
    $value = str_replace("'", "`", $value);  //&#39;
	$value = str_replace('"', "`", $value);  //&#34;
	$value = addslashes($value);

    return FmtReq_PreventInjection($value);
}

function FmtReq_TraverseRequestArray(&$arr)
{
    foreach($arr as $key => $value)
    {
        if (is_array($arr[$key]))
            FmtReq_TraverseRequestArray($arr[$key]);
        else
            $arr[$key] = FmtReq_FormatValue($value);
    }
}

foreach($_REQUEST as $key => $value)
{
    if (is_array($_REQUEST[$key]))
        FmtReq_TraverseRequestArray($_REQUEST[$key]);
    else
        $_REQUEST[$key] = FmtReq_FormatValue($value);
}
?>