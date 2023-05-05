<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("cms","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.close();
				</script>
				<?php
}
if($_GET["tb_show"] == "") { $tbshow = "00"; } else { $tbshow = $_GET["tb_show"]; }


$sql_temp = "SELECT temp_index.*,design_list.d_id,design_list.d_name,design_list.d_bottom_content,design_list.d_top_content as  folder_thum,design_list.d_default,design_list.d_intro,d_default_w3c FROM temp_index INNER JOIN design_list ON temp_index.template_id = design_list.d_id WHERE temp_index.filename = '".$_GET[filename]."'";
$sql_temp= $db->query($sql_temp);
$R = $db->db_fetch_array($sql_temp);
	?>
<html>
<head>
<title>Template Properties [<?php echo $R[d_name];?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<SCRIPT LANGUAGE="JavaScript">
	function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
	}
	 function emptyField(textObj) {
	   if (textObj.value.length == 0)
    		 return true;
	   for (var i=0; i<textObj.value.length; ++i) {
		     var ch = textObj.value.charAt(i);
		     if (ch != ' ' && ch != '	')
		        return false;
	   }
	   return true;
	 } 
	function  chk() {
		if (!emptyField(document.form2.file_name)){
			if (!validLength(document.form2.file_name.value,2,100)){
					alert("Your Web Content Page's name is too short or too long");
					document.form2.file_name.select();
					return false;
			}else if (document.form2.file_name.value.search("^[A-Za-z0-9_]+$")){
				alert("Web Content Page's name is limited to English character  (upper and lower case), number, and underscore only!");
				document.form2.file_name.select();
				return false;
			}
		}else{
				alert("Please assign name for your Web Content Page");
				document.form2.file_name.focus();
				return false;
		}
		if(document.form2.group_id.value == ""){
				alert("Please select group");
				return false;
		}
	} 
	function preview(c){
	t_preview.location.href = "../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id=" + c;
	}
		function showtable(c) {
			for(i=0; i<7; i++) {
				if(i != c) { document.getElementById("tr0" +i).style.display = 'none'; } else { document.getElementById("tr0" +i).style.display = ''; }
			}
			document.form2.tbshow.value = '0'+c;
		}
		function selColor(c,d,e) {
			Win2 = window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '&c_preview1=' + e + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
		}
		function choose_bg(c,d) {
			formPopUpBg.action = "../FileMgt/gallery_insert.php";
			window.open('','bg_popup','top=5,left=5,width=780,height=540,resizable=1,status=0');
			document.formPopUpBg.o_value.value = c;
			document.formPopUpBg.o_preview.value = "";
			formPopUpBg.submit();
		}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="10" cellspacing="0" bgcolor="E0DFE3">
	<form name="formPopUpBg" method="post" action="" target="bg_popup">
		<input name="o_value" type="hidden" id="o_value" value="">
		<input name="o_preview" type="hidden" id="o_preview" value="">
		<input name="stype" type="hidden" id="stype" value="images">
		<input name="Flag" type="hidden" id="Flag" value="Link">
	</form>
  <form action="content_function.php" enctype="multipart/form-data" method="post" name="form2"><tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td valign="top" bgcolor="FCFCFE">
              <table width="100%"  id="tr00" style="display:<?php if($tbshow == "00"){ echo '\'\''; }else{ echo "none"; } ?>" height="100%" border="0" cellpadding="2" cellspacing="0">
                <tr valign="top"> 
                  <td height="20"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="90" align="center" background="../images/bg1_on90.gif">Properties </td>
					<td width="90" align="center" background="../images/bg3_off90.gif"><a href="#design" onClick="showtable('1')">Site 
                    Structure </a></td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#design" onClick="showtable('2')">Top 
                    Design</a></td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('3')">Left 
                    Design </a></td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">Content 
                    Design</a></td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right 
                    Design </a></td>
                  <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom 
                    Design </a></td>
                  <td background="../images/bg2_off.gif">&nbsp;</td>
                </tr>
              </table></td>
                </tr>
                <tr valign="top"> 
                  <td> <table width="60%" border="0" align="center" cellpadding="6" cellspacing="1">
                      <tr> 
                        <td colspan="2" align="right" valign="top">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="30%" valign="top"><nobr>Template Name :</nobr></td>
                        <td width="70%" valign="top"><input name="d_name_t" type="text" id="d_name_t" value="<?php echo $R[d_name];?>" size="40"  ></td>
                      </tr>
					  <tr> 
                        <td rowspan="2" align="right" valign="top">&nbsp;</td>
                        <td valign="top"><input name="chk_t_default" type="checkbox" id="chk_t_default" value="Y" <?php if($R[d_default] == "Y") { echo "checked"; } ?>> Setting to default template </td>
                      </tr>
					  <tr>
					    <td valign="top"><input name="chk_t_default_w3c" type="checkbox" id="chk_t_default_w3c" value="Y" <?php if($R[d_default_w3c] == "Y") { echo "checked"; } ?>>
				        Setting to default w3c template </td>
				      </tr>
           			<tr> 
                        <td valign="top"><nobr>Block Design :</nobr></td>
                        <td valign="top"><select name="select_block_design">
                            <option value=""></option>
                            <?php //save_design_function
						$sql_themes = "SELECT * FROM themes ORDER BY themes_name ASC";
						$query = $db->query($sql_themes);
						while($rec_themes = $db->db_fetch_array($query)) {
							$select = '';
							if($R[d_bottom_content] == $rec_themes[themes_id]) {
								$select = 'selected';
							}
							echo " <option value=\"".$rec_themes[themes_id]."\"".$select.">".$rec_themes[themes_name]."</option>";
						}
					?>
                          </select> <input type="button" name="Submit_block_desing" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/theme_view.php?themes_id='+ document.form2.select_block_design.value +'','','height=300,width=480.scrollbars=1,resizable=1');"></td>
                      </tr>
					  <tr> 
                        <td valign="top">Theme for Intro page : </td>
                        <td valign="top"><?php
			if($R["d_intro"] == "Y" AND file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/intro/intro_".$R[template_id].".html")){
			?>
              <a href="<?php echo "../ewt/".$_SESSION["EWT_SUSER"]."/ewt_intro.php?id=".$R[template_id]; ?>" target="_blank"><img src="../images/look_view.gif" width="16" height="16" border="0" align="absmiddle"> 
                View Intro</a>  <br>
			<?php
			}
			?>
			<input name="file_html" type="file" id="file_html">
			<?php
			if($R["d_intro"] == "Y" AND file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/intro/intro_".$R[template_id].".html")){
			?>
              <div><input name="d_intro_cancel" type="checkbox" id="d_intro_cancel" value="Y">
              Cancel Intro <?php } ?>
              <input name="d_intro" type="hidden" id="d_intro" value="<?php echo $R["d_intro"]; ?>"></div></td>
                      </tr>
					    <tr> 
                        <td  valign="top">Picture floder name: </td>
                        <td  valign="top"><input name="img_floder" type="text" id="img_floder" size="25" value="<?php echo  $R["folder_thum"]; ?>"> </td>
                      </tr>
					    <tr> 
                        <td  valign="top">Thumbnail picture: </td>
                        <td  valign="top"><input name="file_thumb" type="file" id="file_thumb"> <br>
						<?php  
						 $thumb_name = "../ewt/template/images/thumbnails/template_".$R[d_id];	
						 if(file_exists($thumb_name)){
						 ?>
							<img src="../sitewizardMgt/img.php?p=<?php echo base64_encode($thumb_name); ?>" border="0" align="absmiddle"  style="cursor:hand" width="80"><br><input name="d_thumb_cancel" type="checkbox" id="d_thumb_cancel" value="Y"> Cancel Thumbnail picture
							<?php } ?>		</td>
                      </tr>
                      
                  </table></td>
                </tr>
				<tr valign="top" > 
                  <td height="10" align="right"> <hr size="1">
                    <input name="d_name" type="hidden" value="<?php echo $R[d_name];?>">
		<input type="hidden" name="tbshow" value="<?php echo $tbshow; ?>">
		<input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
		<input name="Flag" type="hidden" id="Flag" value="SaveTemplateConfig">
						  <input name="d_id" type="hidden" id="d_id" value="<?php echo $R[template_id];?>"><input type="submit" name="Submit" value="  Save  "> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
                </tr>
              </table>
              <table    id="tr01" style="display:<?php if($tbshow == "01"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td  > <table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Properties</a> </td>
                        <td width="90" align="center" background="../images/bg1_on90.gif">Site 
                          Structure </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#design" onClick="showtable('2')">Top 
                          Design</a></td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('3')">Left 
                          Design </a></td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">Content 
                          Design</a></td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right 
                          Design </a></td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom 
                          Design </a></td>
                        <td background="../images/bg2_off.gif">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td  align="center"><br>
