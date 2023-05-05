<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
include("../../ewt_public_function.php");
if($_SESSION["EWT_EMP"] == "5"){
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = 'index_gov' ");
}elseif($_SESSION["EWT_EMP"] == "6"){
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = 'index_edu' ");
}else{
$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
}

if($_SESSION["EWT_EMP"] == "5"){
//index_gov
}elseif($_SESSION["EWT_EMP"] == "6"){
//index_edu
}else{

}

$F = $db->db_fetch_array($sql_index);
	?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
<script language="javascript">
function news_data(bid) {	
	var objDiv = document.getElementById("show_comment"+bid);
	url='news_ajax.php?bid='+bid;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
			}
		}
	);
	setTimeout("news_data("+bid+")",2000);
}
</script>
<link id="stext" href="css/size.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >
<table width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
		  //echo "SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC";
if($_SESSION["EWT_EMP"] == "5"){

			  $sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = 'index_gov' ORDER BY block_function.position ASC");
}elseif($_SESSION["EWT_EMP"] == "6"){

			  $sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = 'index_edu' ORDER BY block_function.position ASC");
}else{
		  $sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}

		  while($B = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
<?php	if($B[1] == "article"){	echo "<script language=javascript>news_data(\"".$B[0]."\",\"show_comment".$B[0]."\");</script>"; }	?>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
		  <?php

		  if($_SESSION["EWT_EMP"] == "5"){
  $sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = 'index_gov' ORDER BY block_function.position ASC");
}elseif($_SESSION["EWT_EMP"] == "6"){
 $sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = 'index_edu' ORDER BY block_function.position ASC");
}else{
		  $sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}
		  while($B = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
<?php	if($B[1] == "article"){	echo "<script language=javascript>news_data(\"".$B[0]."\",\"show_comment".$B[0]."\");</script>"; }	?>
		<?php } ?>
		  </td>
          
    <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"><?php
		  $sql_content = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
		  while($B = $db->db_fetch_row($sql_content)){
		  ?>
<DIV><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
<?php	if($B[1] == "article"){	echo "<script language=javascript>news_data(\"".$B[0]."\",\"show_comment".$B[0]."\");</script>"; }	?>
		<?php } ?></td>
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
		  <?php

			  if($_SESSION["EWT_EMP"] == "5"){
//index_gov
		  $sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = 'index_gov' ORDER BY block_function.position ASC");
}elseif($_SESSION["EWT_EMP"] == "6"){
//index_edu
		  $sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = 'index_edu' ORDER BY block_function.position ASC");
}else{
		  $sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}

		  while($B = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
<?php	if($B[1] == "article"){	echo "<script language=javascript>news_data(\"".$B[0]."\",\"show_comment".$B[0]."\");</script>"; }	?>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
		  <?php
	if($_SESSION["EWT_EMP"] == "5"){
//index_gov
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = 'index_gov' ORDER BY block_function.position ASC");
}elseif($_SESSION["EWT_EMP"] == "6"){
//index_edu
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = 'index_edu' ORDER BY block_function.position ASC");
}else{
		  $sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}

		  while($B = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "graph" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); } ?></DIV>
<?php	if($B[1] == "article"){	echo "<script language=javascript>news_data(\"".$B[0]."\",\"show_comment".$B[0]."\");</script>"; }	?>
		<?php } ?>
</td>
        </tr>
      </table>
</body>
</html>
<?php 

	$pname = "SP_".$_GET["filename"]."_PC";

	if(!session_is_registered($pname)){
		session_register($pname);

		$today = date("Y-m-d"); 
		$now = date("H:i:s"); 

			function Dot2LongIP ($IPaddr){
				if ($IPaddr == "") {
					return 0;
				} else {
					$ips = split ("\.", "$IPaddr");
					return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
				}
			}
// get_ip
				if(getenv(HTTP_X_FORWARDED_FOR)){
						$IPn = getenv(HTTP_X_FORWARDED_FOR);
				}else{
						$IPn = getenv("REMOTE_ADDR");
				}	

		$ipno = Dot2LongIP($IPn);

		$db->query("USE ".$EWT_DB_USER);

		$sql = $db->query("SELECT ip_country_short FROM ip_country WHERE " . $ipno . " BETWEEN ip_start_number AND ip_end_number");
		$R = $db->db_fetch_row($sql);



		$domain_temp = strtolower($R[0]);
			if($domain_temp == ""){
					$domain_temp = "th";
			}

		$db->query("USE ".$EWT_DB_NAME);
		$db->query("INSERT INTO stat_visitor ( sv_id  , sv_url , sv_menu , sv_ip , sv_date , sv_time , sv_country  ) VALUES ('' , 'page', '".$_GET["filename"]."', '".$IPn."', '".$today."', '".$now."', '".$domain_temp."')");
	
	}	 
	
	#set approve of time
/*	$sql_approve = "select * from setting_approve where filename = '".$_GET["filename"]."'  
									and ((set_approve_date = '".date('Y-m-d')."' and set_approve_time <= '".date('H:i:s')."') or (set_approve_date < '".date('Y-m-d')."')) and active = 'Y'";
	$query_approve = $db->query($sql_approve);
	if($db->db_num_rows($query_approve)>0){
		genpublic($_GET["filename"],"../",$_SESSION["EWT_SUSER"]);
		$sql_update = "update setting_approve set active = 'N' where filename = '".$_GET["filename"]."'";
		$db->query($sql_update);
	} */
	
	
?>
<?php $db->db_close(); ?>
