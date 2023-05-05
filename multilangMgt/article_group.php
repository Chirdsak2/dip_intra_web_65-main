<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
if($_POST[flag]=='set_lang'){
	for($i=0;$i<$_POST[num];$i++){
		set_lang($_POST[c_id],$_POST[lang_name],$_POST[lang_field][$i],$_POST[lang_detail][$i],$module);
	}
	?>
      <script language="JavaScript">
		  alert('บันทึกข้อมูลเรียร้อย');
		  <?php if($_POST[c_parent]==0){ ?>
          location.href='../ContentMgt/article_group.php';
		  <?php }else{ ?>
		   location.href='../ContentMgt/article_list.php?cid=<?php echo $_POST[c_parent];?>';
		  <?php } ?>
     </script>
   <?php
   exit;
}
$sql = $db->db_fetch_array($db->query("select c_parent,c_name from article_group where c_id = '".$_GET[id]."'"));
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chk(){
	if(document.form1.lang_name.value == ""){
		alert("Please insert languang!!");
		document.form1.lang_name.focus();
		return false;
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="article_group.php" onSubmit="return chk();">
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle" /> <span class="ewtfunction">บริหารกลุ่มข่าว/บทความ</span> </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"> <?php if($sql[c_parent]==0){ ?><a href="../ContentMgt/article_group.php"><?php }else{ ?><a href="../ContentMgt/article_list.php?cid=<?php echo $sql[c_parent];?>"><?php } ?><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle" />กลับ</a> 
          <hr />
      </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><a href="javascript:void(0);" onClick="document.getElementById('nav').style.display='none';"></a></td>
      </tr>
    </table>
    <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#999999" class="ewttableuse">
  <tr>
    <th height="23" colspan="2" bgcolor="#FFFFFF" class="ewttablehead" scope="col"><div align="left">&bull;&nbsp;กรุณาใส่ภาษาตามที่ท่านเลือก(<?php echo $_GET[lang];?>)</div></th>
  </tr>
  <tr>
    <td width="29%" height="11" bgcolor="#FFFFFF"><?php echo $sql[c_name];?>  : <strong style="color:#FF0000">*</strong></td>
    <td width="71%" height="11" bgcolor="#FFFFFF"><input name="lang_detail[0]" type="text" size="50" value="<?php echo select_lang_detail($_GET[id],$_GET[langid],'c_name','article_group');?>"><input type="hidden" name="lang_field[0]" value="c_name"></td>
  </tr>
  <tr>
    <td height="12" bgcolor="#FFFFFF">Design Preview    : <strong style="color:#FF0000">*</strong></td>
    <td width="71%" height="12" bgcolor="#FFFFFF"><?php $sql_temp = $db->query("SELECT d_id,d_name,d_default FROM design_list,template_module where  template_module.tm_did = design_list.d_id");
						?>
                                <select name="lang_detail[1]">
								<option value="" <?php if($sql["d_id"] == ""){ echo "selected"; } ?>>Default</option>
                                  <?php while($T=$db->db_fetch_array($sql_temp)){ ?>
                                  <option value="<?php echo $T["d_id"]; ?>" <?php if($T["d_id"] == select_lang_detail($_GET[id],$_GET[langid],'d_id','article_group')){ echo "selected"; } ?>><?php echo $T["d_name"]; ?></option>
                                  <?php } ?>
            </select><input type="hidden" name="lang_field[1]" value="d_id"></td>
  </tr>
   <tr>
    <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="23" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="บันทึก">
      
      <input type="hidden" name="flag" value="set_lang">
	  <input type="hidden" name="num" value="2">
	   <input type="hidden" name="c_parent" value="<?php echo $sql[c_parent];?>">
      <input type="hidden" name="c_id" value="<?php echo $_GET[id]?>">
	  <!--<input type="hidden" name="lang_name" value="<?php//=$_GET[lang]?>">-->
	  <input type="hidden" name="lang_name" value="<?php echo $_GET[langid]?>">
	  <input type="hidden" name="module" value="article_group"></td>
  </tr>
</table></td>
  </tr>
</table>

</form>
</body>
</html>