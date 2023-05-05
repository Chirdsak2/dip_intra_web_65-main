<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("cms","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.close();
				</script>
				<?php
}
		if(!(session_is_registered("EWT_OPEN_FOLDER"))){
			session_register("EWT_OPEN_FOLDER");
		}	
		if($_SESSION["EWT_OPEN_FOLDER"] != ""){
			$sql_group = $db->query("SELECT Main_Group_ID FROM temp_main_group WHERE Main_Group_ID = '".$_SESSION["EWT_OPEN_FOLDER"]."' ");
			if($db->db_num_rows($sql_group) == 1){
				$link_page = "content_view.php?gid=".$_SESSION["EWT_OPEN_FOLDER"];
			}else{
				$link_page = "content_index.php?pass=Y";
			}
		}else{
			$link_page = "content_index.php?pass=Y";
		}
	?>
<head>
<title>Open</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<frameset name="mcontent_frame" rows="0,*,26"  frameborder="0">
<frame src="../FileMgt/module_obj.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>" name="module_obj" frameborder="0" scrolling="NO" noresize >
		<frameset name="content_frame" cols="250,*" rows="*" frameborder="0" >
				<frame src="content_left.php" name="content_left" frameborder="1" scrolling="NO" >
				<frame src="<?php echo $link_page; ?>" name="content_main" frameborder="1" scrolling="NO" >
		</frameset>
    <frame src="content_bottom.php" name="content_bottom" frameborder="1" scrolling="NO" noresize>

    <noframes>

        <body bgcolor="#FFFFFF">
        
        </body>
    </noframes>
</frameset>

</html>
<?php $db->db_close(); ?>
