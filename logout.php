<?
 ?>
<?
session_name("jbsakad");
session_start();

unset($_SESSION['login']);
unset($_SESSION['namasimaka']);
unset($_SESSION['tingkatsimaka']);
unset($_SESSION['departemensimaka']);
unset($_SESSION['errtype']);
unset($_SESSION['errfile']);
unset($_SESSION['errno']);
unset($_SESSION['errmsg']);
unset($_SESSION['issend']);
$_SESSION['maintenance'] = false;
?>
<script language="javascript">
	top.window.location='../akademik/';
</script>
