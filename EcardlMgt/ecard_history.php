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
if($_GET["f"] == "d"){ 
		$sql="SELECT * FROM ecard_history  INNER JOIN ecard_list ON  ec_id=ech_ecardid WHERE ech_id='$_GET[hid]' ";
		$query=$db->query($sql);
		$R = $db->db_fetch_array($query);
		 
		$db->query("DELETE  FROM ecard_history  WHERE ech_id = '$_GET[hid]' ");
		$db->write_log("delete","ecard","ลบประวัติ $R[ech_from] ส่งภาพ $R[ec_filename] ถึง $R[ech_to]");
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
      <span class="ewtfunction"><a href="virtual_list.php" >ประวัติการส่ง E-Card </a></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
<tr>    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ประวัติการส่ง E-Card");?>&module=ecard&url=<?php echo urlencode("ecard_history.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<hr></td>  </tr>
</table>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="15%" height="30" align="center">วันที่</td>
      <td width="20%" >รายการ</td>
      <td width="20%"  align="center">ผู้ส่ง</td>
      <td width="20%"  align="center">ผู้รับ</td>
      <td width="10%"  align="center">สถานะผู้รับ</td>
      <td width="5%" align="center">Delete</td>
  </tr>
  <?php 
 if (!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/ecard")) {
    mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/ecard", 0777);
} 

//$dir = @opendir("../ewt/".$_SESSION["EWT_SUSER"]."/ecard/");
$sql="SELECT * FROM ecard_history  INNER JOIN ecard_list ON  ec_id=ech_ecardid ORDER BY ech_id DESC";
$query=$db->query($sql);
  		 while($R = $db->db_fetch_array($query)){
		 $file=$R[ec_filename];
		 $fileID=$R[ec_id];
		 $hisID=$R[ech_id];
		 
		 //$send_date=$R[ech_datetime];
		 $y=substr($R[ech_datetime],0,4);
		 $m=substr($R[ech_datetime],4,2);
		 $d=substr($R[ech_datetime],6,2);
		 $h=substr($R[ech_datetime],8,2);
		 $i=substr($R[ech_datetime],10,2);
		 $s=substr($R[ech_datetime],12,2);
		 $send_date=$d.'/'.$m.'/'.$y.' ('.$h.':'.$i.':'.$s.')';
		 $send_from=$R[ech_from];
		 $send_to=$R[ech_to];
		 if($R[ech_status]=='Y'){
		     $history_status="อ่านแล้ว";
		}else{
		     $history_status="ยังไม่ได้อ่าน";
		}
  		 //while (($file = readdir($dir)) !== false) { 
		 //if($file != "." AND $file != ".."){
		 	//$exp = explode(".",$file);
			//$exp[1] = strtolower($exp[1]);
		 ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><nobr><?php echo $send_date; ?></nobr></td>
				<td><?php
				//if($exp[1] != "swf"){
				if($R[ec_fileext] != "swf"){ ?>
				     <img src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/phpThumb.php?src=ecard/<?php echo $file; ?>&h=50&w=50" >
				<?php }else{ ?>
				  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" height="50">
                    <param name="movie" value="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ecard/<?php echo $file; ?>">
                    <param name="quality" value="high">
                    <embed src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ecard/<?php echo $file; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="50" height="50"></embed>
		        </object><?php } ?></td>
				<td align="left" valign="top"><?php echo $send_from; ?></td>
				<td align="left" valign="top"><?php echo $send_to; ?></td>
				<td align="center" valign="top"  ><?php echo $history_status; ?></td>
				<td align="center">
				<input type="submit" name="Button" value="Delete" onClick="if(confirm('คุณแน่ใจที่จะลบประวัตินี้หรือไม่?')){ self.location.href='ecard_history.php?f=d&hid=<?php echo $hisID; ?>'; }"></td>
			  </tr>
  <?php
         $i++;
		 //}
		 }
		 	if($db->db_num_rows($query) == 0){  ?>
			  <tr bgcolor="#FFFFFF"><td colspan="6" align="center"> <strong>ไม่พบข้อมูล</strong> </td></tr>
			<?php }
		  //closedir($dir);
		  ?>
</table>
<br><br>
</body>
</html>
<?php
$db->db_close(); ?>