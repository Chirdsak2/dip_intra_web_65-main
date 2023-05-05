<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));

function GenPic($data){
	for($i=0;$i<=$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}

function showgroup($start,$i,$id,$idp,$dis){
			global $db;
			$x = $i+1;
			$sql_show = $db->query("SELECT * FROM virtual_group WHERE vg_parent = '".$start."' ");
			if($db->db_num_rows($sql_show)){
							while($R = $db->db_fetch_array($sql_show)){
								   $cat_id=$R[vg_id];
								   $cat_name=$R["vg_name"];
									echo GenPic($i).'<input type="radio" name="vg_id" value="'.$cat_id.'" ';
									if($id == $cat_id){
										echo ' disabled ';
									}
									if($dis == "Y"){ 
										echo ' disabled '; 	
									}
									if($id == $cat_id OR $dis == "Y"){
										$dis1 = "Y";
									}else{
										$dis1 = "";
									}
									if($idp == $cat_id){
										echo ' checked ';
									}
									echo '><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"> '.$cat_name."<br>";
									showgroup($cat_id,$x,$id,$idp,$dis1);
							}
			}
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<script language="JavaScript">
function ChkInput(c){
   if(c.v_name.value==""){
       alert('กรุณากรอกชื่อ virtual');
	   c.v_name.focus();
       return false;
   }
}
</script>
<body leftmargin="0" topmargin="0">
<form name="myForm" method="post" action="virtual_process.php" enctype="multipart/form-data">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
        <span class="ewtfunction">แก้ไข virtual</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="main_virtual_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>&nbsp; &nbsp; 
	<a href="virtual_list.php?gid=<?php echo $_GET[gid]?>" ><img src="../theme/main_theme/g_back.gif" alt="กลับ" width="16" height="16" border="0" align="absmiddle">ย้อนกลับ</a>
      <hr> </td>
  </tr>
</table>
<?php 
		$sql = "SELECT * FROM virtual_list  WHERE v_id='$_GET[vid]'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> แก้ไข virtual</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อ virtual <font color="#FF0000">*</font></td>
    <td width="62%"><input name="v_name" type="text" size="40" value="<?php echo $data[v_name];?>"></td>
  </tr>
  
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">กลุ่ม virtual</td>
    <td width="62%">		
		 <?php 
        $t_parent=$data[vg_id]*1;
        $t_subid=0;
   ?>
	<DIV style="HEIGHT: 200;OVERFLOW-Y: scroll;WIDTH: 100%;">
			  <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">กลุ่ม Virtual<br>
			  <?php  showgroup(0,0,$t_subid,$t_parent,"");  ?>
	</DIV>
	</td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" onClick="return ChkInput(document.myForm)">
	<input name="flag" type="hidden"  value="edit"> 
	<input name="gid" type="hidden"  value="<?php echo $data[vg_id];?>"> 
	<input name="v_id" type="hidden"  value="<?php echo $_GET[vid];?>"> 
     <input type="reset" name="Submit3" value="ยกเลิก" ></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>