<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

	$date_pic=date('Ydmhis');
	$id =$_SESSION["EWT_MID"]; //1941-1895
	
	if($_POST["flag"]=='edit'){
	if($_POST["emp_type_id"]!=1){
	$lable ="รหัสบัตรประชาชน";
	$emp_id = $_POST[cardW0].$_POST[cardW1].$_POST[cardW2].$_POST[cardW3].$_POST[cardW4];
	}else{
	$lable ="รหัสพนักงาน";
	$emp_id = $_POST["emp_id"];
	}
			$check_emp="Select * From  gen_user Where emp_id='$emp_id' and gen_user_id!='$id'";
	       $exec_emp= $db->query($check_emp);
	       $row_emp = $db->db_num_rows($exec_emp);		
				 /*    if($row_emp){  
			  ?>
				 <script language="javascript">
				  alert("<?php echo $emp_id;?>ซ้ำกรุณากรอก<?php echo $lable;?>ใหม่");
				  document.location.href="frm_gen_user_edit.php";
				  </script>
	  	 	<?php
		   	 		exit;
			}*/
			
			if($_POST["chk_edit_login"]=='1'){
			$check_emp="Select * From  gen_user Where gen_user='".$_POST["gen_user"]."' and gen_user_id <>'$id'";//1941-1895
	       $exec_emp= $db->query($check_emp);
	       $row_emp = $db->db_num_rows($exec_emp);		
			  if($row_emp > 0){  
			   ?>
				 <script language="javascript">
				  alert("ชื่อผู้ใช้นี้มีผู้ใช้อื่นอยู่แล้ว!!!!!   ท่านไม่สามารถใช้ชื่อนี้ได้");
				  document.location.href="frm_gen_user_edit.php";
				  </script>
	  	 	<?php
		   	 		exit;
			  }else{
			  $user_name = $_POST["gen_user"];
			  }
			$check_emp="Select * From  gen_user Where gen_pass='".$_POST["old_password"]."' and gen_user_id = '$id'";//1941-1895
	       $exec_emp= $db->query($check_emp);
	       $row_emp = $db->db_num_rows($exec_emp);		
			  if($row_emp == 0){  
			   ?>
				 <script language="javascript">
				  alert("ท่านกรอก Password เดิมไม่ถูกต้อง");
				  document.location.href="frm_gen_user_edit.php";
				  </script>
	  	 	<?php
		   	 		exit;
			  }
			}else{
			$user_name = $_POST["hdd_user"];
			}
			
			
			
				
	if($_FILES['file']){		
	  $file_ext = strrchr(strtolower($_FILES['file']['name']),"."); // หา นามสกุล ของไฟล์
	  $newname = $date_pic.$file_ext;    //ชื่อไฟล์ ไหม่
	  $uploadfile = "../dmr_profile/pic_upload/".$newname; // path พร้อม newname ที่จะ upload
	 // print_r($_FILES['file']);
	 if($_FILES['file']){		
			 if(copy($_FILES['file']['tmp_name'], $uploadfile)) { 	// upload to sever
			 chmod($uploadfile,0777);							
				@unlink("../nha_profile/pic_upload/".$hfile);																	
				$hfile=$newname;
	         } 
	    }
	}
	//exit;
	if($_FILES['file2']){		
	  $file_ext2 = strrchr(strtolower($_FILES['file2']['name']),"."); // หา นามสกุล ของไฟล์
	  $newname2 = $date_pic.$file_ext2;    //ชื่อไฟล์ ไหม่
	  $uploadfile2 = "../pic_upload_webboard/".$newname2; // path พร้อม newname ที่จะ upload
	 // print_r($_FILES['file']);
	 if($_FILES['file2']){
	 				
			 if(copy($_FILES['file2']['tmp_name'], $uploadfile2)) { 	// upload to sever
			    chmod($uploadfile2,0777);							
				@unlink("../pic_upload_webboard/".$hfile2);																	
				$hfile2=$newname2;
	         } 
	    }
	}
	//exit;
	$update="Update gen_user Set  emp_id='".$emp_id."',
	   													  title_thai='".$_POST['title_thai']."',
														  name_thai='".$_POST['name_thai']."',
														  surname_thai='".$_POST['surname_thai']."',
														  name_eng='".$_POST['name_eng']."',
														  surname_eng='".$_POST['surname_eng']."',
														  path_image='$hfile',
														  email_person='".$_POST['email_person']."',
														  tel_in='".$_POST['tel_in']."',
														  officeaddress='".$_POST['officeaddress']."',
														  emp_type_id='".$_POST['emp_type_id']."',
														  last_update=NOW(),
														  last_update_by='".$_SESSION['session_name']."',
														  gen_user = '".$user_name."',
														  gen_pass = '".$_POST["gen_pass"]."',
														  webb_name='".$_POST["webb_name"]."',
														  webb_pic ='$hfile2',
														  fign = '".$_POST['webb_fign']."',
														  web_use='".$EWT_FOLDER_USER."'
														  Where  gen_user_id='$id' ";
	  		$db->query($update);
			
			$insert_history="insert into history (gen_user_id,status,edit_date,edit_by) values ('$id','edit', NOW(),'".$_SESSION["EWT_NAME"]."') ";		
     		$db->query($insert_history);
			
		echo "<script language=\"javascript\">";
		echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='main.php?filename=index'" ;
		echo "</script>";	
}
	
	
	
	
	$sql = "SELECT  *        FROM gen_user Where  gen_user_id='$id'";//1941-1895
	$query = $db->query($sql);
	$rst_main = $db->db_fetch_array($query);
	$emp_id=$rst_main[emp_id];
	$level_id=$rst_main[level_id];
	$emp_type_id=$rst_main[emp_type_id];
	$title_thai=$rst_main[title_thai];
	$name_thai=$rst_main[name_thai];
    $surname_thai=$rst_main[surname_thai];
    $title_eng=$rst_main[title_eng];
	$name_eng=$rst_main[name_eng];
	$surname_eng=$rst_main[surname_eng];
	if($rst_main[path_image] != ""){
	$path_image= "../dmr_profile/pic_upload/".$rst_main[path_image];
						if (file_exists($path_image)) {
					   $path_image=$path_image;
					   }else{
					   $path_image="../images/ImageFile.gif";
					   }
	
	}
	//$path_image = eregi_replace("../pic_upload/","../nha_profile/pic_upload/",$path_image);
    $org_id=$rst_main[org_id];
    $posittion=$rst_main[posittion];
    $email_kh=$rst_main[email_kh];
    $email_person=$rst_main[email_person];
    $tel_in=$rst_main[tel_in];
    $tel_convenient=$rst_main[tel_convenient];
	$mobile=$rst_main[mobile];
	$officeaddress=$rst_main[officeaddress];
	$emp_type_id=$rst_main[emp_type_id];
	$gen_user=$rst_main[gen_user];
	$gen_pass=$rst_main[gen_pass];
	$webb_fign = $rst_main[fign];
	$webb_name = $rst_main[webb_name];
	if($rst_main[webb_pic] != ""){
	$path_image2 = "../pic_upload_webboard/".$rst_main[webb_pic];
	if (file_exists($path_image2)) {
					   $path_image2=$path_image2;
					   }else{
					   $path_image2="../images/ImageFile.gif";
					   }
	}
	 if($emp_type_id!='1'){
	$emp_id_lable ="รหัสบัตรประชาชน  : <span class=\"style10\">*</span>";
	$emp_id ="<input name=\"cardW0\"  type=\"text\"  id=\"cardW0\"  class=\"textinput\"  size=\"1\" maxlength=\"1\" value=\"".substr($emp_id,0,1)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==1){this.form.cardW1.value='';this.form.cardW1.focus();}\">
					-<input name=\"cardW1\"  type=\"text\"  id=\"cardW1\" class=\"textinput\"  size=\"4\" maxlength=\"4\" value=\"".substr($emp_id,1,4)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==4){this.form.cardW2.value='';this.form.cardW2.focus();}\">
					-<input name=\"cardW2\"  type=\"text\"  id=\"cardW2\" class=\"textinput\" size=\"5\" maxlength=\"5\" value=\"".substr($emp_id,5,5)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==5){this.form.cardW3.value='';this.form.cardW3.focus();}\">
					-<input name=\"cardW3\"  type=\"text\" id=\"cardW3\" class=\"textinput\" size=\"2\" maxlength=\"2\" value=\"".substr($emp_id,10,2)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==2){this.form.cardW4.value='';this.form.cardW4.focus();}\">
					-<input name=\"cardW4\"  type=\"text\"  id=\"cardW4\" class=\"textinput\" size=\"1\" maxlength=\"1\" value=\"".substr($emp_id,12,1)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==1){if(!chkIDcard(this.form.cardW0.value,this.form.cardW1.value,this.form.cardW2.value,this.form.cardW3.value,this.form.cardW4.value,this.form)){ alert('รหัสบัตรประขาชนไม่ถูกต้อง');this.form.cardW0.value='';this.form.cardW0.focus();}else{};}\">";
	}else{
	//$emp_id_lable ="รหัสเจ้าหน้าที่";
	//$emp_id = '<input name="emp_id" type="text" id="emp_id" value="'.$emp_id.'" size="20" >';
	$emp_id = '';
	}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>แก้ไขข้อมูล</title>
