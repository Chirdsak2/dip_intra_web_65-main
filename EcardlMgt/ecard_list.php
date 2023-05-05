<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_GET["f"] == "d"){ 
		$sql="SELECT * FROM ecard_list WHERE ec_id = '$_GET[fid]' ";
		$query=$db->query($sql);
		if($db->db_num_rows($query) > 0){ 
				$R = $db->db_fetch_array($query);
				if(unlink("../ewt/".$_SESSION["EWT_SUSER"]."/ecard/".$R[ec_filename])){
					$db->query("DELETE  FROM ecard_list  WHERE ec_id = '$_GET[fid]' ");
				} 
		        $db->write_log("delete","ecard","ลบภาพ $R[ec_filename] ");
		}
}


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
    <td><img src="../theme/main_theme/virtual_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><a href="virtual_list.php" >ข้อมูล E-Card </a></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
   <tr> 
      <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ข้อมูล E-Card ");?>&module=ecard&url=<?php echo urlencode("ecard_list.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
	  <a href="ecard_add.php" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> เพิ่ม E-Card</a><hr>
     </td>
  </tr>
</table>


<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">ส่ง</td>
      <td width="20%" >รายการ</td>
      <td width="70%">รายละเอียด</td>
      <td width="5%" align="center">Delete</td>
  </tr>
  <?php 
 if (!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/ecard")) {
    mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/ecard", 0777);
} 

//$dir = @opendir("../ewt/".$_SESSION["EWT_SUSER"]."/ecard/");
$sql="SELECT * FROM ecard_list";
$query=$db->query($sql);
  		 while($R = $db->db_fetch_array($query)){
		 $file=$R[ec_filename];
		 $fileID=$R[ec_id];
  		 //while (($file = readdir($dir)) !== false) { 
		 //if($file != "." AND $file != ".."){
		 	//$exp = explode(".",$file);
			//$exp[1] = strtolower($exp[1]);
		 ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><nobr><a href="ecard_send.php?fid=<?php echo $fileID; ?>" ><img src="../theme/main_theme/bullet.gif" width="16" height="16" alt="ส่ง E-Card" border="0"></a> </nobr></td>
				<td><?php
				//if($exp[1] != "swf"){
				if($R[ec_fileext] != "swf"){ ?>
				     <img src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/phpThumb.php?src=ecard/<?php echo $file; ?>&h=150&w=150" >
				<?php }else{ ?>
				  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="150" height="150">
                    <param name="movie" value="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ecard/<?php echo $file; ?>">
                    <param name="quality" value="high">
                    <embed src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ecard/<?php echo $file; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="150" height="150"></embed>
		        </object><?php } ?></td>
				<td align="left" valign="top">
				ชื่อภาพ : <?php echo $R[ec_name];?><br>
                 ชื่อไฟล์ : <?php echo $R[ec_filename];?><br>
                 ชนิดไฟล์ : <?php echo $R[ec_filetype];?><br>
                  ขนาดไฟล์ : <?php echo number_format($R[ec_filesize]/1024,2);?> KB.
				</td>
				<td align="center">
				<input type="submit" name="Button" value="Delete" onClick="if(confirm('คุณแน่ใจที่จะลบ E-Card นี้หรือไม่?')){ self.location.href='ecard_list.php?f=d&fid=<?php echo $fileID; ?>'; }"></td>
			  </tr>
  <?php
         $i++;
		 //}
		 }
		 	if($db->db_num_rows($query) == 0){  ?>
			  <tr bgcolor="#FFFFFF"><td colspan="4" align="center"> <strong>ไม่พบข้อมูล</strong> </td></tr>
			<?php }
		  //closedir($dir);
		  ?>
</table>
<br><br>
</body>
</html>
<?php
$db->db_close(); ?>