<br>
<table width="60%" border="0" align="center" cellpadding="6" cellspacing="1">
                      <tr> 
                        <td width="40%" valign="top">Web page alignment : </td>
                        <td width="60%" valign="top"><select name="d_site_align" id="d_site_align" >
                            <option value="center" <?php if($R["d_site_align"] == "center"){ echo "selected"; } ?>>center</option>
                            <option value="left" <?php if($R["d_site_align"] == "left"){ echo "selected"; } ?>>left</option>
                            <option value="right" <?php if($R["d_site_align"] == "right"){ echo "selected"; } ?>>right</option>
                          </select></td>
                      </tr>
                      <tr> 
                        <td valign="top" >Total web page width : </td>
                        <td valign="top" ><input name="d_site_width" type="text"   value="<?php echo $R["d_site_width"]; ?>" size="4" maxlength="5"></td>
                      </tr>
                      <tr> 
                        <td valign="top">Left Section's width :</td>
                        <td valign="top"><input name="d_site_left" type="text" id="d_site_left"  value="<?php echo $R["d_site_left"]; ?>" size="4"></td>
                      </tr>
                      <tr> 
                        <td valign="top">Content Section's width : </td>
                        <td valign="top"><input name="d_site_content" type="text" id="d_site_content"   value="<?php echo $R["d_site_content"]; ?>" size="4"></td>
                      </tr>
                      <tr> 
                        <td valign="top">Right Section's width : </td>
                        <td valign="top"><input name="d_site_right" type="text" id="d_site_right"  value="<?php echo $R["d_site_right"]; ?>" size="4"></td>
                      </tr>
                      <tr> 
                        <td valign="top">Background color : </td>
                        <td><a id="CPreview1" style="background-color: <?php echo $R["d_site_bg_c"]; ?>;" onClick="selColor('window.opener.document.form2.d_site_bg_c.value','window.opener.document.all.CPreview1.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.Demo4.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> 
                          <input name="d_site_bg_c" type="text" value="<?php echo $R["d_site_bg_c"]; ?>" size="7" ></td>
                      </tr>
                      <tr> 
                        <td valign="top">Background Picture : </td>
                        <td valign="top"><nobr>
                          <input name="d_site_bg_p" type="text" id="d_site_bg_p" value="<?php echo $R["d_site_bg_p"]; ?>" size="40"  >
                          <a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_site_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.Demo4')"> 
                          <img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a></nobr></td>
                      </tr>
                      <tr> 
                        <td colspan="2" valign="top">&nbsp;</td>
                      </tr>
                    </table>
					<br>
                    <br>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td align="right"><hr size="1"> <input type="submit" name="Submit" value="  Save  ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
						</tr>
					</table>
				  </td>
                </tr>
              </table> 
		      <table id="tr02" style="display:<?php if($tbshow == "02"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td> <table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Properties</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site 
                          Structure</a> </td>
                        <td width="90" align="center" background="../images/bg1_on90.gif">Top 
                          Design</td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('3')">Left 
                          Design </a> </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">Content 
                          Design </a> </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right 
                          Design </a> </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom 
                          Design </a> </td>
                        <td background="../images/bg2_off.gif">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td><br>
