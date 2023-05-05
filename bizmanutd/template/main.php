<?php
	session_start();
	$start_time_counter = date("YmdHis");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	
	//===========================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	//===========================================================
	
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	include("../../ewt_public_function.php");
	
	$_GET["filename"] = addslashes(htmlEntities(urldecode($_GET["filename"]), ENT_QUOTES));
	if($_SESSION["EWT_USE_W3C"] == "Y") { 
		$db->query("USE ".$EWT_DB_USER);
		$sql_site = $db->query("SELECT WebsiteName FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."' ");
		$S = $db->db_fetch_row($sql_site);
		$site_name = $S[0];
		$db->query("USE ".$EWT_DB_NAME);
?>
<html>
<head>
<title><?php echo $site_name; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
	<tr  valign="top" > 
		<td   colspan="3" >
			<strong><font size="7" face="Tahoma">Website W3C สำหรับผู้พิการทางสายตา</font><font size="6" face="Tahoma"><hr><?php echo $site_name; ?></font></strong>
			<p><strong><a href="w3c.php"><font color="#FF0000" size="5" face="Tahoma">"กลับสู่ mode ปกติ"</font></a></strong></p>
			<font size="4" face="Tahoma"> 
			<?php
				$sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
				while($B = $db->db_fetch_row($sql_top)){
			?>
			<?php echo show_block($B[0]); ?><br></font><?php } ?>
			<hr>
		</td>
	</tr>
	<tr valign="top" > 
		<td width="<?php echo $F["d_site_left"]; ?>"><font size="4" face="Tahoma">
		<?php 
			$sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
			while($B = $db->db_fetch_row($sql_left)){
		?>
		<?php echo show_block($B[0]);  ?><br></font><?php } ?>
		</td>
		<td width="<?php echo $F["d_site_content"]; ?>" ><font size="4" face="Tahoma">
		<?php 
			$sql_content = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
			while($B = $db->db_fetch_row($sql_content)){
		?>
		<?php echo show_block($B[0]); ?><br></font><?php } ?>
		</td>
		<td width="<?php echo $F["d_site_right"]; ?>"><font size="4" face="Tahoma">
		<?php
			$sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
			while($B = $db->db_fetch_row($sql_right)){
		?>
		<?php echo show_block($B[0]);  ?><br></font><?php } ?>
		</td>
	</tr>
	<tr valign="top" > 
		<td  colspan="3" ><font size="4" face="Tahoma">
		<?php
			$sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
			while($B = $db->db_fetch_row($sql_bottom)){
		?><?php echo show_block($B[0]);  ?><br></font><?php } ?>
		</td>
	</tr>
</table>
<!-- </body>
</html> -->
<?php
//end w3c
	} else {
		$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);

		$mainwidth = "0";
		$lang_sh = explode('___',$F[filename]);
		if($lang_sh[1] != ''){$lang_sh = '_'.$lang_sh[1];}else{$lang_sh ='';}
		$private_b = "";
		include("ewt_function.php");

	$ewt_mytitle = "";
	$ewt_mykeyword = "";
	$ewt_mydescription = "";
	$sql_website = $db->query("SELECT site_info_title,site_info_keyword,site_info_description FROM site_info  ");
	$SF = $db->db_fetch_array($sql_website);
	if($F["title"] != ""){
		$ewt_mytitle = addslashes($F["title"]);
	}else{
		$ewt_mytitle = addslashes($SF["site_info_title"]);
	}
	if($F["cms_keyword"] != ""){
		$ewt_mykeyword = addslashes($F["cms_keyword"]);
	}else{
		$ewt_mykeyword = addslashes($SF["site_info_keyword"]);
	}
	if($F["cms_description"] != ""){
		$ewt_mydescription = addslashes($F["cms_description"]);
	}else{
		$ewt_mydescription = addslashes($SF["site_info_description"]);
	}
	$ewt_mykeyword = eregi_replace(chr(13)," ",$ewt_mykeyword);
	$ewt_mykeyword = eregi_replace("  "," ",$ewt_mykeyword);
	$ewt_mydescription = eregi_replace(chr(13)," ",$ewt_mydescription);
	$ewt_mydescription = eregi_replace("  "," ",$ewt_mydescription);

			?>
<html>
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" />
<meta name="Description" content="<?php echo $ewt_mydescription; ?>"/>
<?php
	if($use_template != ""){
		$sql_index = $db->query("SELECT * FROM design_list WHERE d_id = '".$use_template."' ");
		$F = $db->db_fetch_array($sql_index);
	}
?>
<?php
include("ewt_script.php");	
?>
</head>
<body   leftmargin="0" topmargin="0" <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?> >

<table id="ewt_main_structure" width="<?php echo $F["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $F["d_site_align"]; ?>">
	<tr  valign="top" > 
		<td id="ewt_main_structure_top" height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3" >
		<?php
			$mainwidth = $F["d_site_width"];
			?><?php
			//echo "SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC";
			if($use_template != ""){
				$sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$use_template."' ORDER BY design_block.position ASC");
			}else{
				$sql_top = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
			}
			while($B = $db->db_fetch_row($sql_top)){
		?>
		<div>
		<?php 
			if($_SESSION["EWT_USE_W3C"] == "Y") { 
				echo show_block($B[0]); 
			} else {
				if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ 
					echo stripslashes($B[2]); 
				}else{ 
					echo show_block($B[0]); 
				}
			} 
		?>
		</div>
		<?php } ?>
