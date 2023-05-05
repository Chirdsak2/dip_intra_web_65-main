<?php
//include("administrator.php");
include("lib/include.php");
//include("inc.php");
include("../language/dict_language.php");
$dict_id=$_GET[dict_id];
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
<?php include("../FavoritesMgt/favorites_include.php");?>
<div align="center">
<form name="form1" method="post" action="dict_function.php" onSubmit="return CHK()">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rude_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_gendict_function;?></span> </td>
  </tr>
</table>
			<?php
				$db->query("USE ".$EWT_DB_USER);
				$sel = "SELECT * FROM dictionary  WHERE DICT_ID = '$dict_id' "; //echo  $sel;
				$ExecSel = $db->query($sel);
                $rows = $db->db_num_rows($ExecSel);
				$rec = $db->db_fetch_array($ExecSel);
				?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php if($flag=='edit'){echo urldecode ( $text_gendict_formedit); }else{ echo urldecode (  $text_gendict_formadd);}?><?php echo urldecode ( $rec['DICT_WORD']);?>&module=dictionary&url=<?php if($flag=='edit'){echo urldecode ( 'dict_addedit.php?dict_id='.$dict_id); }else{ echo urldecode ( 'dict_addedit.php?flag=add');}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="dict_addedit.php?flag=add" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0">
      <?php echo $text_gendict_addnew;?></a> &nbsp;&nbsp;&nbsp;<a href="dict_cate.php" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php echo $text_gendict_manage;?></a>
      <hr>
    </td>
  </tr>
</table>
  <table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top">
				
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B74900" class="ewttableuse">
            <tr align="left" bgcolor="#FFCC66"> 
                      <td height="30" colspan="2" class="ewttablehead">&nbsp;&nbsp;<?php if($flag=='edit'){echo $text_gendict_formedit; }else{ echo $text_gendict_formadd;}?></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td width="11%" nowrap><?php echo $text_gendict_formtype0;?><font color="#FF0000">*</font></td>
                      <td width="89%"><input name="DICT_WORD" type="text" class="normaltxt" id="DICT_WORD" size="60" value="<?php echo $rec['DICT_WORD'];?>">                      </td>
                  </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td width="11%" nowrap><?php echo $text_gendict_formtype1;?><font color="#FF0000"></font></td>
                      <td width="89%"><input name="DICT_SEARCH" type="text" class="normaltxt" id="DICT_SEARCH" size="60" value="<?php echo $rec['DICT_SEARCH'];?>"> 
					  <br><font color="#FF0000">* หมายเหตุ : หากมีคำคล้ายมากกว่า 1 คำ กรุณาใส่เครื่องหมาย (,) ระหว่างคำ<br>
                       ตัวอย่าง : คำคล้ายที่1,คำคล้ายที่2</font>
</td>
                  </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td width="11%" nowrap><?php echo $text_gendict_formtype2;?><font color="#FF0000"></font></td>
                      <td width="89%"><input name="DICT_SYNONYM" type="text" class="normaltxt" id="DICT_SYNONYM" size="60" value="<?php echo $rec['DICT_SYNONYM'];?>">
					  <br><font color="#FF0000">* หมายเหตุ : หากมีคำตรงข้ามมากกว่า 1 คำ กรุณาใส่เครื่องหมาย (,) ระหว่างคำ<br>
                       ตัวอย่าง : คำตรงข้ามที่,คำตรงข้ามที่2</font></td>
                  </tr>
                    
                    <tr bgcolor="#FFFFFF"> 
                      <td>&nbsp;</td>
                      <td>
					  	<input type="submit" name="Submit" value="<?php echo $text_gendict_formsubmit;?>" class="normaltxt"> 
                        <input type="button" name="Reset" value="<?php echo $text_gendict_formreset;?>" class="normaltxt" > 
                        <input  type="hidden" id="flag" name="flag" value="<?php echo $flag?>"> 
                        <input  type="hidden" id="dict_id" name="dict_id" value="<?php echo $dict_id?>">                      </td>
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
	if(document.form1.DICT_WORD.value == ""){
		alert("กรุณาใส่คำใกล้เคียง");
		document.form1.DICT_WORD.focus();
		return false;
	}
	return true;
}
</script>
<?php $db->db_close(); ?>