<br>
<table width="60%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">Top design height : </td>
    <td width="60%"><input name="d_top_height" type="text"   value="<?php echo $R["d_top_height"]; ?>" size="4" maxlength="5"></td>
  </tr>
  <tr valign="top"> 
    <td height="36">Background color : </td>
    <td><a id="CPreview2" style="background-color: <?php echo $R["d_top_bg_c"]; ?>;" onClick="selColor('window.opener.document.form2.d_top_bg_c.value','window.opener.document.all.CPreview2.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbtop.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> 
      <input name="d_top_bg_c" type="text" value="<?php echo $R["d_top_bg_c"]; ?>" size="7"></td>
  </tr>
  <tr valign="top"> 
    <td>Background Picture : </td>
    <td><nobr><input name="d_top_bg_p" type="text"  value="<?php echo $R["d_top_bg_p"]; ?>" size="40"  > 
      <a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_top_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbtop')"> 
      <img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a></nobr></td>
  </tr>
  <tr valign="top"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
                    <br>
                    <br>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td align="right"><hr size="1"> <input type="submit" name="Submit" value="  Save  ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
						</tr>
					</table></td>
                </tr>
              </table>
					
              <table id="tr03" style="display:<?php if($tbshow == "03"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td> <table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Properties</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site 
                          Structure</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">Top 
                          Design</a></td>
                        <td width="90" align="center" background="../images/bg1_on90.gif">Left 
                          Design </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('4')">Content 
                          Design </a> </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right 
                          Design </a> </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom 
                          Design </a> </td>
                        <td background="../images/bg2_off.gif">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td><br>
