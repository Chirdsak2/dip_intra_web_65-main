<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/menu_language.php");
$sql_menu = $db->query("SELECT * FROM menu_list WHERE m_id = '".$_GET["m_id"]."' ");
$R = $db->db_fetch_array($sql_menu);

			//setting hide/show
			if($_GET["tb_show"] == ""){
			$tbshow = "01";
			}else{
			$tbshow = $_GET["tb_show"];
			}
			
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script  language="JavaScript">
		  	function selColor(c,d){
				Win2=window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
			}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#333333" class="ewttableuse">
  <tr> 
    <td height="30"  bgcolor="#FFFFFF" class="ewttablehead"><img src="../theme/main_theme/menu_properties.gif" width="24" height="24" align="absmiddle"> 
      <?php echo $text_menu_properties; ?> &gt;&gt;  <?php echo trim($R["m_name"]); ?> </td>
  </tr>
  
<form name="form1" method="post" action="menu_function.php">
	<tr  id="tr01" style="display:<?php if($tbshow == "01"){ echo '\'\''; }else{ echo "none"; } ?>">   
      <td  valign="top" bgcolor="F7F7F7"><br>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
          <tr>
                  
            <td width="100" align="center" background="../images/bg1_on.gif"><?php echo $text_menu_newsub; ?></td>
                  <td width="100" align="center" background="../images/bg3_off.gif"><a href="#design" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='';document.all.tr03.style.display='none';document.linkForm.tbshow.value='02';"><?php echo $text_menu_p1; ?></a></td>
                  
				  <td width="100" align="center" background="../images/bg3_off.gif"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';"><?php echo $text_menu_p2; ?></a> </td>
					
            <td background="../images/bg2_off.gif">&nbsp;</td>
          </tr>
</table>

<table width="100%" border="0" align="center" class="table table-bordered" >
      
          <tr align="right" bgcolor="F7F7F7"> 
            <td height="30" align="left"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';"><?php echo $text_menu_p3; ?></a>
              <input name="m_name" type="text"  id="m_name" size="40" class="form-control" style="width:40%" > 
			  <input name="Flag" type="hidden" id="Flag" value="AddSub"> 
              <input name="m_id" type="hidden" id="m_id" value="<?php echo $_GET["m_id"]; ?>" > 
              <input type="submit" name="Submit" value="Add menu" class="btn btn-success" > 
			  </td>
		</tr>
</table>

</td>
</tr>
</form>

<form name="linkForm" method="post" action="menu_function.php">
<input type="hidden" name="tbshow" value="<?php echo $tbshow; ?>">
<tr  id="tr02" style="display:<?php if($tbshow == "02"){ echo '\'\''; }else{ echo "none"; } ?>">   
<td  valign="top" bgcolor="F7F7F7">
<br>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td width="100" align="center" background="../images/bg1_off.gif"><a href="#menu" onClick="document.all.tr01.style.display='';document.all.tr02.style.display='none';document.all.tr03.style.display='none';document.linkForm.tbshow.value='01';"><?php echo $text_menu_newsub; ?></a> </td>
                  <td width="100" align="center" background="../images/bg1_on.gif"><?php echo $text_menu_p1; ?></td>
		
                  <td width="100" align="center" background="../images/bg3_off.gif"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';"><?php echo $text_menu_p2; ?></a> </td>

                  <td background="../images/bg2_off.gif">&nbsp;</td>
                </tr>
</table>

