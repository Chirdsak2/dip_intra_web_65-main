<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	//include("language/language.php");
	$monthname = array('','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.');
	if($_GET["filename"] != "") {
		$sql_index = $db->query("SELECT template_id,filename FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
		$F = $db->db_fetch_array($sql_index);
		$_GET["d_id"] = $F["template_id"];
	} else {
		$_GET["filename"] = "index";
		$sql_index = $db->query("SELECT d_id FROM design_list WHERE d_default = 'Y'  ");
		$FF = $db->db_fetch_array($sql_index);
		$_GET["d_id"] = $FF[d_id];
	}

			$lang_sh1 = explode('___',$F[filename]);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
	$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
	$sql_temp= $db->query($temp);
	$RR = $db->db_fetch_array($sql_temp);

	$global_theme = $RR["d_bottom_content"];
	$mainwidth = "0";


	$db->query("USE ".$EWT_DB_NAME);
function vulgar($text){
global $db;
$vulgar_text = array();
$sql_vulgar = "SELECT *  FROM vulgar_table ";
   $query_vulgar  = mysql_query($sql_vulgar);
   $i=0;
   	while ($res_vulgar = mysql_fetch_array($query_vulgar)){
		$pos = strpos($text, $res_vulgar [vulgar_text]);
		if (!($pos === false)) { // note: three equal signs
			print "<script>alert('ความคิดเห็นของคุณมีคำแปลกปลอม กรุณาตรวจ!!!!!!!!!');</script>";	exit;
		}
	}
}
//check username in db
	function check_name_wbb($name){
		global $db,$EWT_DB_NAME,$EWT_DB_USER;
		$db->query("USE ".$EWT_DB_NAME);
		$sql_img = "select * from gen_user where webb_name = '".$name."' and gen_user_id <> '".$_SESSION["EWT_MID"]."'";
		$query = $db->query($sql_img);
		if($db->db_num_rows($query)>0){
			print "<script>alert('ชื่อนามแฝงนี้มีสมาชิกของระบบใช้อยู่ กรุณาใช้ชื่อนามแฝงอื่น!!!!!!!!!".$_SESSION["EWT_MID"]."');</script>";	exit;
		}else{
		return $name;
		}
		$db->query("USE ".$EWT_DB_NAME);
	}
	function check_w_name($name){
		global $db,$EWT_DB_NAME,$EWT_DB_USER;
		$db->query("USE ".$EWT_DB_NAME);
		$sql_img = $db->query("select * from w_name where w_name = '".$name."' ");
		if($db->db_num_rows($sql_img)>0){
			print "<script>alert('ชื่อสมาชิกในข้อมูลเกี่ยวกับ Webboard ที่ท่านใช้เป็นชื่อห้ามที่ห้ามใช้ กรุณาใช้ชื่ออื่น!!');</script>";	exit;
		}
		$db->query("USE ".$EWT_DB_NAME);
	}
$db->query("USE ".$EWT_DB_USER);

	$date_pic=date('Ydmhis');
	$id =$_SESSION["EWT_MID"]; //1941-1895
	
	if($_POST["flag"]=='edit'){
	if($_POST["emp_type_status"]!=2){
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
			
			
			
	if($_POST["delete_pictuer"]=='1'){
			@unlink("../pic_upload/".$hfile);																
			$hfile='';
	}	
	if($_FILES['file']){		
	  $file_ext = strrchr(strtolower($_FILES['file']['name']),"."); // หา นามสกุล ของไฟล์
	  $newname = $date_pic.$file_ext;    //ชื่อไฟล์ ไหม่
	  $uploadfile = "../pic_upload/".$newname; // path พร้อม newname ที่จะ upload
	 // print_r($_FILES['file']);
	 if($_FILES['file']){		
			 if(copy($_FILES['file']['tmp_name'], $uploadfile)) { 	// upload to sever
			 chmod($uploadfile,0777);							
				@unlink("../pic_upload/".$hfile);																	
				$hfile=$newname;
	         } 
	    }
	}
	//exit;
	if($_POST["delete_pictue2"]=='1'){
			@unlink("../pic_upload_webboard/".$hfile2);															
			$hfile2='';
	}
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
	
	//chk name
	
	if($_POST["webb_name"] != ''){
		check_w_name(addslashes(htmlspecialchars($_POST["webb_name"])));
		$webb_name = check_name_wbb($_POST["webb_name"]);
	}else{
		$webb_name = '';
	}
	$update="Update gen_user Set  emp_id='".$emp_id."',
	   													  title_thai='".$_POST['title_thai']."',
														  name_thai='".$_POST['name_thai']."',
														  surname_thai='".$_POST['surname_thai']."',
														  title_eng='".$_POST['title_eng']."',
														  name_eng='".$_POST['name_eng']."',
														  surname_eng='".$_POST['surname_eng']."',
														  path_image='$hfile',
														  email_kh='".$_POST['email_person']."',
														  email_person='".$_POST['email_person']."',
														  tel_in='".$_POST['tel_in']."',
														  tel_convenient='".$_POST['tel_convenient']."',
														  mobile='".$_POST['mobile']."',
														  officeaddress='".$_POST['officeaddress']."',
														  emp_type_id='".$_POST['emp_type_id']."',
														  level_id ='".$_POST['level_id']."',
														  last_update=NOW(),
														  last_update_by='".$_SESSION['session_name']."',
														  expiredate='' ,
														  gen_user = '".$user_name."',
														  gen_pass = '".$_POST["gen_pass"]."',
														  webb_name='".$webb_name."',
														  webb_pic ='$hfile2',
														  fign = '".$_POST['webb_fign']."'
														  Where  gen_user_id='$id' ";
	  		$db->query($update);
			
			//$insert_history="insert into history (gen_user_id,status,edit_date,edit_by) values ('$id','edit', NOW(),'".$_SESSION["EWT_NAME"]."') ";		
     		//$db->query($insert_history);
			//update mail admin module ต่างๆ
			$db->query("USE  ".$EWT_DB_NAME);
			$update = "update email_config set email = '".$_POST['email_person']."' where link_id ='".$id."'";
			$db->query($update);
			$db->query("USE ".$EWT_DB_NAME);
			//end update
		echo "<script language=\"javascript\">";
		echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
		echo "self.parent.location.href='main.php?filename=index'" ;
		echo "</script>";	
}
	
	
	
	
	$sql = "SELECT  *        FROM gen_user  LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`) Where  gen_user_id='$id'";//1941-1895
	$query = $db->query($sql);
	$rst_main = $db->db_fetch_array($query);
	$emp_id=$rst_main[emp_id];
	$level_id=$rst_main[level_id];
	$emp_type_id=$rst_main[emp_type_id];
	$emp_type_status=$rst_main[emp_type_status];
	$title_thai=$rst_main[title_thai];
	$name_thai=$rst_main[name_thai];
    $surname_thai=$rst_main[surname_thai];
    $title_eng=$rst_main[title_eng];
	$name_eng=$rst_main[name_eng];
	$surname_eng=$rst_main[surname_eng];
	if($rst_main[path_image] != ""){
	$path_image= "../pic_upload/".$rst_main[path_image];
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
	if($emp_type_status !='2'){
	$emp_id_lable ="รหัสบัตรประชาชน  : ";
/*	$emp_id ="<input name=\"cardW0\"  type=\"text\"  id=\"cardW0\"  class=\"textinput\"  size=\"1\" maxlength=\"1\" value=\"".substr($emp_id,0,1)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==1){this.form.cardW1.value='';this.form.cardW1.focus();}\">
					-<input name=\"cardW1\"  type=\"text\"  id=\"cardW1\" class=\"textinput\"  size=\"4\" maxlength=\"4\" value=\"".substr($emp_id,1,4)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==4){this.form.cardW2.value='';this.form.cardW2.focus();}\">
					-<input name=\"cardW2\"  type=\"text\"  id=\"cardW2\" class=\"textinput\" size=\"5\" maxlength=\"5\" value=\"".substr($emp_id,5,5)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==5){this.form.cardW3.value='';this.form.cardW3.focus();}\">
					-<input name=\"cardW3\"  type=\"text\" id=\"cardW3\" class=\"textinput\" size=\"2\" maxlength=\"2\" value=\"".substr($emp_id,10,2)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==2){this.form.cardW4.value='';this.form.cardW4.focus();}\">
					-<input name=\"cardW4\"  type=\"text\"  id=\"cardW4\" class=\"textinput\" size=\"1\" maxlength=\"1\" value=\"".substr($emp_id,12,1)."\" onKeyPress=\"return NumberOnly();\" onKeyUp=\"if(this.value.length==1){if(!chkIDcard(this.form.cardW0.value,this.form.cardW1.value,this.form.cardW2.value,this.form.cardW3.value,this.form.cardW4.value,this.form)){ alert('รหัสบัตรประขาชนไม่ถูกต้อง');this.form.cardW0.value='';this.form.cardW0.focus();}else{};}\">";*/
					$emp_id ="<input name=\"cardW0\"  type=\"text\"  id=\"cardW0\"  class=\"textinput\"  size=\"1\" maxlength=\"1\" value=\"".substr($emp_id,0,1)."\" onKeyPress=\"return NumberOnly();\">
					-<input name=\"cardW1\"  type=\"text\"  id=\"cardW1\" class=\"textinput\"  size=\"4\" maxlength=\"4\" value=\"".substr($emp_id,1,4)."\" onKeyPress=\"return NumberOnly();\" >
					-<input name=\"cardW2\"  type=\"text\"  id=\"cardW2\" class=\"textinput\" size=\"5\" maxlength=\"5\" value=\"".substr($emp_id,5,5)."\" onKeyPress=\"return NumberOnly();\" >
					-<input name=\"cardW3\"  type=\"text\" id=\"cardW3\" class=\"textinput\" size=\"2\" maxlength=\"2\" value=\"".substr($emp_id,10,2)."\" onKeyPress=\"return NumberOnly();\" >
					-<input name=\"cardW4\"  type=\"text\"  id=\"cardW4\" class=\"textinput\" size=\"1\" maxlength=\"1\" value=\"".substr($emp_id,12,1)."\" onKeyPress=\"return NumberOnly();\" >";
	}else{
	$emp_id_lable ="";
	$emp_id = "<input name=\"emp_id\" type=\"hidden\" value=\"".$emp_id."\">";
	}
	$db->query("USE ".$EWT_DB_NAME);

?>
<html>
<head>
<title>สมัครสมาชิก</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php include("ewt_script.php");	 ?>
<script language="javascript" src="js/functions.js"></script>
<script language="javascript">
function show_edit_pass(t){
if(t.checked == true){
document.getElementById('gen_user').disabled = true;
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
   <?php if($emp_type_status!='2'){?>
  /*  var CardID=frm.cardW0.value+frm.cardW1.value+frm.cardW2.value+frm.cardW3.value+frm.cardW4.value;
	 if(frm.cardW0.value=="" || frm.cardW1.value=="" || frm.cardW2.value=="" || frm.cardW3.value=="" || frm.cardW4.value=="" ){ 
		alert("กรุณากรอกรหัสบัตรประชาชน");
		//document.frm.emp_id.focus();
		return false;
	} 
	if(CardID.length < 13){
	alert("กรุณากรอกรหัสบัตรประชาชน");
		//document.frm.emp_id.focus();
		return false;
	}*/
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
	document.getElementById('gen_user').disabled = false;
	
	if(frm.gen_user.value==""){ 
	alert("กรุณากรอก Username");
	document.frm.gen_user.focus();
	return false;
	} 
		if (frm.gen_user.value.search("^[A-Za-z0-9_]+$")){
					alert("Username is limited to English character  (upper and lower case), number, and underscore only!");
					document.frm.gen_user.focus();
					return false;
		}
	if(frm.chk_edit_login.checked == true){
		if(frm.old_password.value==""){ 
		alert("กรุณากรอก Password เดิม");
		document.frm.old_password.focus();
		return false;
		} 
			if (frm.gen_pass.value.search("^[A-Za-z0-9_]+$")){
					alert("Password is limited to English character  (upper and lower case), number, and underscore only!");
					document.frm.gen_pass.focus();
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
	
if(frm.email_person.value){	
	var goodEmail1 = frm.email_person.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)|(\..{2,2}))$)\b/gi);
	if (goodEmail1){

	} else {
   		alert('กรุณากรอกรูปแบบ Email  ให้ถูกต้อง')
   		frm.email_person.focus()
   		frm.email_person.select()
		return false;
   	}
 }	
}// end check_input
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
		var url = 'js/title.php?title_id='+t.value+'';
		load_divForm(url,'div_title_thai','')
	}
}
function show_mage(){
	if(frm.delete_pictuer.checked==true){
		document.getElementById("previewField").style.display='none';
	}else{
		document.getElementById("previewField").style.display='';
		}
	}
</script>
<style type="text/css">
<!--
.style10 {color: #FF0000}
-->
</style>
<link href="css/mysite.css" rel="stylesheet" type="text/css">
</head>
<body  leftmargin="0" topmargin="0" <?php if($RR["d_site_bg_c"] != ""){ echo "bgcolor=\"".$RR["d_site_bg_c"]."\""; } ?> <?php if($RR["d_site_bg_p"] != ""){ echo "background=\"".$RR["d_site_bg_p"]."\""; } ?> >
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
		
<table id="ewt_main_structure" width="<?php echo $RR["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $RR["d_site_align"]; ?>">
	<tr  valign="top" > 
		<td id="ewt_main_structure_top" height="<?php echo $RR["d_top_height"]; ?>" bgcolor="<?php echo $RR["d_top_bg_c"]; ?>" background="<?php echo $RR["d_top_bg_p"]; ?>" colspan="3" >
			<?php
				$mainwidth = $RR["d_site_width"];
			?>
			<?php
				$sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($TB = $db->db_fetch_row($sql_top)) {
			?>
			<DIV><?php echo show_block($TB[0]); ?></DIV>
			<?php 
				} 
			?>
		</td>
	</tr>
	<tr valign="top" > 
		<td id="ewt_main_structure_left" width="<?php echo $RR["d_site_left"]; ?>" bgcolor="<?php echo $RR["d_left_bg_c"]; ?>" background="<?php echo $RR["d_left_bg_p"]; ?>">
			<?php
				$mainwidth = $RR["d_site_left"];
			?>
			<?php
				$sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($LB = $db->db_fetch_row($sql_left)){
			?>
			<DIV><?php echo show_block($LB[0]); ?></DIV>
			<?php 
				} 
			?>
		</td>
		<td id="ewt_main_structure_body" width="<?php echo $RR["d_site_content"]; ?>" bgcolor="<?php echo $RR["d_body_bg_c"]; ?>" height="160" background="<?php echo $RR["d_body_bg_p"]; ?>">
			<?php
				$mainwidth = $RR["d_site_content"];
			?>
			<?php
				$sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($CB = $db->db_fetch_row($sql_content)) {
			?>
			<DIV ><?php echo show_block($CB[0]); ?></DIV>
			<?php 
				} 
				$db->query("USE ".$EWT_DB_USER);
			?>
			<br>
			<br><br>
		<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">แก้ไขข้อมูล</font></strong></font></td>
                    </tr>
                  </table>
<form name="frm"  action=""  method="post"  enctype="multipart/form-data" target="save_function_form1">
<input name="flag" type="hidden" value="edit">
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30">
      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
          <td bgcolor="#FFFFFF"><br />
            <table width="80%" border="0" align="center" cellpadding="3" cellspacing="1">
              <td width="31%" height="30">&nbsp;<?php echo $emp_id_lable;?></td>
              <td align="left"><?php echo $emp_id;?></td>
                  <td rowspan="4" align="center"> 
                    <?php if($emp_type_status=='2'){?>
                    <img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="120"   id="previewField" />
<input type="hidden" name="hfile" value="<?php echo $path_image;?>" />
                <br/><br/><?php } ?>
				   <input type="checkbox" name="delete_pictuer" value="1"  onclick="show_mage();"/ >ลบรูปภาพ
        <script language="javascript">
					function show_mage(){
					if(frm.delete_pictuer.checked==true){
					 document.getElementById("previewField").style.display='none';
					}else{
					 document.getElementById("previewField").style.display='';
					  }
					}
					</script></td>
            </tr>
            <tr>
              <td height="30">&nbsp;คำนำหน้า : <span class="style10">*</span></td>
              <td align="left"><div id="div_title_thai">
			  <?php 
						$sql_title = "SELECT title_thai,title_id FROM title where title_id = '".$title_thai."' group by title_thai";
						$query_title = $db->query($sql_title);
						while($rs_title = $db->db_fetch_array($query_title)){
							echo $title_th = $rs_title['title_thai'];
							$title_th_id = $rs_title['title_id'];
						}
					?><input name="title_thai" type="hidden" value="<?php echo $title_thai;?>">

              </div></td>
              </tr>
            <tr>
              <td height="30">&nbsp;ชื่อ : <span class="style10">*</span></td>
              <td align="left"><?php echo $name_thai;?><input name="name_thai" type="hidden" id="name_thai"  value="<?php echo $name_thai;?>" size="50" ></td>
              </tr>
            <tr>
              <td height="30">&nbsp;สกุล : <span class="style10">*</span></td>
              <td align="left"><?php echo $surname_thai;?><input name="surname_thai" type="hidden" id="surname_thai"  value="<?php echo $surname_thai;?>" size="50" ></td>
              </tr>
            <tr>
              <td height="30">&nbsp;Title:</td>
              <td colspan="2" align="left">
			    <?php 
						$sql_title = "SELECT title_eng,title_id FROM title where title_id = '".$title_eng."' group by title_eng";
						$query_title = $db->query($sql_title);
						while($rs_title = $db->db_fetch_array($query_title)){
							echo $title_th = $rs_title['title_eng'];
							$title_th_id = $rs_title['title_id'];
						}
					?><input name="title_eng" type="hidden" value="<?php echo $title_eng;?>"></td>
              </tr>
            <tr>
              <td height="30">&nbsp;Name :</td>
              <td colspan="2" align="left"><?php echo $name_eng;?><input name="name_eng" type="hidden" id="name_eng"  value="<?php echo $name_eng;?>" size="50"></td>
              </tr>
            <tr>
              <td height="14">&nbsp;Surname :</td>
              <td colspan="2" align="left"><?php echo $surname_eng;?><input name="surname_eng" type="hidden" id="surname_eng"  value="<?php echo $surname_eng;?>" size="50"></td>
              </tr>
			   <?php
			  if($emp_type_status=='2'){
			  ?>
            <tr>
              <td height="7"><span class="bg_color_row">รูปภาพ :</span></td>
              <td colspan="2" align="left"><input name="file" type="file"  id="picField"  onchange="preview(this)"  value="<?php echo $path_image;?>" size="50"  /></td>
            </tr>
            <!--<tr>
              <td height="7">&nbsp;Email  :</td>
              <td colspan="2" align="left"><input name="email_kh" type="text" id="email_kh"  value="<?php//=$email_kh;?>" size="50"  class="<?php echo $text_read;?>" <?php echo $close_text;?> /></td>
            </tr>-->
			<?php } ?>
            <tr>
              <td height="14">&nbsp;Email (ส่วนตัว) :</td>
              <td colspan="2" align="left"><input name="email_person" type="text" id="email_person" value="<?php echo $email_person;?>" size="50"></td>
              </tr>
			    <?php
			  if($emp_type_status=='2'){
			  ?>
            <tr>
              <td height="15">เบอร์ติดต่อภายใน :</td>
              <td colspan="2" align="left"><input name="tel_in" type="text" id="tel_in"  value="<?php echo $tel_in;?>" size="50"></td>
            </tr>
            <tr>
              <td height="30">&nbsp;เบอร์ต่อสะดวก : </td>
              <td colspan="2" align="left"><input name="tel_convenient" type="text" id="tel_convenient" value="<?php echo $tel_convenient;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
            </tr>
			<?php } ?>
            <tr>
              <td height="30">&nbsp;เบอร์มือถือ :</td>
              <td colspan="2" align="left"><input name="mobile" type="text" id="mobile" value="<?php echo $mobile;?>" size="50" ></td>
              </tr>
            <tr>
              <td height="30">&nbsp;สถานที่ทำงาน :</td>
              <td colspan="2" align="left"><textarea name="officeaddress" cols="50" rows="5" id="officeaddress"><?php echo $officeaddress;?></textarea></td>
              </tr>
			  <?php
			  if($emp_type_status!='2'){
			  ?>
            <tr>
              <td height="14">&nbsp;สถานะ :</td>
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
			  <input type="hidden" name="emp_type_id" value="<?php echo $emp_type_id;?>">
			  <?php }?>
			  <input name="emp_type_status" type="hidden" value="<?php echo $emp_type_status;?>">
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
 <iframe name="save_function_form1" src=""  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
		</td>
		<td id="ewt_main_structure_right" width="<?php echo $RR["d_site_right"]; ?>" bgcolor="<?php echo $RR["d_right_bg_c"]; ?>" background="<?php echo $RR["d_right_bg_p"]; ?>">
			<?php
			$db->query("USE ".$EWT_DB_NAME);
				$mainwidth = $RR["d_site_right"];
			?>
			<?php
				$sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($RRB = $db->db_fetch_row($sql_right)){
			?>
			<DIV ><?php echo show_block($RRB[0]); ?></DIV>
			<?php 
				} 
			?>
		</td>
	</tr>
	<tr valign="top" > 
		<td id="ewt_main_structure_bottom" height="<?php echo $RR["d_bottom_height"]; ?>" bgcolor="<?php echo $RR["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $RR["d_bottom_bg_p"]; ?>">
			<?php
				$mainwidth = $RR["d_site_width"];
			?>
			<?php
				$sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
				while($BB = $db->db_fetch_row($sql_bottom)) {
			?>
			<DIV><?php echo show_block($BB[0]); ?></DIV>
			<?php 
				} 
			?>
		</td>
	</tr>
</table>
</body>
</html>
<script language="javascript"><?php
						if($search_mode != "") {
							?>
							ajax_search('<?php echo $search_mode; ?>');
							<?php
						}
					?>
</script>
<?php $db->db_close(); ?>
