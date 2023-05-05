<?php
session_start();
if($_GET["Flag"] == "Set"){
		session_register("EWT_USE_W3C");
		$_SESSION["EWT_USE_W3C"] = "Y";
?>
<script language="javascript">
	window.location.href = "<?php echo $HTTP_REFERER; ?>";
</script>
<?php
}else{
		$_SESSION["EWT_USE_W3C"] = "";
		session_unregister("EWT_USE_W3C");
		?>
<script language="javascript">
	window.location.href = "<?php echo $HTTP_REFERER; ?>";
</script>
<?php
}
?>