<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

	$date_pic=date('Ydmhis');
	$id =$_POST[gen_user_id];
	if(!$id)$id =$_GET[gen_user_id];

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
		   
			if($_POST["chk_edit_login"]=='1'){
			$check_emp="Select * From  gen_user Where gen_user='".$_POST["gen_user"]."' and gen_user_id <>'$id'";//1941-1895
	       $exec_emp= $db->query($check_emp);
	       $row_emp = $db->db_num_rows($exec_emp);		
			  if($row_emp > 0){  
			   ?>
				 <script language="javascript">
				  alert("ชื่อผู้ใช้นี้มีผู้ใช้อื่นอยู่แล้วท่านไม่สามารถใช้ชื่อนี้ได้");
				  document.location.href="Member_outside_edit.php?gen_user_id=<?php echo $id?>";
				  </script>
	  	 	<?php
		   	 		exit;
			  }else{
			  $user_name = $_POST["gen_user"];
			  }
			$check_emp="Select * From  gen_user Where gen_pass='".$_POST["old_password"]."' and gen_user_id = '$id'";//1941-1895
			//echo  $check_emp;
	       $exec_emp= $db->query($check_emp);
	       $row_emp = $db->db_num_rows($exec_emp);		
			  if($row_emp == 0){  
			   ?>
				 <script language="javascript">
				  alert("ท่านกรอก Password เดิมไม่ถูกต้อง");
				  document.location.href="Member_outside_edit.php?gen_user_id=<?php echo $id?>";
				  </script>
	  	 	<?php
		   	 		exit;
			  }
			}else{
			$user_name = $_POST["hdd_user"];
			}
	//exit;
	if($_POST["delete_pictue2"]=='1'){
			@unlink("../ewt/pic_upload_webboard/".$hfile2);															
			$hfile='';
	}
	if($_FILES['file2']){		
	  $file_ext2 = strrchr(strtolower($_FILES['file2']['name']),"."); // หา นามสกุล ของไฟล์
	  $newname2 = $date_pic.$file_ext2;    //ชื่อไฟล์ ไหม่
	  $uploadfile2 = "../ewt/pic_upload_webboard/".$newname2; // path พร้อม newname ที่จะ upload
	 // print_r($_FILES['file']);
	 if($_FILES['file2']['size']>0){
			 if(copy($_FILES['file2']['tmp_name'], $uploadfile2)) { 	// upload to sever
			    chmod($uploadfile2,0777);							
				@unlink("../ewt/pic_upload_webboard/".$hfile2);																	
				$hfile2=$newname2;
	         } 
	    }else{
		    $hfile2 = $_POST['hfile2'];
		}
	}
	//exit;
	$update="Update gen_user Set  emp_id='".$_POST['card']."',
	   													  title_thai='".$_POST['title_thai']."',
														   title_eng='".$_POST['title_eng']."',
														  name_thai='".$_POST['name_thai']."',
														  surname_thai='".$_POST['surname_thai']."',
														  name_eng='".$_POST['name_eng']."',
														  surname_eng='".$_POST['surname_eng']."',
														  path_image='$hfile',
														  tel_in='".$_POST['tel_in']."',
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
			$db->query("USE ".$_SESSION["EWT_SDB"]);
			$db->write_log("update","member","แก้ไขสมาชิกชื่อ : ".$_POST['name_thai'].'  '.$_POST['surname_thai']);
			$db->query("USE ".$EWT_DB_USER);
			$insert_history="insert into history (gen_user_id,status,edit_date,edit_by) values ('$id','edit', NOW(),'".$_SESSION["EWT_NAME"]."') ";	
				
     		$db->query($insert_history);
			
		?>
		<script language="javascript">
			alert('แก้ไขข้อมูลเรียบร้อยแล้ว');
			document.location.href='MemberList_outside.php';
		</script>
		<?php
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
	//$path_image = eregi_replace("../pic_upload/","../nha_profile/pic_upload/",$path_image);
    $org_id=$rst_main[org_id];
	$emp_id=$rst_main[emp_id];
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
		$pic_image2 = "../ewt/pic_upload_webboard/".$rst_main[webb_pic];
		if (file_exists($pic_image2)) {
			$path_image2=$rst_main[webb_pic];
		 }else{
			$path_image2="../images/ImageFile.gif";
		}
	}
	 if($emp_type_id!='1'){
	$emp_id_lable ="รหัสบัตรประชาชน  : <span class=\"style10\">*</span>";
	
	/*$emp_id ="<input name=\"cardW0\"  type=\"text\"  id=\"cardW0\"  class=\"textinput\"  size=\"1\" maxlength=\"1\" value=\"".substr($emp_id,0,1)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==1){this.frm.cardW1.value='';this.frm.cardW1.focus();}\">
					-<input name=\"cardW1\"  type=\"text\"  id=\"cardW1\" class=\"textinput\"  size=\"4\" maxlength=\"4\" value=\"".substr($emp_id,1,4)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==4){this.frm.cardW2.value='';this.frm.cardW2.focus();}\">
					-<input name=\"cardW2\"  type=\"text\"  id=\"cardW2\" class=\"textinput\" size=\"5\" maxlength=\"5\" value=\"".substr($emp_id,5,5)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==5){this.frm.cardW3.value='';this.frm.cardW3.focus();}\">
					-<input name=\"cardW3\"  type=\"text\" id=\"cardW3\" class=\"textinput\" size=\"2\" maxlength=\"2\" value=\"".substr($emp_id,10,2)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==2){this.frm.cardW4.value='';this.frm.cardW4.focus();}\">
					-<input name=\"cardW4\"  type=\"text\"  id=\"cardW4\" class=\"textinput\" size=\"1\" maxlength=\"1\" value=\"".substr($emp_id,12,1)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==1){if(!chkIDcard(this.frm.cardW0.value,this.frm.cardW1.value,this.frm.cardW2.value,this.frm.cardW3.value,this.frm.cardW4.value,this.frm)){ alert('รหัสบัตรประขาชนไม่ถูกต้อง');this.frm.cardW0.value='';this.frm.cardW0.focus();}else{};}\">";
	*/
	}else{
	//$emp_id_lable ="รหัสเจ้าหน้าที่";
	//$emp_id = '<input name="emp_id" type="text" id="emp_id" value="'.$emp_id.'" size="20" >';
	$emp_id = '';
	}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>แก้ไขข้อมูล</title>
