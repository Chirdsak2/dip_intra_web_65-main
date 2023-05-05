<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	$temp = "SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."'";
	$sql_temp= $db->query($temp);
	$R = $db->db_fetch_array($sql_temp);
	//setting hide/show
	if($_GET["tb_show"] == "") { $tbshow = "01"; } else { $tbshow = $_GET["tb_show"]; }
	if($R[set_intro] == "Y") { $checked = "checked"; } else { $checked = ''; }
?>
<html>
	<head>
	<title><?php echo $EWT_title ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
	<script language="JavaScript">
		function change(c) {
			if(document.form1.flag.value == "0") {
				c.src = "../images/c_on.gif";
				document.form1.flag.value ="1";
				self.parent.content_frame.rows = "*,9";
			} else {
				c.src = "../images/c_off.gif";
				document.form1.flag.value ="0";
				self.parent.content_frame.rows = "*,180";
			}
		}
		
		function showtable(c) {
			for(i=1; i<7; i++) {
				if(i != c) { document.getElementById("tr0" +i).style.display = 'none'; } else { document.getElementById("tr0" +i).style.display = ''; }
			}
			document.form2.tbshow.value = '0'+c;
		}
	</script>
	<script language="JavaScript">
		function selColor(c,d,e) {
			Win2 = window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '&c_preview=' + e + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
		}
		
		function changeAlign(c) {
			self.parent.content_top.iframe_data.document.all.Demo4.style.textAlign = c;
		}
		
		function changeWidth(c,d) {
			d.style.width = c;
		}
		
		function changeHeight(c,d) {
			d.style.height = c;
		}
		
		function choose_bg(c,d) {
			formPopUpBg.action = "../FileMgt/gallery_insert.php";
			window.open('','bg_popup','top=60,left=80,width=640,height=480,resizable=1,status=0');
			document.formPopUpBg.o_value.value = c;
			document.formPopUpBg.o_preview.value = d;
			formPopUpBg.submit();
		}
	</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="1200%" border="0" cellpadding="0" cellspacing="0">
	<form name="form1" method="post" action="">
		<tr height="9">
			<td align="center" height="10" background="../images/c_bg.gif" bgcolor="#FFFFFF"><a href="#"><img src="../images/c_off.gif" width="50" height="9" border="0" onClick="change(this)"></a></td>
		</tr>
		<input type="hidden" name="flag" value="0">
	</form>
	<form name="formPopUpBg" method="post" action="" target="bg_popup">
		<input name="o_value" type="hidden" id="o_value" value="">
		<input name="o_preview" type="hidden" id="o_preview" value="">
		<input name="stype" type="hidden" id="stype" value="images">
		<input name="Flag" type="hidden" id="Flag" value="SetBg">
	</form>
	<form action="content_function.php" method="post" name="form2"  target="save_design_function">
		<tr height="25"> 
			<td height="26" bgcolor="#F7F7F7">
				<img src="../images/palette_text.gif" width="24" height="24" align="absmiddle"> 
				<strong>Design Properties : [<?php echo $R["filename"]; ?>] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Change Template : 
				<select name="select_template"  >
				<?php //save_design_function
					$sql_design = "SELECT * FROM design_list ORDER BY d_name ASC";
					$query = $db->query($sql_design);
					while($rec_design = $db->db_fetch_array($query)) {
						$select = '';
						if($R[template_id] == $rec_design[d_id]) {
							$select = 'selected';
							$themes_show = $rec_design[d_bottom_content];
						}
						echo " <option value=\"".$rec_design[d_id]."\"".$select.">".$rec_design[d_name]."</option>";
					}
				?>
				</select>
				<input type="button" name="Submit2" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id='+ document.form2.select_template.value +'','','height=600,width=780.scrollbars=1,resizable=1');">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Change Block Design :&nbsp;
				<select name="select_block_desing">
					<option value=""></option>
					<?php //save_design_function
						$sql_themes = "SELECT * FROM themes ORDER BY themes_name ASC";
						$query = $db->query($sql_themes);
						while($rec_themes = $db->db_fetch_array($query)) {
							$select = '';
							if($themes_show == $rec_themes[themes_id]) {
								//$select = 'selected';
							}
							echo " <option value=\"".$rec_themes[themes_id]."\"".$select.">".$rec_themes[themes_name]."</option>";
						}
					?>
				</select>&nbsp;&nbsp;
				<input type="button" name="Submit_block_desing" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/theme_view.php?themes_id='+ document.form2.select_block_desing.value +'','','height=300,width=480.scrollbars=1,resizable=1');">
				</strong>
			</td>
		</tr>
		<input name="templade_old" type="hidden" value="<?php echo $R[template_id];?>">
		<input name="themes_show_old" type="hidden" value="<?php echo $themes_show;?>">
		<input type="hidden" name="tbshow" value="<?php echo $tbshow; ?>">
		<input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
		<input name="Flag" type="hidden" id="Flag" value="SaveDataConfig">
		<tr>
			<td   valign="top" bgcolor="#F7F7F7">
				<table    id="tr01" style="display:<?php if($tbshow == "01"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
					<tr> 
						<td colspan="4">
							<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="90" align="center" background="../images/bg1_on90.gif">Site Structure </td>
									<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#design" onClick="showtable('2')">Top Design</a></td>
									<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('3')">Left Design </a></td>
									<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">Content Design</a></td>
									<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right Design </a></td>
									<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom Design </a></td>
									<td background="../images/bg2_off.gif">&nbsp;</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr> 
						<td colspan="2">Total web page width : <input name="d_site_width" type="text" id="d_site_width" onBlur="changeWidth(this.value,self.parent.content_top.iframe_data.document.all.tbbody);" value="<?php echo $R["d_site_width"]; ?>" size="4" maxlength="5"></td>
						<td>Web page alignment 
							<select name="d_site_align" id="d_site_align" onChange="changeAlign(this.value)">
								<option value="center" <?php if($R["d_site_align"] == "center"){ echo "selected"; } ?>>center</option>
								<option value="left" <?php if($R["d_site_align"] == "left"){ echo "selected"; } ?>>left</option>
								<option value="right" <?php if($R["d_site_align"] == "right"){ echo "selected"; } ?>>right</option>
							</select>
						</td>
						<td><input name="chk_for_intro" type="checkbox" id="chk_for_intro" value="Y" <?php echo $checked;?>>Setting page for intro </td>
					</tr>
					<tr> 
						<td colspan="4">
							<table width="100%" border="0" cellspacing="1" cellpadding="1">
								<tr> 
									<td width="33%">Left Section's width : <input name="d_site_left" type="text" id="d_site_left" onBlur="changeWidth(this.value,self.parent.content_top.iframe_data.document.all.tbleft);" value="<?php echo $R["d_site_left"]; ?>" size="4"></td>
									<td width="33%">Content Section's width : <input name="d_site_content" type="text" id="d_site_content" onBlur="changeWidth(this.value,self.parent.content_top.iframe_data.document.all.tbcontent);" value="<?php echo $R["d_site_content"]; ?>" size="4"></td>
									<td width="33%">Right Section's width : <input name="d_site_right" type="text" id="d_site_right" onBlur="changeWidth(this.value,self.parent.content_top.iframe_data.document.all.tbright);" value="<?php echo $R["d_site_right"]; ?>" size="4"></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr> 
							<td width="15%">Background color : </td>
							<td width="35%">
								<table width="100%" border="0" cellspacing="0" cellpadding="1">
									<tr> 
										<td width="21" height="21"><a id="CPreview1" style="background-color: <?php echo $R["d_site_bg_c"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.form2.d_site_bg_c.value','window.opener.document.all.CPreview1.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.Demo4.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a></td>
										<td><input name="d_site_bg_c" type="text" value="<?php echo $R["d_site_bg_c"]; ?>" size="7"></td>
									</tr>
								</table>
							</td>
							<td width="50%" colspan="2">
								Background Picture : <input name="d_site_bg_p" type="text" id="d_site_bg_p" value="<?php echo $R["d_site_bg_p"]; ?>" style="border:buttonhighlight solid 0px" readonly="true">
								...<a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_site_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.Demo4')"> <img src="../images/look_view.gif" width="16" height="16" border="0" align="absmiddle"></a> 
								<br>
								<input name="no_bgsite" type="checkbox" id="no_bgsite" value="Y">Remove Background Picture
							</td>
					</tr>
				</table>
					<table id="tr02" style="display:<?php if($tbshow == "02"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr> 
							<td colspan="3">
								<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
									<tr> 
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site Structure</a> </td>
										<td width="90" align="center" background="../images/bg1_on90.gif">Top Design</td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('3')">Left Design </a> </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">Content Design </a> </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right Design </a> </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom Design </a> </td>
										<td background="../images/bg2_off.gif">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan="2">Top design height : <input name="d_top_height" type="text" id="d_top_height" onBlur="changeHeight(this.value,self.parent.content_top.iframe_data.document.all.tbtop);" value="<?php echo $R["d_top_height"]; ?>" size="4" maxlength="5"></td>
							<td>Background Picture : <input name="d_top_bg_p" type="text" id="d_top_bg_p" value="<?php echo $R["d_top_bg_p"]; ?>" style="border:buttonhighlight solid 0px" readonly="true">...<a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_top_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbtop')">  <img src="../images/look_view.gif" width="16" height="16" border="0" align="absmiddle"></a></td>
						</tr>
						<tr> 
							<td width="15%">Background color : </td>
							<td width="35%">
								<table width="100%" border="0" cellspacing="0" cellpadding="1">
									<tr> 
										<td width="21" height="21"><a id="CPreview2" style="background-color: <?php echo $R["d_top_bg_c"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.form2.d_top_bg_c.value','window.opener.document.all.CPreview2.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbtop.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a></td>
										<td><input name="d_top_bg_c" type="text" value="<?php echo $R["d_top_bg_c"]; ?>" size="7"></td>
									</tr>
								</table>
							</td>
							<td width="50%"><input name="no_bgtop" type="checkbox" id="no_bgtop" value="Y">Remove Background Picture</td>
						</tr>
					</table>
					<table id="tr03" style="display:<?php if($tbshow == "03"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr> 
							<td colspan="3">
								<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
									<tr> 
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site Structure</a> </td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">Top Design</a></td>
										<td width="90" align="center" background="../images/bg1_on90.gif">Left Design </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">Content Design </a> </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right Design </a> </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom Design </a> </td>
										<td background="../images/bg2_off.gif">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr> 
							<td width="15%">Background color : </td>
							<td width="35%">
								<table width="100%" border="0" cellspacing="0" cellpadding="1">
									<tr> 
										<td width="21" height="21"><a id="CPreview3" style="background-color: <?php echo $R["d_left_bg_c"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.form2.d_left_bg_c.value','window.opener.document.all.CPreview3.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbleft.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a></td>
										<td><input name="d_left_bg_c" type="text" value="<?php echo $R["d_left_bg_c"]; ?>" size="7"></td>
									</tr>
								</table>
							</td>
							<td width="50%">Background Picture : <input name="d_left_bg_p" type="text" id="d_left_bg_p" value="<?php echo $R["d_left_bg_p"]; ?>" style="border:buttonhighlight solid 0px" readonly="true">...<a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_left_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbleft')">  <img src="../images/look_view.gif" width="16" height="16" border="0" align="absmiddle"></a><br><input name="no_bgleft" type="checkbox" id="no_bgleft" value="Y">Remove Background Picture</td>
						</tr>
					</table>
					<table id="tr04" style="display:<?php if($tbshow == "04"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr> 
							<td colspan="3">
								<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
									<tr> 
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site Structure</a> </td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">Top Design</a></td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('3')">Left Design</a> </td>
										<td width="90" align="center" background="../images/bg1_on90.gif">Content Design </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right Design </a> </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom Design </a> </td>
										<td background="../images/bg2_off.gif">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr> 
							<td width="15%">Background color : </td>
							<td width="35%">
								<table width="100%" border="0" cellspacing="0" cellpadding="1">
									<tr> 
										<td width="21" height="21"><a id="CPreview4" style="background-color: <?php echo $R["d_body_bg_c"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.form2.d_body_bg_c.value','window.opener.document.all.CPreview4.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbcontent.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a></td>
										<td><input name="d_body_bg_c" type="text" value="<?php echo $R["d_body_bg_c"]; ?>" size="7"></td>
									</tr>
								</table>
							</td>
							<td width="50%">Background Picture : <input name="d_body_bg_p" type="text" id="d_body_bg_p" value="<?php echo $R["d_body_bg_p"]; ?>" style="border:buttonhighlight solid 0px" readonly="true">...<a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_body_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbcontent')">  <img src="../images/look_view.gif" width="16" height="16" border="0" align="absmiddle"></a><br><input name="no_bgcontent" type="checkbox" id="no_bgcontent" value="Y">Remove Background Picture</td>
						</tr>
					</table>
					<table id="tr05" style="display:<?php if($tbshow == "05"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr> 
							<td colspan="3">
								<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
									<tr> 
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site Structure</a> </td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">Top Design</a></td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('3')">Left Design</a> </td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('4')">Content Design</a> </td>
										<td width="90" align="center" background="../images/bg1_on90.gif">Right Design </td>
										<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom Design </a> </td>
										<td background="../images/bg2_off.gif">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr> 
							<td width="15%">Background color : </td>
							<td width="35%">
								<table width="100%" border="0" cellspacing="0" cellpadding="1">
									<tr> 
										<td width="21" height="21"><a id="CPreview5" style="background-color: <?php echo $R["d_right_bg_c"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.form2.d_right_bg_c.value','window.opener.document.all.CPreview5.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbright.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a></td>
										<td><input name="d_right_bg_c" type="text" value="<?php echo $R["d_right_bg_c"]; ?>" size="7"></td>
									</tr>
								</table>
							</td>
							<td width="50%">Background Picture : <input name="d_right_bg_p" type="text" id="d_right_bg_p" value="<?php echo $R["d_right_bg_p"]; ?>" style="border:buttonhighlight solid 0px" readonly="true">...<a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_right_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbright')"> <img src="../images/look_view.gif" width="16" height="16" border="0" align="absmiddle"></a><br><input name="no_bgright" type="checkbox" id="no_bgright" value="Y">Remove Background Picture</td>
						</tr>
					</table>
					<table id="tr06" style="display:<?php if($tbshow == "06"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr> 
							<td colspan="3">
								<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site Structure</a> </td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">Top Design</a></td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('3')">Left Design</a>  </td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('4')">Content Design</a></td>
										<td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('5')">Right Design</a>  </td>
										<td width="90" align="center" background="../images/bg1_on90.gif">Bottom Design  </td>
										<td background="../images/bg2_off.gif">&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan="2">Bottom design height : <input name="d_bottom_height" type="text" id="d_bottom_height" onBlur="changeHeight(this.value,self.parent.content_top.iframe_data.document.all.tbbottom);" value="<?php echo $R["d_bottom_height"]; ?>" size="4" maxlength="5"></td>
							<td>Background Picture : <input name="d_bottom_bg_p" type="text" id="d_bottom_bg_p" value="<?php echo $R["d_bottom_bg_p"]; ?>" style="border:buttonhighlight solid 0px" readonly="true">...<a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_bottom_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbbottom')"> <img src="../images/look_view.gif" width="16" height="16" border="0" align="absmiddle"></a><br><input name="no_bgbottom" type="checkbox" id="no_bgbottom" value="Y">Remove Background Picture</td>
						</tr>
						<tr> 
							<td width="15%">Background color : </td>
							<td width="35%">
								<table width="100%" border="0" cellspacing="0" cellpadding="1">
									<tr> 
										<td width="21" height="21"><a id="CPreview6" style="background-color: <?php echo $R["d_bottom_bg_c"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.form2.d_bottom_bg_c.value','window.opener.document.all.CPreview6.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbbottom.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a></td>
										<td><input name="d_bottom_bg_c" type="text" value="<?php echo $R["d_bottom_bg_c"]; ?>" size="7"></td>
									</tr>
								</table>
							</td>
							<td width="50%">&nbsp;</td>
						</tr>
					</table>
					<table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td align="right"> <input type="submit" name="Submit" value="  Save  "></td>
						</tr>
					</table>
			</td>
		</tr>
	</form>
		<iframe name="save_design_function" src=""  frameborder="0"  width="0" height="0" scrolling="no" ></iframe>
</table>
</body>
</html>
<?php $db->db_close(); ?>
