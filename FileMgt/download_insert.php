<?php
include("../lib/permission1.php");
include("../lib/include.php");
	?>
<head>
<title>My download</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<frameset name="mcontent_frame" rows="0,*"  frameborder="0" >
<frame src="module_obj.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>" name="module_obj" frameborder="0" scrolling="NO" noresize >
		<frameset name="download_frame" cols="*" rows="*" frameborder="0" >
				<!--<frame src="download_left.php" name="download_left" frameborder="1" scrolling="No" >-->
				<frame src="download_index.php?skip=Y" name="download_main" frameborder="1" scrolling="NO" >
		</frameset>
    

    <noframes>

        <body bgcolor="#FFFFFF">

        </body>
    </noframes>
</frameset>

</html>