<br>
<table width="60%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">Background color : </td>
    <td width="60%"><a id="CPreview3" style="background-color: <?php echo $R["d_left_bg_c"]; ?>;" onClick="selColor('window.opener.document.form2.d_left_bg_c.value','window.opener.document.all.CPreview3.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbleft.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> <input name="d_left_bg_c" type="text" value="<?php echo $R["d_left_bg_c"]; ?>" size="7"></td>
  </tr>
  <tr valign="top"> 
    <td>Background Picture : </td>
    <td><nobr><input name="d_left_bg_p" type="text" id="d_left_bg_p" value="<?php echo $R["d_left_bg_p"]; ?>" size="40"  ><a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_left_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbleft')">  <img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a></nobr></td>
  </tr>
  <tr valign="top"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
                    <br>
                    <br>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td align="right"><hr size="1"> <input type="submit" name="Submit" value="  Save  ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
						</tr>
					</table></td>
                </tr>
              </table>
					
              <table id="tr04" style="display:<?php if($tbshow == "04"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td> <table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Properties</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site 
                          Structure</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">Top 
                          Design</a></td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('3')">Left 
                          Design</a> </td>
                        <td width="90" align="center" background="../images/bg1_on90.gif">Content 
                          Design </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('5')">Right 
                          Design </a> </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom 
                          Design </a> </td>
                        <td background="../images/bg2_off.gif">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td><br>
