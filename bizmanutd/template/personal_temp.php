<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title>Add To Favorite</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet"  href="css/style.css" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<form name="form1" enctype="multipart/form-data" method="post" action="personal_function_temp.php">
	<input name="code" type="hidden" id="code" value="<?php echo $code; ?>"> 
	<input name="Flag" type="hidden" id="Flag" value="add">
	<table width="100%" border="0" cellspacing="1" cellpadding="1">
	  <tr>
		<td>
			
		</td>
	  </tr>
	</table>
</form>
</body>
</html>
<?php  $db->db_close(); ?>
