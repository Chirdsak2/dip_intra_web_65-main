<?php
include("../lib/permission1.php");
include("../lib/include.php");
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0"  bgcolor="#F7F7F7">
        	<form name="formTodo" method="post" action = "">
		<input name="stype" type="hidden" id="stype" value="<?php echo $_REQUEST["stype"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="<?php echo $_REQUEST["Flag"]; ?>">
        <input name="filename" type="hidden" id="filename" value="<?php echo $_REQUEST["filename"]; ?>">
		<input name="o_value" type="hidden" id="o_value" value="<?php echo $_REQUEST["o_value"]; ?>">
		<input name="o_preview" type="hidden" id="o_preview" value="<?php echo $_REQUEST["o_preview"]; ?>">
  <input type="hidden" name="objfile" value="">
</form>
</body>
</html>
