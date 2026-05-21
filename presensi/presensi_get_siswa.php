<?
 ?>
<?
global $nisa;
function lagi() {
	coba(); 
	echo '<br>lagi nyoba lagi'.$nisa[1];
}


function coba() {	
	echo 'jum '.$_REQUEST['jum'];
		for ($i=1;$i<=$_REQUEST['jum'];$i++) {
			$pilih = $_REQUEST['pilih'.$i];
			$nis = $_REQUEST['nis'.$i];
			if ($pilih) {
				$GLOBALS['nisa'][$i] = $nis;
				//lagi($nisa);
			//echo '<br>pilih '.$nis.' '.$i;	
			}
		}		
	return $GLOBALS['nisa'];
}





function coba1() {
	$GLOBALS['nisa'][] = $a;
	//$GLOBALS[nisa][$i] = $nis;
	
}	



?>