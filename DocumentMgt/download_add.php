<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));

function LooPDel($p){
			$dir=@opendir($p);
			while($data=@readdir($dir))
			{
				if(($data!=".")and($data!="..")and($data!="")){
					if(!@unlink($p."/".$data))
						{
							LooPDel($p."/".$data);
						}	
				}
			}
		@closedir($dir);
		@rmdir($p);
}

if($_REQUEST[tempdir]!=""){
   LooPDel($_REQUEST[tempdir]);
}
include("lib_doc.php");
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
<script language="javascript" type="text/javascript" src="../js/function.js"></script>
<SCRIPT language=JavaScript src="../js/date-picker.js" type=text/javascript></SCRIPT>
<script language="JavaScript">
function ChkInput(c){
  /* if(c.dl_name.value==""){
       alert('กรุณากรอกชื่อ File');
	   c.dl_name.focus();
       return false;
   }else */ 
   if(c.dl_group.value=="0"){
   		alert('กรุณาเลือกกลุ่ม');
	   c.dl_group.focus();
       return false;
   }
   /*else if(document.myForm.dl_file.value==""){  
   		alert('กรุณาเลือกไฟล์'); 
       return false;
   }*/
}
</script>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="myForm" method="post" action="download_add_detail.php" enctype="multipart/form-data">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
        <span class="ewtfunction">เพิ่ม File</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ("เพิ่ม File ภายใต้กลุ่ม :"); ?><?php if($_GET["gid"] != ''){ echo current_group_level2($_GET["gid"]);}?>&module=document&url=<?php if($_GET["gid"] != ''){ echo urlencode  ( "download_add.php?gid=".$_GET["gid"]);}else{ echo urlencode  ( "download_add.php");}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="main_download_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
      <hr> </td>
  </tr>
</table>
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> เพิ่ม File </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">กลุ่ม <font color="#FF0000">*</font></td>
      <td width="62%"> 
		 <?php
	      		$sql = "SELECT * FROM docload_group  where dlg_id = '".$_GET[gid]."' ";
				$query=$db->query($sql);
				$data=$db->db_fetch_array($query);
				echo $data[dlg_name];   
				?></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">เลือกไฟล์ <font color="#FF0000">* <br/><?php
$rSizeLimit=$db->db_fetch_array($db->query('SELECT * FROM docload_setting LIMIT 1'));
echo '(จำกัดขนาดที่ '.($rSizeLimit['dls_filesize']/1024).' kb.)<br/>';
echo '(ประเภทไฟล์ที่อัพโหลดได้ '.$rSizeLimit['dls_ext'].'.)';
?></font> </td>
    <td width="62%">
	<table id="myTable" width="100%" border="0">
	      <tr> <td width="35%" height="30" bgcolor="F7F7F7"  >Upload File:</td>
			    <td width="23%"> <input name="dl_file[]" type="file" > </td>
			   <td  ><img src="../images/error1.gif" width="16" height="16"></td>
		  </tr>
		  <tr>
		    <td colspan="3"><a href="#add" onClick="AddRoom3('myTable');">
	<img src="../images/document_add.gif" width="24" height="24" border="0" align="absmiddle"> Upload more file...</a>&nbsp;</td>
		 </tr>
	  </table>	</td>
  </tr>

  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><?php //<input name="Replace" type="checkbox" id="Replace" value="Y"> Replace all if exists.<br> ?>
      <input type="submit" name="Submit2" value="Upload.." >
	<input name="flag" type="hidden"  value="add"> 
	<input name="gid" type="hidden"  value="<?php echo $_GET[gid];?>">
	<input name="dl_group" type="hidden"  value="<?php echo $_GET[gid];?>"> 
      <input type="reset" name="Submit3" value="ยกเลิก" onClick="location.href='download_list.php?gid=<?php echo $_GET[gid];?>';"></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>