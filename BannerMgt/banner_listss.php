<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<?php
	//$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
?>
<table width="350" border="0" cellpadding="8" cellspacing="1" bgcolor="#FF9900">
  <tr> 
    <td width="350" bgcolor="#FFFFFF"  >
	<?php
		
		$sql_banner = "SELECT * FROM banner WHERE banner_show = 'yes' ORDER BY RAND() LIMIT 5";
		$query_banner = $db->query($sql_banner);
		$num_banner = $db->db_num_rows($query_banner);
		if($num_banner > 0){
			for($i=0;$i<$num_banner;$i++){
				$rs_banner = $db->db_fetch_array($query_banner);
				if(eregi("www", $rs_banner[banner_link]) || eregi("http", $rs_banner[banner_link])){
					$link = "http://".$rs_banner[banner_link];
				}else{
					 $link = $Globals_Dir.$rs_banner[banner_link];	
				}
	?>
	<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td bgcolor="#FFFFFF"><a href="<?php echo $link?>"  target="_blank" onClick="var url = 'banner_ajax_log.php?banner_id=<?php echo $rs_banner[banner_id]?>';load_divForm(url,'','');"><img src="<?php echo $Globals_Dir.$rs_banner[banner_pic]?>" border="0"></a></td>
      </tr>
    </table><br>
	<?php
		}//end for	
	}//end if
	?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close();
?>
