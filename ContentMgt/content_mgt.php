<?php
include("../lib/permission1.php");
include("../lib/include.php");
$file_name = $_GET["filename"]; 
	?>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>

<frameset name="content_frame" cols="*" rows="*,0" framespacing="0" frameborder="0">
    <frame src="content_head.php?filename=<?php echo $file_name; ?>" name="content_top" frameborder="0" scrolling="no" noresize>
	<!--<frame src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_preview.php?filename=<?php echo $file_name; ?>" name="content_body" frameborder="0" scrolling="YES" noresize>-->
    <frame src="content_design.php?filename=<?php echo $file_name; ?>" name="content_properties" frameborder="0" scrolling="NO" noresize>
    <noframes>
        <body bgcolor="#FFFFFF">
        
        </body>
    </noframes>
</frameset>

</html>
