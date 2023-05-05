<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
//$sql_chk = $db->db_fetch_array($db->query("select site_info_max_file from site_info"));
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<script language="javascript" type="text/javascript" src="../js/function.js"></script>
<SCRIPT language=JavaScript src="../js/date-picker.js" type=text/javascript></SCRIPT>
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
   if(c.dl_name.value==""){
       alert('กรุณากรอกชื่อ File');
	   c.dl_name.focus();
       return false;
   }else if(c.dl_group.value=="0"){
   		alert('กรุณาเลือกกลุ่ม');
	   c.dl_group.focus();
       return false;
   }else if(document.myForm.dl_file.value==""){  
   		alert('กรุณาเลือกไฟล์'); 
       return false;
   }
}

function ifclick(c,num){
   if(c.checked==true){
	   document.getElementById('rep'+num).value='Y';
   }else{
       document.getElementById('rep'+num).value='' ;
   }
}
</script>
<body leftmargin="0" topmargin="0">
<form name="myForm" method="post" action="download_process.php" enctype="multipart/form-data">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
        <span class="ewtfunction">เพิ่ม File</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="main_download_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
      <hr> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> เพิ่ม File </td>
  </tr>
  
<?php
$gid = $_POST[gid];
$Replace = $_POST[Replace];

$tmp_folder="tmp_".date('YmdHis');
$Current_Temp = "temp/".$tmp_folder;
if (!(file_exists($Current_Temp))) {
  @mkdir($Current_Temp, 0755);
}

$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download_doc";
if (!(file_exists($Current_Dir))) {
  @mkdir($Current_Dir, 0755);
}
$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/download_doc/dl_$gid";
if (!(file_exists($Current_Dir))) {
  @mkdir($Current_Dir, 0755);
}

$sql = "SELECT * FROM docload_setting";
$query=$db->query($sql);
$data=$db->db_fetch_array($query);

//$file_types = array('jpg','swf','flv','mp3','wmv','rar','zip');
$file_ext =  $data[dls_ext];
$file_type = explode(',',$file_ext);
 $rowsfile = count($_FILES["dl_file"]["tmp_name"]);
