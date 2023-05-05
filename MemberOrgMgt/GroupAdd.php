<?php
header ("Content-Type:text/plain;charset=UTF-8"); 
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["flag"] != ''){
	if($_POST["flag"] == 'add'){
		$sql_chk  = "select * from emp_type where emp_type_name ='$group_name' and emp_type_status ='4'";
		$query = $db->query($sql_chk);
		if($db->db_num_rows($query)==0){
			$insert="insert into  emp_type (emp_type_date,emp_type_name,emp_type_status ) 
												   values(NOW(),'$group_name','4')";	
			 $db->query($insert);
			 $db->query("USE ".$_SESSION["EWT_SDB"]);
			 $db->write_log("create","member","เพิ่มกลุ่มบุคคลภายนอก : ".$_POST['group_name']);
			 $db->query("USE ".$EWT_DB_USER);
			 echo "<script language=\"javascript\">";
			echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='GroupList.php'" ;
			echo "</script>";
		 }else{
			 echo "<script language=\"javascript\">";
			echo "alert('กลุ่มนี้มีอยู่แล้ว ท่านไม่สามารถบันทึกได้ กรุณาตรวจสอบ!!!!!');";
			echo "document.location.href='GroupList.php'" ;
			echo "</script>";
		 }
	}else{
		$sql_chk  = "select * from emp_type where emp_type_name ='$group_name' and emp_type_id <> '$group_id'";
		$query = $db->query($sql_chk);
		if($db->db_num_rows($query)==0){
			$update="update emp_type set  emp_type_date=NOW(),
																 emp_type_name='$group_name',
																 emp_type_status='4'
									Where emp_type_id = '$group_id' ";
			$db->query($update);
			$db->query("USE ".$_SESSION["EWT_SDB"]);
			$db->write_log("update","member","แก้ไขกลุ่มบุคคลภายนอก : ".$_POST['group_name']);
			$db->query("USE ".$EWT_DB_USER);
			echo "<script language=\"javascript\">";
			echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='GroupList.php'" ;
			echo "</script>";
		}else{
			 echo "<script language=\"javascript\">";
			echo "alert('กลุ่มนี้มีอยู่แล้ว ท่านไม่สามารถบันทึกได้ กรุณาตรวจสอบ!!!!!');";
			echo "document.location.href='GroupList.php'" ;
			echo "</script>";
		}
	}
	
}
if($_GET["cmd"] == 'add'){
$lable = 'เพิ่ม';
}else{
$lable = 'แก้ไข';
}
$select_main="SELECT  * FROM  `emp_type` Where  emp_type_id='$group_id' ";
	$exec_main = $db->query($select_main);
	$rst_main = $db->db_fetch_array($exec_main);
			
	$group_name=$rst_main[emp_type_name];

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><?php echo $lable;?>กลุ่มสมาชิก</span> </td>
  </tr>
</table>
<?php
if($_GET["cmd"]=='edit'){
$link = "&group_id=".$_GET["group_id"];
}
?>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable."กลุ่มสมาชิก".$group_name);?>&module=member&url=<?php echo urlencode("GroupAdd.php?cmd=".$_GET["cmd"].$link);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; <a href="GroupList.php"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> 
      กลับ</a>
    <hr> </td>
  </tr>
</table>

                <form name="frm" method="post" action="" onSubmit="return CHK(this);">
                <table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" style="border-collapse:collapse">
                    <tr class="ewttablehead">
                      <td height="20" colspan="2" >ข้อมูลกลุ่มบุคคลภายนอก</td>
                    </tr>
                    <tr>
                      <td width="31%" bgcolor="#FFFFFF">ชื่อกลุ่ม : <font color="#FF0000">*</font></td>
                      <td width="69%" bgcolor="#FFFFFF"><input name="group_name" type="text" value="<?php echo $group_name;?>" size="30"></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center" bgcolor="#FFFFFF" ><input name="save" type="submit" class="submit" style="width:80"  value="บันทึก" />
                        <input type="hidden" name="flag" value="<?php echo $cmd;?>"/>
					  <input type="hidden" name="group_id" value="<?php echo $group_id;?>"/></td>
                    </tr>
                </table>
              </form>
              </body>
</html>
<script language="javascript">
 function isNum (charCode) 
   {
       if (charCode >= 48 && charCode <= 57 )
	       return true;
      else
	     return false;
   }
 function chkFormatNam (str) {//0-9
  strlen = str.length;
  for (i=0;i<strlen;i++)
  {
      var charCode = str.charCodeAt(i);
	  if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
		  return false;
	  }
   }
   return true;
}
function chkformatnum(t){ 
		_MyObj = t;
		_MyObj_Name = t.name;
		_MyObj_Value = t.value;
		_MyObj_Strlen =_MyObj_Value.length; 
		if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
			t.value = _MyObj_Value.substr(1);
		}
		if(!chkFormatNam (t.value)){
				alert('กรุณากรอกจำนวนเงินด้วยตัวเลขเท่านั้น');
				t.value = 0;
				t.focus();
	} 
}
function CHK(t){
if(t.group_name.value == ''){
alert('กรุณากรอกชื่อกลุ่ม');
return false;
}
return true;
}
</script>
<?php
$db->db_close(); ?>