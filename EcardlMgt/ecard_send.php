<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "Up"){
//copy($file,"../ewt/demo_0850/ecard/".$file_name);
}


?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function chk(){
if(document.form1.subject.value == ""){
alert("กรุณากรอกหัวข้อ");
document.form1.subject.focus();
return false;
}
if(document.form1.sendname.value == ""){
alert("กรุณากรอกชื่อผู้ส่ง");
document.form1.sendname.focus();
return false;
}
if(document.form1.sendemail.value == ""){
alert("กรุณากรอกอีเมล์ผู้ส่ง");
document.form1.sendemail.focus();
return false;
}
if(document.form1.recemail.value == ""){
alert("กรุณากรอกอีเมล์ผู้รับ");
document.form1.recemail.focus();
return false;
}
if(document.form1.body.value == ""){
alert("กรุณากรอกข้อความที่ต้องการส่ง");
document.form1.body.focus();
return false;
}
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/virtual_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><a href="ecard_list.php" >ส่ง E-Card </a></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0" class="ewttableuse">
    <form action="ecard_mail.php" method="post" enctype="multipart/form-data" name="form1" onSubmit = "return chk();" target="mailzone"><tr> 
      <td colspan="2" align="right" bgcolor="#FFFFFF"><hr></td>
      </tr>
	<tr> 
      <td colspan="2" align="center" bgcolor="#FFFFFF"><?php
	      $sql="SELECT * FROM ecard_list WHERE ec_id = '$_GET[fid]'  ";
         $query=$db->query($sql);
  		 $R = $db->db_fetch_array($query);
		       $file=$R[ec_filename];
			   $fileID=$R[ec_id];
	  			//$exp = explode(".",$_GET[ec_filename]);
				//$exp[1] = strtolower($exp[1]);
				//if($exp[1] != "swf"){
				if($R[ec_fileext] != "swf"){ 
				
				?>
				<img src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ecard/<?php echo $file;?>" ><?php }else{ ?>
				  <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="400" height="150">
                    <param name="movie" value="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ecard/<?php echo $file; ?>">
                    <param name="quality" value="high">
                    <embed src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ecard/<?php echo $file; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="400" height="150"></embed>
		        </object><?php } ?></td>
      </tr>
	<tr>
	  <td width="26%" align="right" valign="top" bgcolor="#FFFFFF">หัวข้อ E-Card </td>
	  <td width="74%" align="left" valign="top" bgcolor="#FFFFFF"><input name="subject" type="text" size="60"></td>
	</tr>
	<tr>
	  <td align="right" valign="top" bgcolor="#FFFFFF">ผู้ส่ง </td>
	  <td align="left" valign="top" bgcolor="#FFFFFF"><input type="text" name="sendname"></td>
	</tr>
	<tr>
	  <td align="right" valign="top" bgcolor="#FFFFFF">อีเมล์ผู้ส่ง </td>
	  <td align="left" valign="top" bgcolor="#FFFFFF"><input type="text" name="sendemail"></td>
	</tr>
	<tr>
	  <td align="right" valign="top" bgcolor="#FFFFFF">อีเมล์ผู้รับ</td>
	  <td align="left" valign="top" bgcolor="#FFFFFF"><input name="recemail" type="text" size="90">
      <br>
      (หากมีอีเมล์มากกว่า 1 คั่นด้วยเครื่องหมาย ',')</td>
	  </tr>
	<tr>
	  <td align="right" valign="top" bgcolor="#FFFFFF">ข้อความ</td>
	  <td align="left" valign="top" bgcolor="#FFFFFF"><textarea name="body" cols="50" rows="5"></textarea></td>
	  </tr>
	<tr>
	  <td align="right" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
	  <td align="left" valign="top" bgcolor="#FFFFFF">
	  <input type="hidden" name="fid" value="<?php echo $fileID; ?>">
	  <input type="submit" name="Button" value="ส่งข้อความ" ></td>
	  </tr>
	</form>
</table>


<br>
<br>
<iframe src="" name="mailzone" width="0" height="0"></iframe>
</body>
</html>
<?php
$db->db_close(); ?>