//$size_max= $rec[site_info_max_file];
$size_max=$data[dls_filesize];  //Byte
$size_max2=$data[dls_filesize]/1024;  //Byte
$pass=0;
$count_file=0;
 for($i=0;$i<$rowsfile;$i++){
			if($_FILES['dl_file']['size'][$i] > 0){
			           $count_file++;
			           $F = explode(".",$_FILES["dl_file"]["name"][$i]);
					   $C = count($F);
				       $CT = $C-1;
				       $extension = strtolower($F[$CT]);
			$alert='';
			$alert2='';
						if($_FILES['dl_file']['size'][$i] > $size_max){
						      //$alert="Can not upload ".$_FILES["dl_file"]["name"][$i]."!<br>";
						      //$alert2=" - File size over $size_max2 KB.<br>";
							   $alert="ไม่สามารถนำเข้าไฟล์ [".$_FILES["dl_file"]["name"][$i]."]<br>";
						       $alert2=" - ไฟล์มีขนาดใหญ่เกินกำหนด $size_max2 KB.<br>";
								/*?> <script language="JavaScript">
									alert("Can not upload \"<?php echo $_FILES["dl_file"]["name"][$i]; ?>\"!! File size over <?php echo $size_max; ?> KB.");
								</script><?php*/
						}else if(!in_array($extension,$file_type)){
						     //$alert="Can not upload ".$_FILES["dl_file"]["name"][$i]."!<br>";
							 //$alert2=" - File extension (.$extension) is not allow.<br>";
							 $alert="ไม่สามารถนำเข้าไฟล์ [".$_FILES["dl_file"]["name"][$i]."]<br>";
							 $alert2=" - ประเภทของไฟล์ (.$extension) ไม่อนุญาติให้นำเข้า<br>";
						     /*  ?> <script language="JavaScript">
									alert("Can not upload \"<?php echo $_FILES["dl_file"]["name"][$i]; ?>\"!! File extension (<?php echo $extension; ?>) is not allow.");
								</script><?php */
						}else{
						   $pass=$pass+1;
							if (file_exists($Current_Dir."/".$_FILES["dl_file"]["name"][$i]) AND $_POST["Replace"] != "Y") {
								 //$alert="Can not upload ".$_FILES["dl_file"]["name"][$i]."!<br>";
								 $alert="ตรวจพบไฟล์นี้มีในระบบ!<br>";
								 $alert.='<input  type="checkbox" value="Y" onclick="ifclick(this,'.$i.')"> อนุญาตให้ทับไฟล์เดิม';
								 //$alert2=" - File exists.<br>";
								/* ?> <script language="JavaScript">
								   alert("Can not upload \"<?php echo $_FILES["dl_file"]["name"][$i]; ?>\"!!File exists. ");
								</script> <?php */
							}else{ 
								   //copy($_FILES["dl_file"]["tmp_name"][$i],$Current_Dir."/".$_FILES["dl_file"]["name"][$i]);
								  //@chmod ($Current_Dir."/".$_FILES["dl_file"]["name"][$i], 0755);
								  //$nfile = $nf0.$_FILES["dl_file"]["name"][$i];
								  //$n++;
								  //$db->write_log("create","uplodefile","สร้าง File   ".$_FILES["dl_file"]["name"][$i]);
								  //$pass=$pass+1;
								  //if (file_exists($Current_Dir."/".$_FILES["dl_file"]["name"][$i])) {
								     //$alert="File has relpaced by ".$_FILES["dl_file"]["name"][$i]."[".number_format($_FILES["dl_file"]["size"][$i]/1024,3)." Kb]<br>";
								  //}
							}
							 copy($_FILES["dl_file"]["tmp_name"][$i],$Current_Temp."/".$_FILES["dl_file"]["name"][$i]);
							@chmod ($Current_Temp."/".$_FILES["dl_file"]["name"][$i], 0755);
						}
			
?>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%"><?php echo $_FILES["dl_file"]["name"][$i]; ?>  ขนาดไฟล์ (<?php echo number_format($_FILES["dl_file"]["size"][$i]/1024,1); ?> Kb)<br>
       
      <br><font color="#FF0000"><?php echo $alert.$alert2;?></font></td>
      <td width="62%">
	  <?php
	   $sql_search="SELECT dl_detail FROM docload_list   WHERE dl_name= '".$_FILES["dl_file"]["name"][$i]."'  and  dl_dlgid = '$gid'   ";
	   $query=$db->query($sql_search);
	   $data=$db->db_fetch_array($query);
	   
	   if($alert2==''){?>
	  รายละเอียด :<br>
	  <textarea name="dl_details[]" cols="60" rows="4"><?php echo $data[dl_detail]; ?></textarea>
	  <input type="hidden" name="dl_filename[]" value="<?php echo $_FILES["dl_file"]["name"][$i]; ?>" >
	  <input type="hidden" name="dl_filesize[]" value="<?php echo $_FILES["dl_file"]["size"][$i]; ?>" >
	  <input type="hidden" name="file_replace[]"  id="rep<?php echo $i;?>" value="" >
	  <?php } ?>
	  </td>
  </tr>
<?php
			}
}	?>

  <tr bgcolor="#FFFFFF">
    <td><?php
	 //echo $Current_Dir; 
	if($count_file == 0){
	   echo '<font color="#FF0000">กรุณาระบุไฟล์ที่ต้องการ Upload</font>';
	}
	?>&nbsp;</td>
    <td>
	<?php
	 if($pass>0){ ?> 
	    <input type="submit" name="Submit2" value="บันทึก" > 
	    <input name="flag" type="hidden"  value="add"> 
	    <input name="gid" type="hidden"  value="<?php echo $gid;?>"> 
	    <input name="tempdir" type="hidden"  value="<?php echo $Current_Temp;?>"> 
	<?php }?>
	    <input type="button" name="Submit2" value="ยกเลิก" onClick="location.href='download_add.php?gid=<?php echo $gid;?>&tempdir=<?php echo $Current_Temp;?>';"> 
      </td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>