<script language="javascript">
function show_edit_pass(t){
if(t.checked == true){
document.getElementById('gen_user').disabled = false;
document.getElementById('old_password').value = '';
document.getElementById('gen_pass').value = '';
document.getElementById('re_gen_pass').value = '';
document.getElementById('show_pass1').style.display = '';
document.getElementById('show_pass2').style.display = '';
document.getElementById('show_pass3').style.display = '';
}else{
document.getElementById('gen_user').disabled = true;
document.getElementById('gen_user').value = '<?php echo $gen_user;?>';
document.getElementById('gen_pass').value = '<?php echo $gen_pass;?>';
document.getElementById('show_pass1').style.display = 'none';
document.getElementById('show_pass2').style.display = 'none';
document.getElementById('show_pass3').style.display = 'none';

}



}
function chkIDcard (SubCardID1,SubCardID2,SubCardID3,SubCardID4,SubCardID5) {
 var CardID=SubCardID1+SubCardID2+SubCardID3+SubCardID4+SubCardID5;
   		FcardID=(CardID.substr(0,1))*13;
		for(i=1;i<12;i++) {
			subNum = CardID.substr(i,1);
			FcardID=parseInt(FcardID)+ (parseInt(subNum)*(14-(i+1)));
		}
			chk=CardID.substr(CardID.length-1,1);
			temp=11-(parseInt(FcardID)%11);
			temtStr=temp+'';
			chkAnswer=temtStr.substr(temtStr.length-1,1);
		if(parseInt(chk)==parseInt(chkAnswer)) {
			return true;
		} else {
			return false;
		}
   }
   function chkinput(){
   <?php if($emp_type_id !='1'){?>
	 if(frm.cardW0.value=="" || frm.cardW1.value=="" || frm.cardW2.value=="" || frm.cardW3.value=="" || frm.cardW4.value=="" ){ 
		alert("กรุณากรอกรหัสบัตรประชาชน");
		//document.frm.emp_id.focus();
		return false;
	} 
	<?php }else{ ?>
	//if(frm.emp_id.value=="" ){ 
		//alert("กรุณากรอกรหัสพนักงาน");
		//document.frm.emp_id.focus();
		//return false;
	//} 
	<?php } ?>
	 if(frm.title_thai.value==""){ 
	alert("กรุณาเลือกคำนำหน้า");
	document.frm.title_thai.focus();
	return false;
	} 
	
	if(frm.name_thai.value==""){ 
	alert("กรุณากรอกชื่อ");
	document.frm.name_thai.focus();
	return false;
	} 
	
	if(frm.surname_thai.value==""){ 
	alert("กรุณากรอกนามสกุล");
	document.frm.surname_thai.focus();
	return false;
	} 
	
	
	if(frm.gen_user.value==""){ 
	alert("กรุณากรอก Username");
	document.frm.gen_user.focus();
	return false;
	} 
	if(frm.chk_edit_login.checked == true){
		if(frm.old_password.value==""){ 
		alert("กรุณากรอก Password เดิม");
		document.frm.old_password.focus();
		return false;
		} 
		if(frm.gen_pass.value==""){ 
		alert("กรุณากรอก Password");
		document.frm.gen_pass.focus();
		return false;
		} 
		if(frm.re_gen_pass.value==""){ 
		alert("กรุณากรอก Re Password");
		document.frm.re_gen_pass.focus();
		return false;
		} 
	
		if(frm.gen_pass.value != frm.re_gen_pass.value){ 
		alert("Re Password ไม่ถูกต้อง");
		document.frm.re_gen_pass.focus();
		frm.re_gen_pass.value = "";
		return false;
		} 
	}
	return mail_format();
}// end check_input

