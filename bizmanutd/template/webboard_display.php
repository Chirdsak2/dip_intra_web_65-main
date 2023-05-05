<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("ewt_script.php");
	$sql = $db->query("select * from w_config");
	$R = $db->db_fetch_array($sql);
	//case  introduce webboard
	if($R[c_show_main2] == 'Y'){
		
	}
	//case category
	if($R[c_show_main] == 'Y'){
		$type = $R[c_show_main_option];
		?>
		<!--start body-->
			<div id="category_swebb"></div>
			<script language="javascript">
				category_swebb('<?php echo $type;?>');
			</script>
		<!--End body-->
		<?php
	}
	//case webboard
	if($R[c_show_main3] == 'Y'){
		
	}
?>
<?php $db->db_close(); ?>