<table width="100%" border="0" align="center" class="table table-bordered" >
<tr> 
<td colspan="2"><?php echo $text_menu_menuname; ?>&nbsp;
<input name="menu_name" type="text" id="menu_name" value="<?php echo $R["m_name"]; ?>" size="40" class="form-control" style="width:30%" />
</td>
</tr>
    <tr> 
      <td width="50%"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';"><?php echo $text_menu_p4; ?></a> 
        <select name="glo_align" class="form-control" style="width:30%">
          <option value="0" <?php if($R[glo_align]==0) {?>selected<?php }?>>Left</option>
          <option value="1" <?php if($R[glo_align]==1) {?>selected<?php }?>>Center</option>
          <option value="2" <?php if($R[glo_align]==2) {?>selected<?php }?>>Right</option>
        </select>
		</td>
        <td width="50%">
		<a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';"><?php echo $text_menu_p5; ?></a>
        <input name="glo_delay_hor" type="text"  size="3" value="<?php echo $R[glo_delay_hor]; ?>" class="form-control" style="width:20%">
		</td>
		</tr>
		<tr> 
		<td>
		<input type="checkbox" name="glo_showsub" value="Y" onClick="ChkH(this)" <?php if($R[glo_showsub]=="Y"){ echo "checked"; } ?>>
        <a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';"><?php echo $text_menu_p6; ?></a>

		<script>
function ChkH(c){
if(c.checked){
document.linkForm.glo_highlight.disabled = false;
}else{
document.linkForm.glo_highlight.disabled = true;
}
}
</script> 
</td>
            <td>
			<a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';"><?php echo $text_menu_p7; ?></a>
            <input name="glo_delay_ver" type="text"  size="3" value="<?php echo $R['glo_delay_ver'];?>" class="form-control" style="width:20%">
			</td>
			</tr>
			<tr> 
			<td>
			<input name="glo_highlight" type="checkbox" id="glo_highlight" value="Y" <?php if($R[glo_highlight]=="Y"){ echo "checked"; } else {  echo "disabled ";} ?>>
			<?php echo $text_menu_p8; ?>
			</td>
            <td>
			<?php echo $text_menu_p9; ?> 
			<input name="glo_delay_hide" type="text"  size="3" value="<?php echo $R[glo_delay_hide]; ?>" class="form-control" style="width:20%">
			</td>
			</tr>
			<tr align="right"> 
			<td colspan="2">
              <input type="submit" name="Submit2" value="Save" class="btn btn-success"  >
              <input name="m_id" type="hidden" id="m_id" value="<?php echo $_GET["m_id"]; ?>">
			  <input name="m_name" type="hidden" id="m_name" value="<?php echo $R["m_name"]; ?>">
              <input type="hidden" name="Flag" value="EDIT_MAIN">
          </td>
		  </tr>
		  </table>
		  </td>
		  </tr>
	
<tr  id="tr03" style="display:<?php if($tbshow == "03"){ echo '\'\''; }else{ echo "none"; } ?>">   
<td  valign="top" bgcolor="F7F7F7">
<br>	  
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
          <tr>
                  <td width="100" align="center" background="../images/bg1_off.gif"><a href="#menu" onClick="document.all.tr01.style.display='';document.all.tr02.style.display='none';document.all.tr03.style.display='none';document.linkForm.tbshow.value='01';"><?php echo $text_menu_newsub; ?></a> </td>
                  <td width="100" align="center" background="../images/bg1_off.gif"><a href="#design" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='';document.all.tr03.style.display='none';document.linkForm.tbshow.value='02';"><?php echo $text_menu_p1; ?></a></td>
                  <td width="100" align="center" background="../images/bg1_on.gif"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';"><?php echo $text_menu_p2; ?></a></td>
            <td background="../images/bg2_off.gif">&nbsp;</td>
          </tr>
</table>
		
<table width="100%" border="0" align="center" class="table table-bordered">
<tr> 
<td width="25%"><?php echo $text_menu_p10; ?> :
        <select name="pop_display" class="form-control" style="width:50%" >
          <option  value="0" <?php if($R[pop_display]==0){?> selected<?php }?>>Horizontally</option>
          <option value="1"  <?php if($R[pop_display]==1){?> selected<?php }?>>Vertically</option>
        </select> 
</td>
<td width="25%"><?php echo $text_menu_p11; ?> :
        <input name="pop_trans" type="text"  size="3" value="<?php echo $R[pop_trans]; ?>" class="form-control" style="width:20%"></td>
