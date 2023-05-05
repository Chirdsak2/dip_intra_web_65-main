<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$sql1 = $db->query("SELECT COUNT(filename) FROM check_link ");
$C = $db->db_fetch_row($sql1);

$allrow = $C[0];
?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
<script language="javascript">
var allq = 0;
function load_approve(){	
	if(allq <= <?php echo $allrow; ?>){
			url='dead_link2.php?start='+allq;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					document.all.load_data.innerHTML = req.responseText; 
			}
		}
	);
		allq++;
		setTimeout("load_approve()",1000);
	}
}
</script>
<link id="stext" href="css/size.css" rel="stylesheet" type="text/css">
</head>
<body onLoad="load_approve()"  leftmargin="0" topmargin="0">
<span id="load_data"></span>
</body>
</html>
<?php
 $db->db_close(); ?>
