<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

	?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<frameset name="content_frame1" rows="0,26,*,0"  frameborder="0" >
<frame src="module_obj.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>" name="module_obj" frameborder="0" scrolling="NO" noresize >
<frame src="article_bar.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>" name="website_bar" frameborder="0" scrolling="NO" noresize >
		<frameset name="content_frame" cols="0,*" rows="*" frameborder="0" >
				<frame src="" name="content_left" frameborder="1" scrolling="Yes" >
				<frame src="../ArticleMgt/article_use.php?cid=0" name="content_main" frameborder="1" scrolling="YES" >
		</frameset>
    <frame src="s" name="content_bottom" frameborder="1" scrolling="NO" noresize>

    <noframes>

        <body bgcolor="#FFFFFF">
        
        </body>
    </noframes>
</frameset>

</html>

<?php $db->db_close(); ?>
