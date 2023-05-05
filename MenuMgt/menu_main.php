<?php
include("../lib/permission1.php");
include("../lib/include.php");
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<frameset name="mmenu_frame" rows="*,340"  frameborder="0">
		<frameset name="menu_frame" cols="300,*" rows="*" frameborder="0" >
				<frame src="menu_structure.php?m_id=<?php echo $_GET["m_id"]; ?>" name="menu_left" frameborder="1" scrolling="Yes" >
				<frame src="menu_preview.php?m_id=<?php echo $_GET["m_id"]; ?>" name="menu_main" frameborder="1" scrolling="Yes" >
		</frameset>
    <frame src="menu_properties.php?m_id=<?php echo $_GET["m_id"]; ?>" name="menu_bottom" frameborder="1" scrolling="Yes">

    <noframes>

        <body bgcolor="#FFFFFF">
        
        </body>
    </noframes>
</frameset>

</html>
