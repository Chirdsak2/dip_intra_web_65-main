<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

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
									echo GenPic($i).'<input type="radio" name="vg_parent" value="'.$cat_id.'" ';
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
</head>
<script language="JavaScript">
function ChkInput(c){
   if(c.vdog_name.value==""){
       alert('กรุณากรอกชื่อกลุ่ม');
       return false;
   }
}
</script>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="myForm" method="post" action="virtualg_process.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">แก้ไขกลุ่ม virtual</span> </td>
  </tr>
</table>
<?php 
		$sql = "SELECT * FROM virtual_group  WHERE vg_id='$_GET[gid]'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("แก้ไขกลุ่ม virtual :".$data[vg_name]);?>&module=virtual&url=<?php echo urlencode("virtual_group_edit.php?gid=".$_GET["gid"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="virtual_list.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>  &nbsp; &nbsp;
      <a href="virtual_list.php?gid=<?php echo $data[vg_parent]?>" ><img src="../theme/main_theme/g_back.gif" alt="กลับ" width="16" height="16" border="0" align="absmiddle">ย้อนกลับ</a> 
      <hr> </td>
  </tr>
</table>

<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead">แก้ไขกลุ่ม virtual</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อกลุ่ม <font color="#FF0000">*</font></td>
    <td width="62%"><input name="vg_name" type="text" size="40" value="<?php echo $data[vg_name];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">กลุ่มหลัก</td>
    <td width="62%">
	 <?php 
        $t_parent=$data[vg_parent]*1;
        $t_subid=$_GET[gid];
   ?>
	<DIV style="HEIGHT: 200;OVERFLOW-Y: scroll;WIDTH: 100%;">
	         <input type="radio" name="vg_parent" value="0" <?php if($t_parent == "0"){ echo "checked"; } ?>>
			  <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">กลุ่ม Virtual<br>
			  <?php  showgroup(0,0,$t_subid,$t_parent,"");  ?>
	</DIV>
	</td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" onClick="return ChkInput(document.myForm)">
	  <input name="vg_id" type="hidden" value="<?php echo $data[vg_id];?>">
	  <input name="flag" type="hidden"  value="edit"> 
      <input type="reset" name="Submit3" value="ยกเลิก"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>