<td width="26%"><?php echo $text_menu_p12; ?> :
        <input name="pop_spacing" type="text"  size="3" value="<?php echo $R[pop_spacing]; ?>" class="form-control" style="width:20%"></td>
<td width="24%"><?php echo $text_menu_p13; ?> :
        <input name="pop_padding" type="text"  size="3" value="<?php echo $R[pop_padding]; ?>" class="form-control" style="width:20%"></td></tr>
<tr> 
<td>
<table border="0" cellspacing="0" cellpadding="1" width="100%" >
          <tr> 
            <td width="20%"><?php echo $text_menu_p14; ?> : </td>     
			<td> 
			<a id="CPreview5" style="background-color: <?php echo $R[pop_bgcolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.pop_bgcolor.value','window.opener.document.all.CPreview5.style.backgroundColor');">
			<img src="../images/box_color.gif" width="21" height="23"></a>
			<input name="pop_bgcolor" type="text"   id="pop_bgcolor" value="<?php echo $R[pop_bgcolor]; ?>"  size=7 maxlength="7" class="form-control" style="width:50%"> 
            </td>
          </tr>
        </table></td>
<td colspan="3"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="display:none">
          <tr> 
            <td>รูปภาพพื้นหลัง : " 
              <?php if($R[pop_bgimage] != ""){ echo $R[pop_bgimage]; }else{ echo "none"; } ?>
              " <input name="Oubgpic" type="hidden" id="Oubgpic" value="<?php echo $R[pop_bgimage]; ?>"> 
              <br>
              รูปพื้นหลัง <strong> 
              <input name="Oubgpicn" type="file"  id="Oubgpicn">
              </strong> <input type="button" name="Button2" value="แฟ้มรูปภาพ" > 
              <input name="Oubgpicr" type="checkbox" id="Oubgpicr" value="Y">
              ลบรูปภาพ </td>
          </tr>
 </table>
 </td>
</tr>

<tr> 
<td><?php echo $text_menu_p15; ?> :
<input name="pop_borwidth" type="text"  size="3" value="<?php echo $R[pop_borwidth]; ?>" class="form-control" style="width:30%"></td>
<td>
	<table border="0" cellspacing="0" cellpadding="1" width="100%" >
          <tr> 
            <td width="20%"><?php echo $text_menu_p16; ?> :  </td>
			<td width="80%"> 
			<a id="CPreview8" style="background-color: <?php echo $R[pop_borcolor]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.pop_borcolor.value','window.opener.document.all.CPreview8.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>	
         			
			<input name="pop_borcolor" type="text" id="pop_borcolor" value="<?php echo $R[pop_borcolor]; ?>"  maxlength="7" class="form-control" style="width:50%"> 
            </td>
          </tr>
        </table>
</td>
<td><?php echo $text_menu_p17; ?> :
          <select name="pop_borstyle" class="form-control" style="width:50%" >
            <option value="0" <?php if($R[pop_borstyle]==0) {?>selected<?php }?>>None</option>
            <option value="1"  <?php if($R[pop_borstyle]==1) {?>selected<?php }?>>Solid</option>
            <option value="2"  <?php if($R[pop_borstyle]==2) {?>selected<?php }?>>Double</option>
            <option value="3"  <?php if($R[pop_borstyle]==3) {?>selected<?php }?>>Dotted</option>
            <option value="4"  <?php if($R[pop_borstyle]==4) {?>selected<?php }?>>Dashed</option>
            <option value="5"  <?php if($R[pop_borstyle]==5) {?>selected<?php }?>>Groove</option>
            <option value="6" <?php if($R[pop_borstyle]==6) {?>selected<?php }?>>Ridge</option>
          </select></td><td><div align="right"> </div></td>
    </tr>
 <tr> 
<td colspan="3">
<input type="checkbox" name="set_default" value="Y">
<?php echo $text_menu_p18; ?>
</td>
<td>
<div align="right">
	  <input type="submit" name="Submit2" value="Save" class="btn btn-success" />
</div>
</td>
</tr>
</table>
</td>
</tr>
</form>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