function mail_format(){
		var goodEmail1 = frm.email_person.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)|(\..{2,2}))$)\b/gi);
		 if (!goodEmail1){
			alert('รูปแบบ E-mail  ไม่ถูกต้อง')
			frm.email_person.focus()
			frm.email_person.select()
			return false;
		}
}


/***** CUSTOMIZE THESE VARIABLES *****/

  // width to resize large images to
var maxWidth=98;
  // height to resize large images to
var maxHeight=98;
  // valid file types
var fileTypes=["bmp","gif","png","jpg","jpeg"];
  // the id of the preview image tag
var outImage="previewField";
var outImage2="previewField2";
  // what to display when the image is not valid
var defaultPic="spacer.gif";

/***** DO NOT EDIT BELOW *****/

function preview(what){
  var source=what.value;
  var ext=source.substring(source.lastIndexOf(".")+1,source.length).toLowerCase();
  for (var i=0; i<fileTypes.length; i++) if (fileTypes[i]==ext) break;
  globalPic=new Image();
  if (i<fileTypes.length) globalPic.src=source;
  else {
    globalPic.src=defaultPic;
    alert("รูปแบบนามสกุลของรูปภาพไม่ถูกต้อง\nกรุณาเลือกรูปแบบใหม่  เช่น :\n"+fileTypes.join(", "));
  }
  setTimeout("applyChanges()",200);
}