<br>
<table width="60%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">Background color : </td>
    <td width="60%"><a id="CPreview4" style="background-color: <?php echo $R["d_body_bg_c"]; ?>;" onClick="selColor('window.opener.document.form2.d_body_bg_c.value','window.opener.document.all.CPreview4.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbcontent.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a> <input name="d_body_bg_c" type="text" value="<?php echo $R["d_body_bg_c"]; ?>" size="7"></td>
  </tr>
  <tr valign="top"> 
    <td>Background Picture : </td>
    <td><nobr><input name="d_body_bg_p" type="text"  value="<?php echo $R["d_body_bg_p"]; ?>" size="40" ><a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_body_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbcontent')">  <img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a></nobr></td>
  </tr>
  <tr valign="top"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
                    <br>
                    <br>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td align="right"><hr size="1"> <input type="submit" name="Submit" value="  Save  ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
						</tr>
					</table></td>
                </tr>
              </table>
					
              <table id="tr05" style="display:<?php if($tbshow == "05"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td> <table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')"> 
                          Properties</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site 
                          Structure</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">Top 
                          Design</a></td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('3')">Left 
                          Design</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('4')">Content 
                          Design</a> </td>
                        <td width="90" align="center" background="../images/bg1_on90.gif">Right 
                          Design </td>
                        <td width="90" align="center" background="../images/bg3_off90.gif"><a href="#popup" onClick="showtable('6')">Bottom 
                          Design </a> </td>
                        <td background="../images/bg2_off.gif">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td><br>
<br>
<table width="60%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">Background color : </td>
    <td width="60%"><a id="CPreview5" style="background-color: <?php echo $R["d_right_bg_c"]; ?>;" onClick="selColor('window.opener.document.form2.d_right_bg_c.value','window.opener.document.all.CPreview5.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbright.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a>  <input name="d_right_bg_c" type="text" value="<?php echo $R["d_right_bg_c"]; ?>" size="7"></td>
  </tr>
  <tr valign="top"> 
    <td>Background Picture : </td>
    <td><nobr><input name="d_right_bg_p" type="text"  value="<?php echo $R["d_right_bg_p"]; ?>" size="40" ><a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_right_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbright')"> <img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a></nobr></td>
  </tr>
  <tr valign="top"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
                    <br>
                    <br>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td align="right"><hr size="1"> <input type="submit" name="Submit" value="  Save  ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
						</tr>
					</table></td>
                </tr>
              </table>
					
              <table id="tr06" style="display:<?php if($tbshow == "06"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td > <table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Properties</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('1')">Site 
                          Structure</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('2')">Top 
                          Design</a></td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('3')">Left 
                          Design</a> </td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('4')">Content 
                          Design</a></td>
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#popup" onClick="showtable('5')">Right 
                          Design</a> </td>
                        <td width="90" align="center" background="../images/bg1_on90.gif">Bottom 
                          Design </td>
                        <td background="../images/bg2_off.gif">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <tr> 
                  <td><br>
<br>
<table width="60%" border="0" align="center" cellpadding="6" cellspacing="1">
  <tr valign="top"> 
    <td width="40%">Bottom design height :</td>
    <td width="60%"><input name="d_bottom_height" type="text"  value="<?php echo $R["d_bottom_height"]; ?>" size="4" maxlength="5"></td>
  </tr>
  <tr valign="top"> 
    <td height="36">Background color : </td>
    <td><a id="CPreview6" style="background-color: <?php echo $R["d_bottom_bg_c"]; ?>;" onClick="selColor('window.opener.document.form2.d_bottom_bg_c.value','window.opener.document.all.CPreview6.style.backgroundColor','window.opener.parent.content_top.iframe_data.document.all.tbbottom.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a>
      <input name="d_bottom_bg_c" type="text" value="<?php echo $R["d_bottom_bg_c"]; ?>" size="7"></td>
  </tr>
  <tr valign="top"> 
    <td>Background Picture : </td>
    <td><nobr><input name="d_bottom_bg_p" type="text"  value="<?php echo $R["d_bottom_bg_p"]; ?>" size="40"  > <a href="#choose_bg" onClick="choose_bg('window.opener.document.form2.d_bottom_bg_p.value','self.opener.parent.content_top.iframe_data.document.all.tbbottom')"> <img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"></a></nobr></td>
  </tr>
  <tr valign="top"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
                    <br>
                    <br>
                    <table width="100%" border="0" cellspacing="1" cellpadding="1">
						<tr>
							<td align="right"><hr size="1"> <input type="submit" name="Submit" value="  Save  ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
						</tr>
					</table></td>
                </tr>
              </table>
					
		</td>
        </tr>
      </table></td>
  </tr></form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
