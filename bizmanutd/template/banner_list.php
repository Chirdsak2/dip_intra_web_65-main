<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#FFFFFF">
  <tr> 
    <td bgcolor="#FFFFFF"  >
	<?php
		
		

    $query_set = $db->query("SELECT * FROM banner_setting ");
    $rs_set = $db->db_fetch_array($query_set);
    if($rs_set[banner_type]=='R'){
      $sql_banner = "SELECT * FROM banner  ORDER BY RAND() LIMIT ".$rs_set[banner_rand_row];
   }else{
     $sql_banner = "SELECT * FROM banner WHERE banner_show = 'yes' ORDER BY banner_position";
   }

		$query_banner = $db->query($sql_banner);
		$num_banner = $db->db_num_rows($query_banner);
		if($num_banner > 0){
			for($i=0;$i<$num_banner;$i++){
				$rs_banner = $db->db_fetch_array($query_banner);
				if(eregi("www", $rs_banner[banner_link]) AND !eregi("http://", $rs_banner[banner_link])){
					$link = "http://".$rs_banner[banner_link];
				}else{
					 $link = $rs_banner[banner_link];	
				}
	?>
	<table width="0" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><a href="<?php echo $link?>"  target="_blank" onClick="var url = 'banner_ajax_log.php?banner_id=<?php echo $rs_banner[banner_id]?>';load_divForm(url,'','');"><img src="<?php echo $rs_banner[banner_pic]?>" border="0"></a></td>
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
