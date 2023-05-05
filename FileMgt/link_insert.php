<?php
include("../lib/permission1.php");
include("../lib/include.php");
	?>
<head>
<title>My Gallery</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<frameset name="mcontent_frame" rows="0,*"  frameborder="0" >
<frame src="module_obj.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>" name="module_obj" frameborder="0" scrolling="NO" noresize >
		<frameset name="gallery_frame" cols="250,*" rows="*" frameborder="0" >
				<frame src="gallery_left.php" name="gallery_left" frameborder="1" scrolling="No" >
				<frame src="gallery_index.php?skip=Y" name="gallery_main" frameborder="1" scrolling="NO" >
		</frameset>
    

    <noframes>

        <body bgcolor="#FFFFFF">

        </body>
    </noframes>
</frameset>

</html>