function applyChanges(){
  var field=document.getElementById(outImage);
  var x=parseInt(globalPic.width);
  var y=parseInt(globalPic.height);
  if (x>maxWidth) {
    y*=maxWidth/x;
    x=maxWidth;
  }
  if (y>maxHeight) {
    x*=maxHeight/y;
    y=maxHeight;
  }
  field.style.display=(x<1 || y<1)?"none":"";
  field.src=globalPic.src;
  field.width=x;
  field.height=y;
}

function preview2(what){
  var source=what.value;
  var ext=source.substring(source.lastIndexOf(".")+1,source.length).toLowerCase();
  for (var i=0; i<fileTypes.length; i++) if (fileTypes[i]==ext) break;
  globalPic=new Image();
  if (i<fileTypes.length) globalPic.src=source;
  else {
    globalPic.src=defaultPic;
    alert("รูปแบบนามสกุลของรูปภาพไม่ถูกต้อง\nกรุณาเลือกรูปแบบใหม่  เช่น :\n"+fileTypes.join(", "));
  }
  setTimeout("applyChanges2()",200);
}

function applyChanges2(){
  var field=document.getElementById("previewField2");
  var x=parseInt(globalPic.width);
  var y=parseInt(globalPic.height);
  if (x>maxWidth) {
    y*=maxWidth/x;
    x=maxWidth;
  }
  if (y>maxHeight) {
    x*=maxHeight/y;
    y=maxHeight;
  }
 field.style.display=(x<1 || y<1)?"none":"";
  field.src=globalPic.src;
  field.width=x;
  field.height=y;
}
// End -->


