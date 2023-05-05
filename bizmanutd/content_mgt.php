<?php
session_start();
include("../lib/include_bizadmin.php");

$d_id = $_GET["d_id"]; 
	?>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

</head>

<frameset name="content_frame" cols="*" rows="*,180" framespacing="0" frameborder="0">
    <frame src="content_head.php?d_id=<?php echo $d_id; ?>" name="content_top" frameborder="0" scrolling="no" noresize>
    <frame src="content_design.php?d_id=<?php echo $d_id; ?>" name="content_properties" frameborder="0" scrolling="NO" noresize>
    <noframes>
        <body bgcolor="#FFFFFF">
        
        </body>
    </noframes>
</frameset>

</html>