</td>
</tr>
<tr valign="top" > 
<td id="ewt_main_structure_left" width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>" background="<?php echo $F["d_left_bg_p"]; ?>">
<?php
			$mainwidth = $F["d_site_left"];
			?><?php
if($private_b == "Y"){
$sql_left = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_member ON block_member.BID = block.BID WHERE block_member.side = '1' AND block_member.filename = '".$_GET["filename"]."' AND block_member.mid = '".$_SESSION["EWT_MID"]."' ORDER BY block_member.position ASC");
}else{
$sql_left = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}
while($B = $db->db_fetch_row($sql_left)){
?>
<div><?php
if($_SESSION["EWT_USE_W3C"] == "Y"){ echo show_block($B[0]); }else{
if($B[1] == "text" OR $B[1] == "code" OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); }} ?></div>
<?php } ?>
</td>

<td id="ewt_main_structure_body" width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" height="160" background="<?php echo $F["d_body_bg_p"]; ?>"><?php
			$mainwidth = $F["d_site_content"];
			?><?php
if($private_b == "Y"){
$sql_content = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_member ON block_member.BID = block.BID WHERE block_member.side = '5' AND block_member.filename = '".$_GET["filename"]."' AND block_member.mid = '".$_SESSION["EWT_MID"]."' ORDER BY block_member.position ASC");
}else{
$sql_content = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}
while($B = $db->db_fetch_row($sql_content)){
?>
<div><?php
if($_SESSION["EWT_USE_W3C"] == "Y"){ echo show_block($B[0]); }else{
if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); }} ?></div>
<?php } ?></td>
<td id="ewt_main_structure_right" width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>">
<?php
			$mainwidth =  $F["d_site_right"];
			?><?php
if($private_b == "Y"){
$sql_right = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_member ON block_member.BID = block.BID WHERE block_member.side = '2' AND block_member.filename = '".$_GET["filename"]."' AND block_member.mid = '".$_SESSION["EWT_MID"]."' ORDER BY block_member.position ASC");
}else{
$sql_right = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}
while($B = $db->db_fetch_row($sql_right)){
?>
<div><?php
if($_SESSION["EWT_USE_W3C"] == "Y"){ echo show_block($B[0]); }else{
if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); }} ?></div>
<?php } ?>
</td>
</tr>
<tr valign="top" > 
<td id="ewt_main_structure_bottom" height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3" >
<?php
			$mainwidth = $F["d_site_width"];
			?><?php
if($use_template != ""){
$sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$use_template."' ORDER BY design_block.position ASC");
}else{
$sql_bottom = $db->query("SELECT block.BID,block.block_type,block.block_html FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
}
while($B = $db->db_fetch_row($sql_bottom)){
?>
<div><?php
if($_SESSION["EWT_USE_W3C"] == "Y"){ echo show_block($B[0]); }else{
if($B[1] == "text" OR $B[1] == "code"  OR $B[1] == "images" OR $B[1] == "flash" OR $B[1] == "media" OR $B[1] == "menu" ){ echo stripslashes($B[2]); }else{ echo show_block($B[0]); }} ?></div>
<?php } ?>
</td>
</tr>
</table>
</body>
</html>
<?php
	if(!session_is_registered("EWT_VISITOR_STAT")){
	session_register("EWT_REFERER");
	$_SESSION["EWT_REFERER"] = $HTTP_REFERER;
	}
	$end_time_counter = date("YmdHis");
	$gap = $end_time_counter - $start_time_counter;
?>
<script language="javascript">
document.write("<img src=\"ewt_stat.php?t=page&filename=<?php echo $_GET["filename"]; ?>&load=<?php echo $gap; ?>&res="+screen.width+"x"+screen.height+"\" width=\"1\" height=\"1\" style=\"display:none\">");	
</script>
<?php
}
	#set approve of time
	$sql_approve = "select * from setting_approve where filename = '".$_GET["filename"]."'  
									and ((set_approve_date = '".date('Y-m-d')."' and set_approve_time <= '".date('H:i:s')."') or (set_approve_date < '".date('Y-m-d')."')) and active = 'Y'";
	$query_approve = $db->query($sql_approve);
	if($db->db_num_rows($query_approve)>0){
		genpublic($_GET["filename"],"../../",$EWT_FOLDER_USER);
		$sql_update = "update setting_approve set active = 'N' where filename = '".$_GET["filename"]."'";
		$db->query($sql_update);
	} 
$db->db_close(); ?>
