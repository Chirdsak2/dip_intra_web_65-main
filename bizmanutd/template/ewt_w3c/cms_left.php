<?php include("../protect1.php"); ?>
<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if($ADMINL == "Y"){ 
if(!($sm3=="Y" && $sd3=="Y")){ Header("Location:../admin_error.php?E=Err2"); exit; }
if(eregi("Y",$_GET['sm3'])){ Header("Location:../admin_error.php?E=Err2"); exit; }
if(eregi("Y",$_GET['sd3'])){ Header("Location:../admin_error.php?E=Err2"); exit; }
if(eregi("G2",$_GET['FuncG2'])){ Header("Location:../admin_error.php?E=Err2"); exit; }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<?php  ?>
<?php include("../lang_config.php"); ?>
<?php include($LangContentMgt); ?>
<html>
<head>
<title>CMS -- Left File</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="content-type" content="text/html;charset=UTF-8">
<SCRIPT Language="JavaScript">
function hidestatus(){
window.status=''
return true
}
if (document.layers)
document.captureEvents(Event.MOUSEOVER | Event.MOUSEOUT)
document.onmouseover=hidestatus
document.onmouseout=hidestatus
</SCRIPT>
<SCRIPT Language="JavaScript">
<!--
function click(){
if (event.button==2)
  {
    alert("EasyWebTime a BizPotential Company \n\n Copyright 2001, All Rights Reserved"); 
  }
}
document.onmousedown=click;

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>
<style type="text/css">
<!--
a:link { text-decoration: none}
a:visited { text-decoration: none}
a:active { text-decoration: underline}
a:hover { text-decoration: underline}
-->
</style>
</head>
<body bgcolor="#FFCC33">
<? if($CmsID == ""){ ?>
<table width="98%" border="0" cellspacing="0" cellpadding="2">
  <tr> 
    <td valign="middle" colspan="2"><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"><?php echo $HeadingLeft_Gp ?></font></b></font></font></td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#000099" height="1"></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="cms_gp_add.php" target="mainFrame"><img src="../images/new_b_general_add_ffcc33.gif" width="32" height="31" border="0" align="absmiddle"></a></font><font size="1" color="#000000"></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"> <font size="1"><a href="cms_gp_add.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_5_1;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" height="24" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="cms_gp_mod_index.php" target="mainFrame"><img src="../images/new_b_general_edit_ffcc33.gif" width="32" height="31" border="0"></a></font></font></b></td>
    <td valign="middle" height="24" bgcolor="#FFCC33"> <font size="1"><a href="cms_gp_mod_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_5_2;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="cms_gp_del_index.php" target="mainFrame"><img src="../images/new_b_general_delete_ffcc33.gif" width="32" height="31" border="0"></a></font><font size="1" color="#000000"></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="cms_gp_del_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_5_3;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="cms_gp_link_index.php" target="mainFrame"><img src="../images/new_b_general_style_ffcc33.gif" width="32" height="31" border="0"></a></font><font size="1" color="#000000"></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="cms_gp_link_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_5_4;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" height="24" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="w3c_index.php" target="mainFrame"><img src="../images/new_b_general_edit_ffcc33.gif" width="32" height="31" border="0"></a></font></font></b></td>
    <td valign="middle" height="24" bgcolor="#FFCC33"> <font size="1"><a href="w3c_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b>  W3C </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" height="24" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="tag_info.php" target="mainFrame"><img src="../images/data.gif"   border="0"></a></font></font></b></td>
    <td valign="middle" height="24" bgcolor="#FFCC33"> <font size="1"><a href="tag_info.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> ฐานข้อมูล Tag</b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" height="24" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="possible_attribute.php" target="mainFrame"><img src="../images/data_preferences.gif"   border="0"></a></font></font></b></td>
    <td valign="middle" height="24" bgcolor="#FFCC33"> <font size="1"><a href="possible_attribute.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> ฐานข้อมูล attribute</b></font></a></font></td>
  </tr>
  
  <tr> 
    <td valign="middle" height="24" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="correct_attribute.php" target="mainFrame"><img src="../images/data_replace.gif"  border="0"></a></font></font></b></td>
    <td valign="middle" height="24" bgcolor="#FFCC33"> <font size="1"><a href="correct_attribute.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> ฐานข้อมูลแก้ไขหน้าเวบ</b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" height="24" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="w3c_templete.php" target="mainFrame"><img src="../images/new_b_general_style_ffcc33.gif"  border="0"></a></font></font></b></td>
    <td valign="middle" height="24" bgcolor="#FFCC33"> <font size="1"><a href="w3c_templete.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> ปรับปรุงเมนู/Templete</b></font></a></font></td>
  </tr>
    <tr> 
    <td valign="middle" height="24" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="w3c_apply_menu.php" target="mainFrame"><img src="../images/new_b_general_style_ffcc33.gif"  border="0"></a></font></font></b></td>
    <td valign="middle" height="24" bgcolor="#FFCC33"> <font size="1"><a href="w3c_apply_menu.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> ประยุกต์ใช้เมนูใหม่</b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33"><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      </font><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      <?php echo $HeadingLeft_WebPage?> </font></b></font></font></b></font></font><font face="ms sans serif" size="2"><b></b></font></td>
  </tr>
  <tr bgcolor="#000099"> 
    <td valign="middle" colspan="2"></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="cms_frameset.php" target="_parent"><img src="../images/new_b_general_add_ffcc33.gif" width="32" height="31" border="0"></a></font><font size="1" color="#000000"></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="cms_main_gp.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_1;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" height="2" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="cms_mod_index.php" target="mainFrame"><img src="../images/new_b_general_edit_ffcc33.gif" width="32" height="31" border="0"></a></font></font></b></td>
    <td valign="middle" height="2" bgcolor="#FFCC33"><font size="1"><a href="cms_mod_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_2;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1">&nbsp;</font></td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33"><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      <?php echo $HeadingLeft_Picture; ?> </font></b></font></font><font face="ms sans serif" size="2"><b></b></font></td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#000099" height="1"></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><font face="ms sans serif" size="2"><a href="dms/images.php" target="mainFrame"><img src="../images/new_b_general_upload_ffcc33.gif" width="32" height="31" border="0"></a></font></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="dms/images.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_3;?></b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="dms/download.php" target="mainFrame"><img src="../images/new_b_general_upload_ffcc33.gif" width="32" height="31" border="0"></a></font><font size="1" color="#000000"></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="dms/download.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_4;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <?php if($FuncG2=="G2"){ ?> 
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33"><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      <?php echo $HeadingLeft_User?> </font></b></font></font><font face="ms sans serif" size="2"><b></b></font></td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#000099" height="1"></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="#5544" onClick="MM_openBrWindow('../Ewt_Cms/admin_main.php','CmsAdmin','scrollbars=yes,resizable=yes,width=550,height=500')"><img src="../images/new_b_general_user_ffcc33.gif" width="32" height="31" border="0"></a></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="#5544" onClick="MM_openBrWindow('../Ewt_Cms/admin_main.php','CmsAdmin','scrollbars=yes,resizable=yes,width=550,height=500')"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_6;?> </b></font></a></font></td>
  </tr>
  <?php } ?> 
</table>
<? }else{  //////////////////////////////////////////////////////////////////////////////// cms admin zone ///////////////////////////////////////////////////////////////////////////?>
<table width="98%" border="0" cellspacing="0" cellpadding="2">
  <? if($cms4=="Y"){ ?>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33"><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      </font><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      <?php echo $HeadingLeft_WebPage?> </font></b></font></font></b></font></font><font face="ms sans serif" size="2"><b></b></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="cms_frameset.php" target="_parent"><img src="../images/new_b_general_add_ffcc33.gif" width="32" height="31" border="0"></a></font><font size="1" color="#000000"></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="cms_main_gp.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_1;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" height="2" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="cms_mod_index.php" target="mainFrame"><img src="../images/new_b_general_edit_ffcc33.gif" width="32" height="31" border="0"></a></font></font></b></td>
    <td valign="middle" height="2" bgcolor="#FFCC33"><font size="1"><a href="cms_mod_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_2;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="cms_gp_link_index.php" target="mainFrame"><img src="../images/new_b_general_style_ffcc33.gif" width="32" height="31" border="0"></a></font><font size="1" color="#000000"></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="cms_gp_link_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_5_4;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1">&nbsp;</font></td>
  </tr>
  <? } ?>
  <? if(($cms2=="Y")or($cms3=="Y")){ ?>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33"><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      <?php echo $SetWebBlock;?> </font></b></font></font><font face="ms sans serif" size="2"><b></b></font></td>
  </tr>
  <? } ?>
  <? if($cms2 == "Y"){ ?>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="../BlockMgt/html.php" target="mainFrame"><img src="../images/new_b_general_add_ffcc33.gif" width="32" height="31" border="0"></a></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="../BlockMgt/html.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $Management_cms_webblock1;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="../BlockMgt/block_mod_index.php" target="mainFrame"><img src="../images/new_b_general_edit_ffcc33.gif" width="32" height="31" border="0"></a></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="../BlockMgt/block_mod_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $Management_cms_webblock2;?> </b></font></a></font></td>
  </tr>
  <? } if($cms3=="Y") {?>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="cms_mod_main_all.php?showall=Y&by=g"  target="mainFrame" ><img src="../images/new_b_general_style_ffcc33.gif" width="32" height="31" border="0"></a></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="cms_mod_main_all.php?showall=Y&by=g"  target="mainFrame" ><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SetWebBlock;?> </b></font></a></font></td>
  </tr>
  <? } ?>
  <? if(($cms2=="Y")or($cms3=="Y")){ ?>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1">&nbsp;</font></td>
  </tr>
  <? } ?>
   <tr> 
    <td valign="middle" height="24" bgcolor="#FFCC33"><b><font size="1" color="#000000"><font face="ms sans serif" size="2"><a href="w3c_index.php" target="mainFrame"><img src="../images/new_b_general_edit_ffcc33.gif" width="32" height="31" border="0"></a></font></font></b></td>
    <td valign="middle" height="24" bgcolor="#FFCC33"> <font size="1"><a href="w3c_index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b>  W3C </b></font></a></font></td>
  </tr>
  
  
  <? if($cms1=="Y"){ ?>
  <tr> 
    <td valign="middle" colspan="2"><font face="ms sans serif" size="2"><b><font color="#000099" size="3"><?php echo $Save;?></font></b></font></td>
  </tr>
  <tr> 
    <td valign="middle"><font face="MS Sans Serif" size="1"><a href="html_index.php" target="mainFrame"><img src="../images/new_b_general_save_ffcc33.gif" width="32" height="31" border="0" align="absmiddle"></a></font></td>
    <td valign="middle"> <a href="html_index.php" target="mainFrame"><font face="ms sans serif" color="#000000" size="1"> 
      <b> <?php echo $MainMenu9;?> </b></font> </a></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33">&nbsp;</td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1">&nbsp;</font></td>
  </tr>
  <? } ?>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33"><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      แบบสำรวจออนไลน์ </font></b></font></font><font face="ms sans serif" size="2"><b></b></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><font face="ms sans serif" size="2"><a href="../Survey/index.php" target="mainFrame"><img src="../images/new_b_general_style_ffcc33.gif" width="32" height="31" border="0"></a></font></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="../Survey/index.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b>  แบบสำรวจออนไลน์ </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33"><font size="2"><font face="ms sans serif" color="#003399" size="3"><b><font color="#000099"> 
      <?php echo $HeadingLeft_Picture?> </font></b></font></font><font face="ms sans serif" size="2"><b></b></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><font face="ms sans serif" size="2"><a href="dms/images.php" target="mainFrame"><img src="../images/new_b_general_upload_ffcc33.gif" width="32" height="31" border="0"></a></font></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="dms/images.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_3;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" bgcolor="#FFCC33"><b><font face="ms sans serif" size="2"><a href="dms/download.php" target="mainFrame"><img src="../images/new_b_general_upload_ffcc33.gif" width="32" height="31" border="0"></a></font><font size="1" color="#000000"></font></b></td>
    <td valign="middle" bgcolor="#FFCC33"><font size="1"><a href="dms/download.php" target="mainFrame"><font face="ms sans serif" color="#000000"> 
      <b> <?php echo $SubMenu2_4;?> </b></font></a></font></td>
  </tr>
  <tr> 
    <td valign="middle" colspan="2" bgcolor="#FFCC33">&nbsp;</td>
  </tr>
  <tr> 
    <td valign="middle"><a href="mainpage_cmsteam.php" target="mainFrame"><img src="../images/new_b_general_home_ffcc33.gif" width="32" height="31" align="absmiddle" border="0"></a></td>
    <td valign="middle"><a href="mainpage_cms_team.php" target="mainFrame"><font face="ms sans serif" color="#000000" size="1"> 
      <b> <?php echo $HeadMenu; ?></b></font></a></td>
  </tr>
  <tr> 
    <td valign="middle"><a href="cms_password.php" target="mainFrame"><img src="../images/new_b_general_edit_ffcc33.gif" width="32" height="31" align="absmiddle" border="0"></a></td>
    <td valign="middle"><a href="cms_password.php" target="mainFrame"><font face="ms sans serif" color="#000000" size="1"> 
      <b> เปลี่ยนรหัสผ่าน</b></font></a></td>
  </tr>
  <tr> 
    <td valign="middle"><a href="logout2.php" target="_parent"><img src="../images/new_b_general_delete_ffcc33.gif" width="32" height="31" border="0"></a></td>
    <td valign="middle"><a href="logout2.php" target="_parent"><font face="ms sans serif" color="#000000" size="1"> 
      <b> <?php echo $tMainMenu6; ?></b></font></a></td>
  </tr>
  <tr> 
    <td height="10" colspan="2"> <div align="center"> 
        <form method="post" action="../lang_config.php">
          <select name="LangOption" onChange="this.form.submit();">
            <option value="thai" <?php if($LangVersion=="thai"){ ?> selected <?php } ?>>ภาษาไทย</option>
            <option value="english" <?php if($LangVersion=="english"){ ?> selected <?php } ?>>English</option>
          </select>
          <input type="hidden" name="FlagLang" value="TRUE">
          <input name="WebsiteChangeLang" type="hidden" id="WebsiteChangeLang" value="ContentMgt/cms_frameset.php">
        </form>
      </div></td>
  </tr>
</table>
<? } ?>
</body>
</html>
