<?
 ?>
<?
require_once("cek.php");

if (isset($_REQUEST['theme']))
	$theme=$_REQUEST['theme'];
?>
<title>JIBAS - AKADEMIK</title>
<link href="images/jibas2015.ico" rel="shortcut icon" />
<frameset border="0" frameborder="0" framespacing="0" rows="87,*,41">
	<frame name="frametop" src="frametop.php" scrolling="no" noresize="noresize" />
    <frameset border="0" frameborder="0" framespacing="0" cols="20,*,27">
    	<frame name="frameleft" src="frameleft.php" scrolling="no" noresize="noresize" />
        <frame name="content" src="referensi.php"/>
        <frame name="frameright" src="frameright.php" scrolling="no" noresize="noresize" />
    </frameset>
    <frame name="framebottom" src="framebottom.php" scrolling="no" noresize="noresize" />
</frameset><noframes></noframes>