<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "Up"){
    //echo $_FILES[file][name].'<br>';
	//echo $_FILES[file][tmp_name].'<br>';
	//echo $_FILES[file][size].'<br>';
	
    $file_name=$_FILES[file][name];
	$exp = explode(".",$file_name);
	$exp[1] = strtolower($exp[1]);
	if($exp[1] == "jpg" OR $exp[1] == "jpeg" OR $exp[1] == "gif" OR $exp[1] == "png" OR $exp[1] == "swf" ){
	     $myfile = date('YmdHis').'_'.rand(0,999).'.'.$exp[1];
         copy($_FILES[file][tmp_name],"../ewt/".$_SESSION["EWT_SUSER"]."/ecard/".$myfile);
		 $filesize=$_FILES[file][size];
         $filetype=$_FILES[file][type];
		 $fileext=$exp[1]; 
		 $db->query("INSERT INTO ecard_list(ec_name,ec_filename,ec_filesize,ec_filetype,ec_fileext) VALUES('$file_name','$myfile','$filesize','$filetype','$fileext') ");
		 
	 ?><script language="javascript">location.href='ecard_list.php';</script><?php
	 	/*
    $file_name=$_POST[file_name];
	$exp = explode(".",$file_name);
	$exp[1] = strtolower($exp[1]);
	if($exp[1] == "jpg" OR $exp[1] == "jpeg" OR $exp[1] == "gif" OR $exp[1] == "png" OR $exp[1] == "swf" ){
		$myfile = eregi_replace(" ","",$file_name);
		//copy($file,"../ewt/".$_SESSION["EWT_SUSER"]."/ecard/".$myfile);*/
	}else{
		?>
		<script type="text/javascript">
		alert("นามสกุลไฟล์ไม่ถูกต้อง\n(เฉพาะ นามสกุล jpg,jpeg,gif,png,swf เท่านั้น)");	
		</script>
		<?php
	}
}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function ChkInput(c){
   if(c.ecard_name.value==""){
       alert('กรุณากรอกชื่อ E-Card');
	   c.ecard_name.focus();
       return false;
   }else if(c.file.value=="0"){
   		alert('กรุณาเลือกภาพ E-Card');
	   //c.file.focus();
       return false;
   }
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/virtual_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><a href="virtual_list.php" >ข้อมูล E-Card </a></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr> 
      <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("เพิ่มข้อมูล E-Card");?>&module=ecard&url=<?php echo urlencode("ecard_add.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="ecard_add.php" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> เพิ่ม E-Card</a>  &nbsp; <a href="ecard_list.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
	  <hr></td>
  </tr>
</table>

<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
<form action="ecard_list.php" method="post" enctype="multipart/form-data" name="myForm">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> เพิ่ม E-Card </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อ E-Card <font color="#FF0000">*</font></td>
    <td width="62%"><input name="ecard_name" type="text" size="40"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ภาพ E-Card <font color="#FF0000">*</font></td>
    <td width="62%"><input name="Flag" type="hidden" id="Flag" value="Up"><input type="file" name="file"></td>
  </tr>
  
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%"></td>
    <td width="62%"><input type="submit" name="Submit" value="บันทึก" onClick="return ChkInput(document.myForm)"> <input type="reset" value="ยกเลิก"></td>
  </tr>
  </form>
  </table><br><br>
</body>
</html>
<?php
$db->db_close(); ?>