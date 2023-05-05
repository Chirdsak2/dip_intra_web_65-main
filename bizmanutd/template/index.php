<?php 
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	
	$cur_date = date('Y-m-d');
	$sql_splash = "SELECT * FROM splash_img, gallery_image WHERE splash_img_id = img_id AND splash_status  = 'Y' AND ('".$cur_date."' BETWEEN splash_start_date AND splash_end_date)";
	if($db->db_num_rows($db->query($sql_splash))>0 && ($_SESSION["EWT_MID"] == '' OR $_SESSION["EWT_MID"] =='0')) {
		$row_splash = $db->db_fetch_array($db->query($sql_splash));
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style>
body {margin: 0px 0px 0px 0px; }
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="<?php echo $row_splash['splash_bgcolor']; ?>"  background="<?php echo $row_splash['splash_bg_img'];?>">
	<tr>
		<td align="center" valign="middle">
			<table width="100%" border="0" cellspacing="0" cellpadding="0"  background="<?php echo $row_splash[''];?>">
				<tr>
					<td align="center" valign="middle"><img src="<?php echo $row_splash['img_path_b']; ?>" align="absmiddle" border="0"></td>
				</tr>
				<tr>
					<td align="center" valign="middle" style="padding-top:10px; padding-bottom:10px;"><span><?php echo stripslashes($row_splash['splash_text']); ?></span></td>
				</tr>
				<tr>
					<td align="center" valign="middle"><strong><a href="main.php?filename=index"><font color="<?php echo $row_splash['splash_text_color']; ?>"><?php echo $row_splash['splash_text_link']; ?></font></a></strong></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
<?php
	} else {
		$sql_index = $db->query("SELECT filename,template_id FROM temp_index WHERE set_intro  = 'Y' ");
		if($db->db_num_rows($sql_index)>0){
			$rec = $db->db_fetch_array($sql_index);
			$tid = $rec["template_id"];
			if($_SESSION["EWT_TYPE_ID"] != ""){
				$sql_person = $db->query("SELECT * FROM personal_map WHERE p_group = '".$_SESSION["EWT_TYPE_ID"]."' ");
				if($db->db_num_rows($sql_person) > 0){
					$PW = $db->db_fetch_array($sql_person);
					if($PW["p_template"] != "" AND $PW["p_template"] != "0" ){
						$tid = $PW["p_template"];
					}
				}
			}
			$sql_template = $db->query("SELECT d_intro FROM design_list WHERE d_id = '".$tid."' ");
			$D = $db->db_fetch_array($sql_template);
			if(($D["d_intro"] == "Y") AND (file_exists("intro/intro_".$tid.".html"))){
				$buffer = "";
				$fd = @fopen ("intro/intro_".$tid.".html", "r");
				while (!@feof ($fd)) { $buffer .= @fgets($fd, 4096); }
				@fclose ($fd);
				echo $buffer;
			}else{
				?>
			<script language="JavaScript">
			window.location.href = "main.php?filename=<?php echo $rec[filename];?>";
			</script>
			<?php
			exit; 
				//Header("location:main.php?filename=".$rec[filename].""); exit; 
			}
		}else{
			$sql_index = $db->query("SELECT filename,template_id FROM temp_index WHERE filename = 'index' ");
			$rec = $db->db_fetch_array($sql_index);
			$tid = $rec["template_id"];
			if($_SESSION["EWT_TYPE_ID"] != ""){
				$sql_person = $db->query("SELECT * FROM personal_map WHERE p_group = '".$_SESSION["EWT_TYPE_ID"]."' ");
					if($db->db_num_rows($sql_person) > 0){
						$PW = $db->db_fetch_array($sql_person);
						if($PW["p_template"] != "" AND $PW["p_template"] != "0" ){
							$tid = $PW["p_template"];
						}
				}
			}
			$sql_template = $db->query("SELECT d_intro FROM design_list WHERE d_id = '".$tid."' ");
			$D = $db->db_fetch_array($sql_template);
			if(($D["d_intro"] == "Y") AND (file_exists("intro/intro_".$tid.".html"))){
				$buffer = "";
				$fd = @fopen ("intro/intro_".$tid.".html", "r");
				while (!@feof ($fd)) { $buffer .= @fgets($fd, 4096); }
				@fclose ($fd);
				echo $buffer;
			}else{
			?>
			<script language="JavaScript">
			window.location.href = "main.php?filename=<?php echo $rec[filename];?>";
			</script>
			<?php
			exit; 
				//Header("location:main.php?filename=".$rec[filename].""); exit; 
			}
		}
	}
	$db->db_close();
?>