</script>
<style type="text/css">
<!--
.style10 {color: #FF0000}
-->
</style>
<link href="css/mysite.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">แก้ไขข้อมูล</font></strong></font></td>
                    </tr>
                  </table>
                  <br />
<form name="frm"  action=""  method="post"  enctype="multipart/form-data">
<input name="flag" type="hidden" value="edit">
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30">
      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
          <td bgcolor="#FFFFFF"><br />
            <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1">
			<tr>
              <td width="31%" height="30">&nbsp;<?php echo $emp_id_lable;?></td>
              <td align="left"><?php echo $emp_id;?></td>
                  <td rowspan="4" align="center"> 
                    <?php  if($emp_type_id=='1'){ ?>
                    <img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="120"   id="previewField" />
<input type="hidden" name="hfile" value="<?php echo $path_image;?>" />
                <br/><br/><?php } ?></td>
            </tr>
            <tr>
              <td height="30">&nbsp;คำนำหน้า : <span class="style10">*</span></td>
              <td align="left"><select name="title_thai" id="title_thai">
					<?php 
						$sql_title = "SELECT * FROM title";
						$query_title = $db->query($sql_title);
						while($rs_title = $db->db_fetch_array($query_title)){
							if($rs_title[title_id] == $title_thai) $selected_title = "selected";
							else $selected_title = "";
							print '<option value="'.$rs_title[title_id].'" '.$selected_title.'>'.$rs_title[title_thai].'</option>';
						}
					?>
					</select></td>
              </tr>
            <tr>
              <td height="30">&nbsp;ชื่อ : <span class="style10">*</span></td>
              <td align="left"><input name="name_thai" type="text" id="name_thai"  value="<?php echo $name_thai;?>" size="50" ></td>
              </tr>
            <tr>
              <td height="30">&nbsp;สกุล : <span class="style10">*</span></td>
              <td align="left"><input name="surname_thai" type="text" id="surname_thai"  value="<?php echo $surname_thai;?>" size="50" ></td>
              </tr>
            <tr>
              <td height="30">&nbsp;Name :</td>
              <td colspan="2" align="left"><input name="name_eng" type="text" id="name_eng"  value="<?php echo $name_eng;?>" size="50"></td>
              </tr>
            <tr>
              <td height="14">&nbsp;Surname :</td>
              <td colspan="2" align="left"><input name="surname_eng" type="text" id="surname_eng"  value="<?php echo $surname_eng;?>" size="50"></td>
              </tr>
			   <?php
			 if($emp_type_id=='1'){
			  ?>
            <tr>
              <td height="7"><span class="bg_color_row">รูปภาพ :</span></td>
              <td colspan="2" align="left"><input name="file" type="file"  id="picField"  onchange="preview(this)"  value="<?php echo $path_image;?>" size="50"  /></td>
            </tr>
			<?php } ?>
            <tr>
              <td height="7">&nbsp;Email  : <span class="style10">*</span></td>
              <td colspan="2" align="left"><input name="email_person" type="text" id="email_person"  value="<?php echo $email_person;?>" size="50"  class="<?php echo $text_read;?>" <?php echo $close_text;?> onBlur="mail_format()" /></td>
            </tr>
            <tr>
              <td height="30">&nbsp;เบอร์ต่อสะดวก : </td>
              <td colspan="2" align="left"><input name="tel_in" type="text" id="tel_in" value="<?php echo $mobile;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
            </tr>
            <tr>
              <td height="30">&nbsp;สถานที่ทำงาน :</td>
              <td colspan="2" align="left"><textarea name="officeaddress" cols="50" rows="5" id="officeaddress"><?php echo $officeaddress;?></textarea></td>
              </tr>
			  <?php
			  if($emp_type_id!='1'){
			  ?>
            <tr>
              <td height="14">&nbsp;กลุ่ม :</td>
              <td colspan="2" align="left"><select name="emp_type_id" id="emp_type_id" >
			  <option value="4"  <?php if($emp_type_id == "4"){ echo "selected"; } ?>>--โปรดเลือก--</option>
			  	<?php 
						$sql_title = "SELECT * FROM emp_type where emp_type_status ='4'";
						$query_title = $db->query($sql_title);
						while($rs_title = $db->db_fetch_array($query_title)){
						if($emp_type_id == $rs_title[emp_type_id]){ $c =  "selected"; }else{ $c = "";}
							print '<option value="'.$rs_title[emp_type_id].'"   '.$c.'>'.$rs_title[emp_type_name].'</option>';
						}
					?>
					</select>					</td>
              </tr>
           
			  <?php
			  }else{
			  ?>
			  <input type="hidden" name="emp_type_id" value="1">
			  <?php }?>
			   <tr>
              <td height="14">&nbsp;Username :</td>
              <td colspan="2" align="left"><input name="gen_user" type="text" id="gen_user" value="<?php echo $gen_user;?>" size="30" disabled="disabled">&nbsp;&nbsp;
                <input name="chk_edit_login" type="checkbox" id="chk_edit_login"  onclick="show_edit_pass(this);" value="1" />
                    แก้ไขชื่อLogin
                    <input type="hidden" name="hdd_user" value="<?php echo $gen_user;?>" /></td>
              </tr>
			   <tr id="show_pass1" style="display:none">
			     <td height="15">&nbsp;Passwordเดิม : <span class="style10">** </span></td>
		         <td colspan="2" align="left"><input name="old_password" type="password" id="old_password" size="30" /></td>
			   </tr>
            <tr id="show_pass2" style="display:none">
              <td height="30">&nbsp;Password : <span class="style10">**</span></td>
              <td colspan="2" align="left"><input name="gen_pass" type="password" id="gen_pass" size="30" value="<?php echo $gen_pass;?>" / ></td>
              </tr>
			  <tr id="show_pass3" style="display:none">
                    <td height="20" bgcolor="#FFFFFF" class="bg_color_row">&nbsp;Re Password : <span class="style10">**</span></td>
                    <td colspan="2" align="left" bgcolor="#FFFFFF">
					<input name="re_gen_pass" type="password" id="re_gen_pass" size="30"/>					</td>
                </tr>
			   <tr align="left" bgcolor="#DBDBF2">
                                    <td height="15" colspan="3"><strong>&gt;&gt;ข้อมูลเกี่ยวกับ 
                                      Webboard </strong></td>
              </tr>
            <tr>
              <td height="30">&nbsp;ชื่อสมาชิก : </td>
              <td colspan="2" align="left"><input name="webb_name" type="text" id="webb_name" size="50" value="<?php echo $webb_name;?>" /></td>
            </tr>
            <tr>
              <td height="30">&nbsp;รูปภาพ : </td>
              <td colspan="2" align="left"><input name="file2" type="file"  id="picField"  onchange="preview2(this)"  value="<?php echo $path_image2;?>" size="50"  /></td>
            </tr>
            <tr>
              <td height="30">&nbsp;ลายเซ็นต์ : </td>
              <td align="left"><textarea name="webb_fign" cols="50" rows="5" id="webb_fign"><?php echo $webb_fign;?></textarea></td>
              <td align="center"><img src="img.php?p=<?php echo base64_encode($path_image2); ?>" name="previewField2" width="120"    id="previewField2" />
			    <input type="hidden" name="hfile2" value="<?php echo $path_image2;?>" /></td>
            </tr>
          <tr bgcolor="#DBDBF2">
                    <td height="25" colspan="3" align="center" id="show_status"><input name="save" type="submit" class="submit" id="save" value="บันทึก" onClick="return chkinput(); " />
                      <input name="Submit2" type="button" class="submit" value="ยกเลิก" style="width:80"  onclick="window.location.href='main.php?filename=index';"/>
                      <input type="hidden" name="level_id" value="<?php echo $level_id;?>" />                      </td>
                </tr>
          </table>
      <br /></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
                </td>
              </tr>
            </table></td>
          <td width="5" height="100%" background="mainpic/bg_r.gif"></td>
        </tr>
      </table></td>
  </tr>
</table>

</body>
</html>
<?php $db->db_close(); ?>