<script src="ajax/AjaxRequest.js"></script>
<script src="ajax/excute.js"></script>
<script src="ajax/load_form.js"></script>
<script language="javascript">
function checkID(obj) {
		var sum;
		var i;
		var id_card=obj.value;
		if(id_card.length != 13) { 
		   alert('เลขที่บัตรประจำตัวประชาชนต้องมี 13 หลัก\nกรุณาตรวจสอบอีกครั้ง'); 
		  // obj.value=''; 
			frm.c1.focus()
		   return false;
		 } else{
			for(i=0,sum=0;i<12;i++)sum=sum+ id_card.charAt(i)*(13-i);
			if((11-(sum%11))%10 != id_card.charAt(12)){
			   alert('เลขที่บัตรประจำตัวประชาชนไม่ถูกต้อง.\nกรุณาตรวจสอบอีกครั้ง'); 
			   //obj.value=''; 
			   frm.c1.focus()
			   return false;
			}
		}
}
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

    var CardID=frm.c1.value+frm.c2.value+frm.c3.value+frm.c4.value+frm.c5.value;
	 if(frm.c1.value=="" || frm.c2.value=="" || frm.c3.value=="" || frm.c4.value=="" || frm.c5.value=="" ){ 
		alert("กรุณากรอกรหัสบัตรประชาชน");
		//document.frm.emp_id.focus();
		return false;
	} 

		if(CardID.length != 13) { 
		   alert('เลขที่บัตรประจำตัวประชาชนต้องมี 13 หลัก\nกรุณาตรวจสอบอีกครั้ง'); 
		  // obj.value=''; 
			frm.c1.focus()
		   return false;
		 }
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
	if(frm.tel_in.value !='' && isNaN(frm.tel_in.value)){ 
		alert("กรุณากรอกหมายเลขโทรศัพท์ให้ถูกต้อง");
		document.frm.tel_in.focus();
		return false;
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

function chk_status(t){
document.frm.title_thai.value = t.value;
	if(document.frm.title_thai.value == ''){
		var url = 'ajax/title.php?title_id='+t.value+'';
		load_divForm(url,'div_title_thai','')
	}
}
</script>
<style type="text/css">
<!--
.style10 {color: #FF0000}
-->
</style>

<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><A href="MemberList_outside.php" target="member_body">ข้อมูลสมาชิก</A> </span> </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right">&nbsp;<a href="MemberList_outside.php"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle">กลับ </a>
          <hr>
      </td>
    </tr>
  </table>
<form name="frm"  action=""  method="post"  enctype="multipart/form-data">
<input name="flag" type="hidden" value="edit">
    <table width="80%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	        <tr class="ewttablehead">
			<td colspan="3"> แก้ไขข้อมูลสมาชิก</td>
			</tr>
			<tr>
              <td width="38%" height="30" bgcolor="#FFFFFF">&nbsp;<?php echo $emp_id_lable;?></td>
              <td width="42%"  colspan="2" align="left" bgcolor="#FFFFFF">
<script language="javascript">
function mixcard(){
   frm.card.value=frm.c1.value+frm.c2.value+frm.c3.value+frm.c4.value+frm.c5.value;
}
</script>
<input type="text"  value="<?php echo substr($emp_id,0,1)?>" size="1" maxlength="1" name="c1"  onKeyUp="if(this.value.length==1){frm.c2.select();}" readonly="">
-<input type="text" value="<?php echo substr($emp_id,1,4)?>" size="4" maxlength="4" name="c2"  onKeyUp="if(this.value.length==4){frm.c3.select();}" readonly="">
-<input type="text" value="<?php echo substr($emp_id,5,5)?>" size="5" maxlength="5" name="c3"  onKeyUp="if(this.value.length==5){frm.c4.select();}"  readonly="">
-<input type="text" value="<?php echo substr($emp_id,10,2)?>" size="2" maxlength="2" name="c4"  onKeyUp="if(this.value.length==2){frm.c5.select();}" readonly="">
-<input type="text" value="<?php echo substr($emp_id,12,1)?>" size="1" maxlength="1" name="c5"   readonly="">
<input type="hidden" name="card"  value="<?php echo $emp_id;?>" maxlength="13" ></td>
            </tr>
            <tr>
              <td height="30" bgcolor="#FFFFFF">&nbsp;คำนำหน้า : <span class="style10">*</span></td>
              <td align="left" colspan="2"  bgcolor="#FFFFFF"><div id="div_title_thai">
          <select name="title_thai" id="title_thai">
            <option value="" >--โปรดเลือก--</option>
            <?php //$disp->ddw_list_selected ("SELECT * FROM title  ","title_thai","title_id",$title_thai);?>
            <?php 
						$sql_title = "SELECT title_thai,title_id FROM title group by title_thai";
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
              <td height="30" bgcolor="#FFFFFF">&nbsp;ชื่อ : <span class="style10">*</span></td>
              <td align="left" bgcolor="#FFFFFF" colspan="2" ><input name="name_thai" type="text" id="name_thai"  value="<?php echo $name_thai;?>" size="50" ></td>
      </tr>
            <tr>
              <td height="14" bgcolor="#FFFFFF">&nbsp;สกุล : <span class="style10">*</span></td>
              <td align="left" bgcolor="#FFFFFF"colspan="2" ><input name="surname_thai" type="text" id="surname_thai"  value="<?php echo $surname_thai;?>" size="50" ></td>
      </tr>
            <tr>
              <td height="15" bgcolor="#FFFFFF">Title : </td>
              <td align="left" bgcolor="#FFFFFF"colspan="2" > <select name="title_eng" id="title_eng" onChange="chk_status(this);">
            <option value="">--โปรดเลือก--</option>
            <?php //$disp->ddw_list_selected ("SELECT * FROM title  ","title_thai","title_id",$title_thai);?>
            <?php 
						$sql_title = "SELECT title_eng,title_id FROM title group by title_eng";
						$query_title = $db->query($sql_title);
						while($rs_title = $db->db_fetch_array($query_title)){
							if($rs_title[title_id] == $title_eng) $selected_title = "selected";
							else $selected_title = "";
							print '<option value="'.$rs_title[title_id].'" '.$selected_title.'>'.$rs_title[title_eng].'</option>';
						}
					?>
          </select></td>
            </tr>
            <tr>
              <td height="30" bgcolor="#FFFFFF">&nbsp;Name :</td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="name_eng" type="text" id="name_eng"  value="<?php echo $name_eng;?>" size="50"></td>
      </tr>
            <tr>
              <td height="14" bgcolor="#FFFFFF">&nbsp;Surname :</td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="surname_eng" type="text" id="surname_eng"  value="<?php echo $surname_eng;?>" size="50"></td>
      </tr>
			   <?php
			 if($emp_type_id=='1'){
			  ?>
            <tr>
              <td height="7" bgcolor="#FFFFFF"><span class="bg_color_row">รูปภาพ :</span></td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="file" type="file"  id="picField"  onchange="preview(this)"  value="<?php echo $path_image;?>" size="50"  /></td>
            </tr>
			<?php } ?>
            <tr>
              <td height="7" bgcolor="#FFFFFF">&nbsp;Email  : <span class="style10">*</span></td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="email_person" type="text" id="email_person"  value="<?php echo $email_person;?>" size="50"  class="<?php echo $text_read;?>" <?php echo $close_text;?> ></td>
            </tr>
            <tr>
              <td height="30" bgcolor="#FFFFFF">&nbsp;เบอร์ต่อสะดวก : </td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="tel_in" type="text" id="tel_in" value="<?php echo $mobile;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
            </tr>
            <tr>
              <td height="30" bgcolor="#FFFFFF">&nbsp;สถานที่ทำงาน :</td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><textarea name="officeaddress" cols="50" rows="5" id="officeaddress"><?php echo $officeaddress;?></textarea></td>
      </tr>
			  <?php
			  if($emp_type_id!='1'){
			  ?>
            <tr>
              <td height="14" bgcolor="#FFFFFF">&nbsp;กลุ่ม :</td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><select name="emp_type_id" id="emp_type_id" >
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
              <td height="14" bgcolor="#FFFFFF">&nbsp;Username :</td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="gen_user" type="text" id="gen_user" value="<?php echo $gen_user;?>" size="30" disabled="disabled">&nbsp;&nbsp;
                <input name="chk_edit_login" type="checkbox" id="chk_edit_login"  onclick="show_edit_pass(this);" value="1" />
                    แก้ไขชื่อLogin
                 <input type="hidden" name="hdd_user" value="<?php echo $gen_user;?>" /></td>
              </tr>
			   <tr id="show_pass1" style="display:none">
			     <td height="15" bgcolor="#FFFFFF">&nbsp;Passwordเดิม : <span class="style10">** </span></td>
		         <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="old_password" type="password" id="old_password" size="30" /></td>
			   </tr>
            <tr id="show_pass2" style="display:none">
              <td height="30" bgcolor="#FFFFFF">&nbsp;Password : <span class="style10">**</span></td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="gen_pass" type="password" id="gen_pass" size="30" value="<?php echo $gen_pass;?>" / ></td>
      </tr>
			  <tr id="show_pass3" style="display:none">
                    <td height="20" bgcolor="#FFFFFF" class="bg_color_row">&nbsp;Re Password : <span class="style10">**</span></td>
                    <td colspan="2" align="left" bgcolor="#FFFFFF">
					<input name="re_gen_pass" type="password" id="re_gen_pass" size="30"/>					</td>
      </tr>
			   <tr align="left" bgcolor="#DBDBF2">
                                    <td height="15" colspan="3" bgcolor="#FFFFFF"><strong>&gt;&gt;ข้อมูลเกี่ยวกับ 
                                      Webboard </strong></td>
              </tr>
            <tr>
              <td height="30" bgcolor="#FFFFFF">&nbsp;ชื่อสมาชิก : </td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="webb_name" type="text" id="webb_name" size="50" value="<?php echo $webb_name;?>" /></td>
            </tr>
            <tr>
              <td height="30" bgcolor="#FFFFFF">&nbsp;รูปภาพ : </td>
              <td colspan="2" align="left" bgcolor="#FFFFFF"><input name="file2" type="file"  id="picField"  onchange="preview2(this)"  value="<?php echo $path_image2;?>" size="50"  /></td>
            </tr>
            <tr>
              <td height="30" bgcolor="#FFFFFF">&nbsp;ลายเซ็นต์ : </td>
              <td align="left" bgcolor="#FFFFFF"><textarea name="webb_fign" cols="50" rows="5" id="webb_fign"><?php echo $webb_fign;?></textarea></td>
              <td width="20%"  align="center" bgcolor="#FFFFFF">
			  <img src="img.php?p=<?php echo base64_encode($pic_image2); ?>" name="previewField2" width="120"    id="previewField2" />
		      <input type="hidden" name="hfile2" value="<?php echo $path_image2;?>" />
			  <input type="checkbox" name="delete_pictue2" value="1"  onclick="show_mage2();"/ >ลบรูปภาพ
        <script language="javascript">
					function show_mage2(){
					if(frm.delete_pictue2.checked==true){
					 document.getElementById("previewField2").style.display='none';
					}else{
					 document.getElementById("previewField2").style.display='';
					  }
					}
					</script></td>
            </tr>
          <tr bgcolor="#DBDBF2">
                    <td height="25" colspan="3" align="center" bgcolor="#FFFFFF" id="show_status"><input name="save" type="submit" class="submit" id="save" value="บันทึก" onClick="mixcard(); return chkinput(); " />
                      <input name="Submit2" type="button" class="submit" value="ยกเลิก" style="width:80"  onclick="window.location.href='MemberList_outside.php';"/>
            <input type="hidden" name="level_id" value="<?php echo $level_id;?>" />                      </td>
      </tr>
  </table>
</form>

</body>
</html>
<?php $db->db_close(); ?>
