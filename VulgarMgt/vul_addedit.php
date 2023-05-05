<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/rude_language.php");
$vulgar_id=$_GET[vulgar_id];
$flag=$_GET[flag];
if($flag != 'add'){
$flag =  'edit';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="form1" method="post" action="vul_function.php" onSubmit="return CHK()">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rude_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genrude_function;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php if($flag=='edit'){echo urlencode ($text_genrude_formedit); }else{ echo urlencode ($text_genrude_formadd);}?>&module=vulgar&url=<?php if($flag=='edit'){echo urlencode  ( 'vul_addedit.php?vulgar_id='.$vulgar_id); }else{ echo urlencode  ( 'vul_addedit.php?flag=add');}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="vul_addedit.php?flag=add" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0">
      <?php echo $text_genrude_addnew;?></a> &nbsp;&nbsp;&nbsp;<a href="vul_cate.php" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php echo $text_genrude_manage;?></a>
      <hr>
    </td>
  </tr>
</table>
  <table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top">
				<?php
				$sel = "SELECT * FROM vulgar_table  WHERE vulgar_id = '$vulgar_id' "; //echo  $sel;
				$ExecSel = mysql_query($sel);
                $rows = mysql_num_rows($ExecSel);
				$rec = mysql_fetch_array($ExecSel);
				?>
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B74900" class="ewttableuse">
            <tr align="left" bgcolor="#FFCC66"> 
                      <td height="30" colspan="2" class="ewttablehead">&nbsp;&nbsp;<?php if($flag=='edit'){echo $text_genrude_formedit; }else{ echo $text_genrude_formadd;}?></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td width="11%" nowrap><?php echo $text_genrude_formtitle;?><font color="#FF0000">*</font></td>
                      <td width="89%"><input name="t_topic" type="text" class="normaltxt" id="t_topic" size="60" value="<?php echo $rec['vulgar_text'];?>">                      </td>
                  </tr>
                    <tr bgcolor="#FFFFFF">
                      <td width="11%"><?php echo $text_genrude_formtype0;?></td>
                      <td><input name="r" type="radio" id="r_1" value="1" checked  <?php if($rec[ip_add]==1)echo "checked";?>>
                      <?php echo $text_genrude_formtype1;?>
                      <input name="r"  id='r_2' type="radio" value="2"    <?php if($rec[ip_add]==2)echo "checked";?>>
                      <span class="head_font"><?php echo $text_genrude_formtype2;?></span></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td>&nbsp;</td>
                      <td>
					  	<input type="submit" name="Submit" value="<?php echo $text_genrude_formsubmit;?>" class="normaltxt"> 
                        <input type="button" name="Reset" value="<?php echo $text_genrude_formreset;?>" class="normaltxt" > 
                        <input  type="hidden" id="flag" name="flag" value="<?php echo $flag?>"> 
                        <input  type="hidden" id="vulgar_id" name="vulgar_id" value="<?php echo $vulgar_id?>">                      </td>
                    </tr>
                </table>
        </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
  </form>
</div>
</body>
</html>
<script language="JavaScript">
function CHK(){
	if(document.form1.t_topic.value == ""){
		alert("กรุณาใส่คำไม่สุภาพ");
		document.form1.t_topic.focus();
		return false;
	}
	return true;
}
</script>
<?php $db->db_close(); ?>
