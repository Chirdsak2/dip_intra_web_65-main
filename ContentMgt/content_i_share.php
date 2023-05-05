<?php
include("../lib/permission1.php");
?>
<html>
<head>
<title>Share &amp; Public Content</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>

<frameset rows="*,150" cols="*" framespacing="1" frameborder="yes" border="1" bordercolor="#999999">
  <frameset cols="250,*"  framespacing="1" frameborder="yes" border="1" bordercolor="#999999">
    <frame src="share_left.php?filename=<?php echo $_GET["filename"]; ?>" name="SleftFrame" scrolling="YES"  >
    <frame  name="SmainFrame" scrolling="YES">
  </frameset>
  <frame  name="SbottomFrame" scrolling="Yes" >
</frameset>
<noframes><body>

</body></noframes>
</html>
