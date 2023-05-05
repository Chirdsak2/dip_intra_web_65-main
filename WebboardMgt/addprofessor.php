<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
if($_GET["id"]==''){
$flag = 'add';
$lable = 'เพิ่ม';
}else{
$flag = 'edit';
$lable = 'แก้ไข';
}

 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../js/function.js"></script>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="myForm" enctype="multipart/form-data" method="post" action="professor_function.php"   onSubmit="return CHK(this);">
	<input name="id" type="hidden" value="<?php echo $_GET["id"];?>">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $lable;?>ผู้เชี่ยวชาญ</span></td>
  </tr>
</table><?php
					$sql = "select * from professor where  professor.prof_id = '".$_GET["id"]."'";
					$query = $db->query($sql);
					$rec = $db->db_fetch_array($query);
					$db->query("USE ".$EWT_DB_USER);
					$sql_user = "select * from gen_user where gen_user_id = '".$rec[prof_name]."'";
					$query_user = $db->query($sql_user);
					$num_user = $db->db_num_rows($query_user);
					$rec_user = $db->db_fetch_array($query_user);
					$db->query("USE ".$EWT_DB_NAME);
					$name =$rec_user[name_thai].'  '.$rec_user[surname_thai];
					?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable."ผู้เชี่ยวชาญ".$name);?>&module=webboard&url=<?php echo urlencode("addprofessor.php?id=".$_GET["id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="professor_list.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> 
     หน้าหลัก</a>
        <hr>
    </td>
  </tr>
</table>
                  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#7D7E99" class="ewttableuse">
<tr align="center" class="ewttablehead" > 
                      <td height="25" colspan="2" class="head_font"><?php echo $lable;?>ผู้เชี่ยวชาญ</td>
                    </tr>
					
                    <tr bgcolor="#FFFFFF"> 
                      <td width="20%">ชื่อผู้เชี่ยวชาญ<font color="#FF0000"> * </font></td>
                      <td width="80%"><input name="name" type="text" readonly="" class="normaltxt" id="name" size="60" value="<?php echo $name ;?>">
					  <a href="#" onClick="popo=window.open('site_s_professor.php','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();"><img src="../images/user_pos.gif" alt="เพิ่มผุ้เชี่ยวชาญจากสมาชิกในระบบ" width="20" height="20" border="0"> 
					<input type="hidden" name="hdd_uid" id="hdd_uid" value="<?php echo $rec[prof_name];?>">
					</a></td>
                    </tr>
					<?php
					$sql = "select * from professor_keyword where prof_id = '".$_GET["id"]."'";
					$query = $db->query($sql);
					while($rec = $db->db_fetch_array($query)){
					$key .=$rec[key_word]."  ";
					}
					?>
                    <tr bgcolor="#FFFFFF"> 
                      <td>Keyword <font color="#FF0000"> * </font></td>
                      <td>
                        <textarea name="keyword" cols="60" rows="5"><?php echo $key;?></textarea><br>
                        <font color="#FF0000"> (กรณีที่มีมากกว่า 1 Keyword ให้ใช้การ "วรรค" เป็นการคั่นระหว่างคำ ตัวอย่างเช่น การวิเคราะห์นโยบายและแผน ซากดึกดำบรรพ์จุลภาค เป็นต้น)</font>					  </td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td>&nbsp;</td>
                      <td><input type="submit" name="Submit" value="Submit" class="normaltxt"> 
                        <input type="reset" name="Submit2" value="Reset" class="normaltxt"> 
                        <input name="flag" type="hidden" id="flag" value="<?php echo $flag;?>">                      </td>
                    </tr>
  </table>
</form>
</body>
</html>
<script language="JavaScript">
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
}
function validEMail(mailObj){
		if (validLength(mailObj.value,1,50)){
			if (mailObj.value.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
				return true;
			else return false;
 		}
		return true;
}
function CHK(){
if(document.myForm.name.value == ""){
alert("กรุณาใส่ชื่อผู้เชี่ยวชาญ");
document.myForm.name.focus();
return false;
}
if(document.myForm.keyword.value == ""){
alert("กรุณาใส่ Keyword");
document.myForm.keyword.focus();
return false;
}

}
</script>
<?php @$db->db_close(); ?>