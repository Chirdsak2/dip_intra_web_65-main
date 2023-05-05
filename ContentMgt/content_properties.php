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
$group = "SELECT * FROM temp_main_group";
$sql_group= $db->query($group);


$sql_temp = "select * from temp_index where filename = '".$_GET[filename]."'";
$sql_temp= $db->query($sql_temp);
$R = $db->db_fetch_array($sql_temp);
	?>
<html>
<head>
<title>Page Properties [<?php echo $R[filename];?>]</title>
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
		function loadp(c){
		document.formGet.openurl.value = document.URL;
		document.formGet.objto.value = c;
		formGet.submit();
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
  <form name="formGet" method="post" action="content_function.php" target="bg_gets">
		<input name="objto" type="hidden" >
		<input name="openurl" type="hidden"  value="">
		<input name="filename1" type="hidden" id="filename1" value="<?php echo $_GET["filename"]; ?>">
		<input name="Flag" type="hidden" id="Flag" value="Gets">
	</form><form action="content_function.php" method="post" name="form2"><tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="10" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td valign="top" bgcolor="FCFCFE">
              <table width="100%"  id="tr00" style="display:<?php if($tbshow == "00"){ echo '\'\''; }else{ echo "none"; } ?>" height="100%" border="0" cellpadding="2" cellspacing="0">
                <tr valign="top"> 
                  <td height="20" colspan="2"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="90" align="center" background="../images/bg1_on90.gif">Page Properties </td>
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
                  <td width="50%"> <table width="100%" border="0" cellspacing="1" cellpadding="6">
                      <tr> 
                        <td colspan="2" align="right" valign="top">&nbsp;</td>
                      </tr>
                      <tr> 
                        <td width="30%" valign="top"><nobr>Page Name :</nobr></td>
                        <td width="70%" valign="top"><?php echo $R[filename];?></td>
                      </tr>
                      <tr> 
                        <td valign="top">Title :</td>
                        <td valign="top"><input name="title" type="text" id="title" size="40"  value="<?php echo $R[title];?>"></td>
                      </tr>					  
					  <tr> 
                        <td valign="top"><nobr>Keyword : </nobr><br>
                        <input type="button" name="Submit32" value="Load Content &gt;&gt;" style="width:100px" onClick="loadp('keyword');">
                        <iframe name="bg_gets" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe></td>
                        <td valign="top"><textarea name="keyword" cols="40" rows="7" id="keyword"><?php echo trim($R[cms_keyword]);?></textarea></td>
                      </tr>
                      <tr> 
                        <td valign="top"><nobr>Description : </nobr><br>
                        <input type="button" name="Submit3" value="Load Content &gt;&gt;" style="width:100px"  onClick="loadp('description');"></td>
                        <td valign="top"><textarea name="description" cols="40" rows="7" id="description"><?php echo $R[cms_description];?></textarea></td>
                      </tr>
                      <tr> 
                        <td valign="top">Template : </td>
                        <td valign="top"><select name="select_template"  >
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
                          </select> <input type="button" name="Submit2" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id='+ document.form2.select_template.value +'','','height=600,width=780,scrollbars=1,resizable=1');"></td>
                      </tr>
					   <tr>
                        <td valign="top">W3c Template : </td>
                        <td valign="top"><select name="select_template_w3c"  >
						<option value="">--เลือก---</option>.
                            <?php //save_design_function
					$sql_design = "SELECT * FROM design_list ORDER BY d_name ASC";
					$query = $db->query($sql_design);
					while($rec_design = $db->db_fetch_array($query)) {
						$select = '';
						if($R[template_id_w3c] == $rec_design[d_id]) {
							$select = 'selected';
							$themes_show = $rec_design[d_bottom_content];
						}
						echo " <option value=\"".$rec_design[d_id]."\"".$select.">".$rec_design[d_name]."</option>";
					}
				?>
                          </select> <input type="button" name="Submit2" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id='+ document.form2.select_template_w3c.value +'','','height=600,width=780,scrollbars=1,resizable=1');"></td>
                      </tr>
                      <tr> 
                        <td valign="top"><nobr>Block Design :</nobr></td>
                        <td valign="top"><select name="select_block_desing">
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
                          </select> <input type="button" name="Submit_block_desing" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/theme_view.php?themes_id='+ document.form2.select_block_desing.value +'','','height=300,width=480.scrollbars=1,resizable=1');"></td>
                      </tr>
                      <tr> 
                        <td align="right"><input name="chk_for_intro" type="checkbox" id="chk_for_intro" value="Y" <?php if($R["set_intro"] == "Y"){ echo "checked"; } ?>></td>
                        <td>Setting page for intro</td>
                      </tr>
                      <tr>
                        <td>Tool Tips : </td>
                        <td><a href="##P" title="เพิ่ม Tool Tips"  onClick="window.open('content_tooltips.php?type=p&filename=<?php echo $R[filename];?>','','height=600,width=780,scrollbars=1,resizable=1');"><img src="../images/help.gif" alt="เพิ่ม Tool Tips" width="16" height="16" align="absmiddle" border="0"> เพิ่ม Tool Tips </a></td>
                      </tr>
                    </table></td>
                  <td width="50%"> <table width="100%" height="100%" border="0" cellpadding="6" cellspacing="1">
                      <tr> 
                        <td height="20" bgcolor="#FFFFFF">Location : <span id="gname"></span></td>
                      </tr>
                      <tr> 
                        <td bgcolor="#FFFFFF"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
                            <tr> 
                              <td bgcolor="#FFFFFF"><iframe name="iframe_data" src="content_list.php?filename=<?php echo $_GET[filename];?>" frameborder="1"  width="100%" height="100%" scrolling="yes"></iframe></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
				<tr valign="top" > 
                  <td height="10" colspan="2" align="right"> <hr size="1">
                    <input name="templade_old" type="hidden" value="<?php echo $R[template_id];?>">
		<input name="themes_show_old" type="hidden" value="<?php echo $themes_show;?>">
		<input type="hidden" name="tbshow" value="<?php echo $tbshow; ?>">
		<input name="filename" type="hidden" id="filename" value="<?php echo $_GET["filename"]; ?>">
		<input name="Flag" type="hidden" id="Flag" value="SaveDataConfig">
                          <input name="group_id" type="hidden" id="group_id" value="<?php echo $R[Main_Group_ID];?>">
						  <input name="filenameold" type="hidden" id="filenameold" value="<?php echo $_GET[filename];?>"><input type="submit" name="Submit" value="  Save  "> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="button" name="Submit2" value="Cancel" onClick="self.close();"></td>
                </tr>
              </table>
              <table    id="tr01" style="display:<?php if($tbshow == "01"){ echo '\'\''; }else{ echo "none"; } ?>" width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr> 
                  <td  > <table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                      <tr> 
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Page 
                          Properties</a> </td>
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
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Page 
                          Properties</a> </td>
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
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Page 
                          Properties</a> </td>
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
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Page 
                          Properties</a> </td>
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
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Page 
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
                        <td width="90" align="center" background="../images/bg1_off90.gif"><a href="#design" onClick="showtable('0')">Page 
                          Properties</a> </td>
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
