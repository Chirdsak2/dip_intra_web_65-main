<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$date_pic=date('Ydmhis');
$uploaddir = "../ewt/pic_upload/";

if($_POST['proc'] != ''){
if($_POST["gen_user_id"] != ''){
$wh = "and gen_user_id <>'".$_POST["gen_user_id"]."'";
}
	$sql_chk = "select * from gen_user where name_thai = '".$_POST['name_thai']."' and surname_thai = '".$_POST['surname_thai']."' $wh";
	$query = $db->query($sql_chk);
	if($db->db_num_rows($query)>0){
	echo "<script >";
	echo "alert('ชื่อ-สกุลนี้มีอยู่แล้ว ท่านไม่สามารถบันทึกได้ กรุณาตรวจสอบ!!!!!!');";
	echo "document.location.href='MemberList.php';" ;
	echo "</script>";
	exit;
	}

 if($_POST[proc]=='add'){
	$emp_id = $_POST[cardW0].$_POST[cardW1].$_POST[cardW2].$_POST[cardW3].$_POST[cardW4];
	$numChkID=$db->db_num_rows($db->query('SELECT emp_id FROM gen_user WHERE emp_id=\''.$emp_id.'\''));
	
	if($numChkID && $emp_id) { // ถ้าไม่กรอกรหัส จะสามารถสมัครซ้ำได้
		echo '<script type="text/javascript"> alert("หมายเลขบัตรประชาชนนี้มีผู้ใช้แล้ว"); self.location.href="'.$_SERVER['HTTP_REFERER'].'"; </script>';
		exit;
	}
 			 if($_FILES['file']){			  
			    $file_ext = strrchr(strtolower($_FILES['file']['name']),"."); // หา นามสกุล ของไฟล์
	            $newname = "image_file_".$date_pic.$file_ext;    //ชื่อไฟล์ ไหม่
                $uploadfile = $uploaddir.$newname; // path พร้อม newname ที่จะ upload
				   if(@copy($_FILES['file']['tmp_name'], $uploadfile)) { 	// upload to sever
					 @chmod($uploadfile,0777);							
					@unlink($uploaddir.$hfile);																	
					$hfile=$newname;
				 }  
			 }
			  $insert="Insert into  gen_user (emp_id,
			  													title_thai,
																name_thai,
																surname_thai,
																title_eng,
																name_eng,
																surname_eng,
																path_image,
																org_id,
																posittion,
																position_person,
																email_person,
																tel_in,
																officeaddress,
																emp_type_id,
																gen_user,
																gen_pass,
																org_type_id,
																last_update,
																gen_by,
																status,
																last_update_by,
																display_order,
																create_date)
		                                      	 Values('".$emp_id."','".$_POST['title_thai']."',
																  '".$_POST['name_thai']."',
																 '".$_POST['surname_thai']."', 
																 '".$_POST['title_eng']."',
																 '".$_POST['name_eng']."', 
																 '".$_POST['surname_eng']."', 
																 '$newname', 
																 '".$_POST['org_id']."', 
																 '".$_POST['posittion']."', 
																 '".$_POST['position_person']."', 
																 '".$_POST['email_person']."', 
																 '".$_POST['tel_in']."', 
																 '".$_POST['officeaddress']."', 
																 '".$_POST['emp_type_id']."', 
																 '".$_POST['gen_user']."', 
																 '".$_POST['gen_pass']."',
																 '".$_POST['txt_c']."',
																 NOW(),
																 '".$_SESSION['session_name']."',
																 '".$_POST['status']."',
																 '".$_SESSION['session_name']."',
																 '".$_POST['display_order']."',
																 NOW())";	
		$db->query($insert);
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$db->write_log("create","member","เพิ่มเจ้าหน้าที่ชื่อ".$_POST['name_thai'].'  '.$_POST['surname_thai']);
		$db->query("USE ".$EWT_DB_USER);
		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='MemberList.php';" ;
		echo "</script>";	
  }else if($_POST[proc]=='edit'){
  $emp_id2 = $_POST[cardW0].$_POST[cardW1].$_POST[cardW2].$_POST[cardW3].$_POST[cardW4];
 			if($_POST["delete_pictuer"]=='1'){
			@unlink($uploaddir.$hfile);																	
			$hfile2='';
			}
		  if($_FILES['file']){			  
			    $file_ext = strrchr(strtolower($_FILES['file']['name']),"."); // หา นามสกุล ของไฟล์
	            $newname = "image_file_".$date_pic.$file_ext;    //ชื่อไฟล์ ไหม่
                $uploadfile = $uploaddir.$newname; // path พร้อม newname ที่จะ upload
				   if(@copy($_FILES['file']['tmp_name'], $uploadfile)) { 	// upload to sever
					 @chmod($uploadfile,0777);							
					@unlink($uploaddir.$hfile);																	
					$hfile=$newname;
				 }  
			}
			
				$update="Update gen_user Set  emp_id = '$emp_id2',title_thai='".$_POST['title_thai']."',
														  name_thai='".$_POST['name_thai']."',
														  surname_thai='".$_POST['surname_thai']."',
														  title_eng='".$_POST['title_eng']."',
														  name_eng='".$_POST['name_eng']."',
														  surname_eng='".$_POST['surname_eng']."',
														  path_image='$hfile',
														  org_id='".$_POST['org_id']."',
														  posittion='".$_POST['posittion']."',
														  position_person='".$_POST['position_person']."',
														  email_person='".$_POST['email_person']."',
														  tel_in='".$_POST['tel_in']."',
														  officeaddress='".$_POST['officeaddress']."',
														  emp_type_id='".$_POST['emp_type_id']."',
														  last_update=NOW(),
														  last_update_by='".$_SESSION['session_name']."',
														  gen_user = '".$_POST["gen_user"]."',
														  gen_pass = '".$_POST["gen_pass"]."',
														  org_type_id = '".$_POST["txt_c"]."',
														  display_order = '".$_POST["display_order"]."',
														  status = '".$_POST["status"]."'
														  Where  gen_user_id='".$_POST["gen_user_id"]."' ";
	  		$db->query($update);
			$db->query("USE ".$_SESSION["EWT_SDB"]);
			$db->write_log("update","member","เแก้ไขเจ้าหน้าที่ชื่อ".$_POST['name_thai'].'  '.$_POST['surname_thai']);
			//update mail admin module ต่างๆ
			$update = "update email_config set email = '".$_POST['email_person']."' where link_id ='".$_POST["gen_user_id"]."'";
			$db->query($update);
			//end update
			$db->query("USE ".$EWT_DB_USER);
			$insert_history="insert into history (gen_user_id,status,edit_date,edit_by) values ('$id','edit', NOW(),'".$_SESSION["EWT_NAME"]."') ";		
     		$db->query($insert_history);
			
		echo "<script language=\"javascript\">";
		echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
		echo "window.close();";
		echo "</script>";	
 	}
 }
	$select_main="SELECT  * 
                          FROM
  `gen_user` Where  gen_user.gen_user_id='$gen_user_id' ";
	$exec_main = $db->query($select_main);
	$rst_main = $db->db_fetch_array($exec_main);
	$emp_id = $rst_main[emp_id];
	$title_thai=$rst_main[title_thai];
	$name_thai=$rst_main[name_thai];
    $surname_thai=$rst_main[surname_thai];
	$title_eng=$rst_main[title_eng];
	$name_eng=$rst_main[name_eng];
	$surname_eng=$rst_main[surname_eng];
	$path_image=$rst_main[path_image];
	if($path_image != ''){
	$path_image22 = $uploaddir.$path_image;
	if(file_exists($path_image22)){
	$path_image2 = $path_image22;
	}else{
	$path_image2 = "../images/ImageFile.gif";
	}
	}else{
	$path_image2 = "../images/ImageFile.gif";
	}
    $org_id=$rst_main[org_id];
    $posittion=$rst_main[posittion];
	$position_person=$rst_main[position_person];
    $email_person=$rst_main[email_person];
    $tel_in=$rst_main[tel_in];
	$officeaddress=$rst_main[officeaddress];
	$emp_type_id=$rst_main[emp_type_id];
	$gen_user=$rst_main[gen_user];
	$gen_pass=$rst_main[gen_pass];
	$gen_by=$rst_main[gen_by];
	$status=$rst_main[status];
	$last_update_by=$rst_main[last_update_by];
	$txt_c=$rst_main[org_type_id];
	$display_order=$rst_main[display_order];
if($_GET["proc"] == 'add'){
$lable = 'เพิ่ม';
}else{
$lable = 'แก้ไข';
}

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script src="ajax/AjaxRequest.js"></script>
<script src="ajax/excute.js"></script>
<script src="ajax/load_form.js"></script>
<script >
function close_div(divID) {
	var objDiv = document.getElementById(divID);
	
	objDiv.innerHTML = '' ; 
	objDiv.style.visibility = 'hidden';
	objDiv.style.width = 1;
	objDiv.style.height = 1;
	objDiv.style.top = 0;
	objDiv.style.left = 0;
}
function validLength(item,min,max){
			return (item.length >= min) && (item.length<=max)
}
function validEMail(mo){
		if (validLength(mo,1,50)){
			if (mo.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
				return true;
			else return false;
 		}
		return true;
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

function check_status( ){
	var req;
	if (window.XMLHttpRequest)
		req=new XMLHttpRequest();
	else if (window.ActiveXObject)
		req=new ActiveXObject("Microsoft.XMLHTTP");
	else{
		alert("Browser not support");
		return false;
	}
	req.onreadystatechange = function()
	{
		if (req.readyState==4) {
			var x=document.getElementById("viewdata");
			x.innerHTML=req.responseText;
			//document.getElementById("progress").innerHTML="";
		}
		else{
			var x=document.getElementById("viewdata");
			x.innerHTML="กรุณารอสักครู่...";
		}
	}
	var str=Math.random();
	var querystr="";
	
	var emp_type_id=document.frm.emp_type_id.value;
	
	querystr+="chack_date.php?pop="+str;
	querystr+="&emp_type_id="+emp_type_id;
	
	req.open("GET",  querystr  ,true);
	req.Send(null);
}


function chkinput(){
	var CardID=frm.cardW0.value+frm.cardW1.value+frm.cardW2.value+frm.cardW3.value+frm.cardW4.value;
	/*if(frm.cardW0.value=="" || frm.cardW1.value=="" || frm.cardW2.value=="" || frm.cardW3.value=="" || frm.cardW4.value=="" ){ 
		alert("กรุณากรอกรหัสบัตรประชาชน");
		//document.frm.emp_id.focus();
		return false;
	} 
	if(CardID.length < 13){
		alert("กรุณากรอกรหัสบัตรประชาชน");
		//document.frm.cardW0.focus();
		return false;
	}*/
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
	if(frm.org_name.value==""){ 
			alert("กรุณาเลือกหน่วยงาน");
			document.frm.org_name.focus();
			return false;
	} 	
	
/*		if(frm.email_person.value==""){ 
			alert("กรุณาใส่ e - mail");
			document.frm.email_person.focus();
			return false;
	}*/
	if(frm.email_person.value != '' && !validEMail(frm.email_person.value.toLowerCase())){
		
						alert('กรุณากรอกรูปแบบ Email  ให้ถูกต้อง')
						frm.email_person.focus()
						frm.email_person.select()
						return false;
	}
	if(frm.tel_in.value!="" && isNaN(frm.tel_in.value)){ 
			alert("กรุณากรอกหมายเลขติดต่อให้ถูกต้อง");
			document.frm.tel_in.focus();
			return false;
	}
	if(frm.emp_type_id.value==""){ 
			alert("กรุณาเลือกกลุ่ม");
			document.frm.emp_type_id.focus();
			return false;
	}
	if(frm.gen_user.value==""){ 
			alert("กรุณากรอก Username");
			document.frm.gen_user.focus();
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
	
	if(frm.status.value==""){ 
			alert("กรุณาเลือก Status");
			document.frm.status.focus();
			return false;
	}

	
	//document.frm.proc_action.value = 'add';	
	return true;
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
  // what to display when the image is not valid
var defaultPic="../images/ImageFile.gif";

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
	document.frm.previewField.value = '';
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
// End -->

 function isNum (charCode) 
   {
       if (charCode >= 48 && charCode <= 57 )
	       return true;
      else
	     return false;
   }
 function chkFormatNam (str) {//0-9
  strlen = str.length;
  for (i=0;i<strlen;i++)
  {
      var charCode = str.charCodeAt(i);
	  if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
		  return false;
	  }
   }
   return true;
}
function chkformatnum(t){ 
		_MyObj = t;
		_MyObj_Name = t.name;
		_MyObj_Value = t.value;
		_MyObj_Strlen =_MyObj_Value.length; 
		//if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
	//		t.value = _MyObj_Value.substr(1);
		//}
		if(!chkFormatNam (t.value)){
				alert('กรุณากรอกด้วยตัวเลขเท่านั้น');
				t.value = 0;
				t.focus();
	} 
}
function chk_status(t){
document.frm.title_thai.value = t.value;
	if(document.frm.title_thai.value == ''){
		var url = 'ajax/title.php?title_id='+t.value+'';
		load_divForm(url,'div_title_thai','')
	}
}
</script>


<script >
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
function txt_data() {
	var mytop = findPosY(document.frm.org_name) +document.frm.org_name.offsetHeight;
	var myleft = findPosX(document.frm.org_name);	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	if(document.frm.org_name.value ==''){
	document.frm.posittion.style.display ='' ; 
	}else{
	document.frm.posittion.style.display ='none' ; 
	}
	url='nav_pad2.php';

					
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					document.frm.posittion.style.display ='none' ; 
					document.frm.emp_type_id.style.display ='none' ; 
					
			}
		}
	);
	
}

					function expend(obj_index,img){
					var index_obj = new Array();
					var obj = "";
					index_obj = document.getElementById("index_obj").value;
					obj = document.getElementById("objects2").value;
					var object1 = eval('['+obj+']');
					var object = object1[0];
						var object_index = "_"+obj_index;
						var object_chk = eval("object."+object_index);
						if(img.src.search("minus.gif") != -1) img.src = "../images/plus.gif";
						else  img.src = "../images/minus.gif";
						
						for(var i_exp = 0;i_exp < object_chk.length;i_exp++){
							var object_chk2 = eval("object._"+object_chk[i_exp]);
							chk_expand("img_"+object_chk[i_exp],object,object_chk2);
							if(document.getElementById("tr_"+object_chk[i_exp]).style.display != "none") 
							document.getElementById("tr_"+object_chk[i_exp]).style.display = "none";
							else
							document.getElementById("tr_"+object_chk[i_exp]).style.display = "";
						}
					}

					function chk_expand(id_img,object,object_chk2){
						if(  object_chk2 ){
								if(object_chk2.length > 0){
									if(document.getElementById(id_img).src.search("plus") != -1){
										for(var i_exp2 = 0;i_exp2 < object_chk2.length;i_exp2++){
											if(document.getElementById("tr_"+object_chk2[i_exp2]).style.display == "none") 
											document.getElementById("tr_"+object_chk2[i_exp2]).style.display = "";
											var object_chk3 = eval("object._"+object_chk2[i_exp2]);
											chk_expand("img_"+object_chk2[i_exp2],object_chk3);
										}
									}
								}
							}
					}
</script>

<style type="text/css">
<!--
.style10 {color: #FF0000}
-->
</style>
</head>

<body>
<?php include("../FavoritesMgt/favorites_include.php");?>

<?php
include('top.php');
?>
<form name="frm"  action=""  method="post"  enctype="multipart/form-data">
  
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
<tr>
<td>
<img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
<span class="ewtfunction"><a href="MemberList.php" target="member_body"><?php echo $lable;?>ข้อมูลบุคลากร</a> 
</span> 
</td>
</tr>
</table>
  
  
<?php 
  if($_GET["proc"]=='edit'){
  $linkk = "frm_add_member.php?gen_user_id=".$_GET["gen_user_id"]."&emp_id=".$_GET["emp_id"]."&proc=edit";
  $typelink ="&type=popup";
  }else{
    $linkk = "frm_add_member.php?proc=add";
	$typelink ="";
  }
?>

<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable."ข้อมูลบุคลากร".$name_thai);?>&module=org<?php echo $typelink;?>&url=<?php echo urlencode($linkk);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($_GET[proc]!='edit'){ ?>&nbsp;<a href="MemberList.php"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> 
     กลับ</a><?php } ?>
        <hr>
      </td>
    </tr>
</table>

<table width="100%" class="table table-bordered">
<tr class="ewttablehead">
<td height="30" colspan="3">ข้อมูลบุคลากร </td>
    </tr>
	<tr><td width="31%" height="30" bgcolor="#FFFFFF">&nbsp;รหัสบัตรประชาชน : </td>
	<td align="left" bgcolor="#FFFFFF" colspan="2"><input name="cardW0"  type="text"  id="cardW0"  class="textinput"  size="1" maxlength="1" value="<?php echo substr($emp_id,0,1)?>"  onKeyDown="return chkformatnum(this);" onKeyUp=" if(this.value.length==1){this.form.cardW1.value='';this.form.cardW1.focus();}">
	-
	<input name="cardW1"  type="text"  id="cardW1" class="textinput"  size="4" maxlength="4" value="<?php echo substr($emp_id,1,4)?>" onKeyDown="return chkformatnum(this);" onKeyUp="if(this.value.length==4){this.form.cardW2.value='';this.form.cardW2.focus();}">
	-
	<input name="cardW2"  type="text"  id="cardW2" class="textinput" size="5" maxlength="5" value="<?php echo substr($emp_id,5,5)?>" onKeyDown="return chkformatnum(this);" onKeyUp="if(this.value.length==5){this.form.cardW3.value='';this.form.cardW3.focus();}">
	-
	<input name="cardW3"  type="text" id="cardW3" class="textinput" size="2" maxlength="2" value="<?php echo substr($emp_id,10,2)?>" onKeyDown="return chkformatnum(this);" onKeyUp="if(this.value.length==2){this.form.cardW4.value='';this.form.cardW4.focus();}">
	-
	<input name="cardW4"  type="text"  id="cardW4" class="textinput" size="1" maxlength="1" value="<?php echo substr($emp_id,12,1)?>" onKeyDown="return chkformatnum(this);" onKeyUp="if(this.value.length==1){if(!chkIDcard(this.form.cardW0.value,this.form.cardW1.value,this.form.cardW2.value,this.form.cardW3.value,this.form.cardW4.value,this.form)){ alert('รหัสบัตรประขาชนไม่ถูกต้อง');this.form.cardW0.value='';this.form.cardW0.focus();}else{};}"></td>
	</tr>
    <tr>
      <td width="31%" bgcolor="#FFFFFF" >คำนำหน้า : <font color="#FF0000">*</font></td>
      <td bgcolor="#FFFFFF"><?php  if($_SESSION['session_levelid']==1 || true){?>
	  <div id="div_title_thai">
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
          </select>
	    </div>
          <?php }else{ echo $title_name_thai; ?>
          <input name="title_thai" type="hidden" id="title_thai" value="<?php echo $title_thai;?>" size="20" />
      <?php }?>      </td>
      <td width="20%" rowspan="3" align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php echo $path_image2; ?>" name="previewField" width="98" height="98"   id="previewField"  border="0"/> <br/>
          <br/>
          <?php  if($proc=='edit'){?>
          <input type="checkbox" name="delete_pictuer" value="1"  onclick="show_mage();"/ >
        ลบรูปภาพ
        <?php }?>
        <script language="javascript">
					function show_mage(){
					if(frm.delete_pictuer.checked==true){
					 document.getElementById("previewField").style.display='none';
					}else{
					 document.getElementById("previewField").style.display='';
					  }
					}
					</script>      </td>
    </tr>
    
    <tr>
      <td height="25" bgcolor="#FFFFFF" >ชื่อ : <font color="#FF0000">*</font></td>
      <td bgcolor="#FFFFFF"><input name="name_thai" type="text" id="name_thai"  value="<?php echo $name_thai;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?> /></td>
    </tr>
    <tr>
      <td height="24" bgcolor="#FFFFFF" >สกุล : <font color="#FF0000">*</font></td>
      <td height="24" bgcolor="#FFFFFF"><input name="surname_thai" type="text" id="surname_thai"  value="<?php echo $surname_thai;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
    </tr>
    <tr style="display:none">
      <td bgcolor="#FFFFFF" >คำนำหน้าภาษาอักกฤษ : </td>
      <td bgcolor="#FFFFFF"><?php  if($_SESSION['session_levelid']==1 || true){?>
          <select name="title_eng" id="title_eng" onChange="chk_status(this);">
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
          </select>
          <?php }else{ echo $title_name_thai; ?>
          <input name="title_thai" type="hidden" id="title_thai" value="<?php echo $title_thai;?>" size="20" />
      <?php }?>      </td>
      <td width="20%" align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>

  <tr style="display:none">
      <td height="25" bgcolor="#FFFFFF" >ชื่อภาษาอังกฤษ :</td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="name_eng" type="text" id="name_eng"  value="<?php echo $name_eng;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
    </tr>
   <tr style="display:none">
      <td height="25" bgcolor="#FFFFFF" >สกุลภาษาอังกฤษ :</td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="surname_eng" type="text" id="surname_eng"  value="<?php echo $surname_eng;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
    </tr>
    <tr>
      <td height="12" bgcolor="#FFFFFF" >รูปภาพ :</td>
      <td colspan="2" bgcolor="#FFFFFF"><?php  if($_SESSION['session_levelid']==1 || true){   //onchange="preview(this)"  ?>
          <input name="file" type="file"  id="picField"    value="" size="50"  />
          <input name="hfile" type="hidden" value="<?php echo $path_image?>" />
          <?php }else{ ?>
          <input name="hfile" type="hidden" value="<?php echo $path_image?>" /></td>
      <?php }?>
    </tr>
	
    <tr>
      <td height="12" bgcolor="#FFFFFF">หน่วยงาน : <font color="#FF0000">*</font> </td>
      <td colspan="2" bgcolor="#FFFFFF"><div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
	  <?php
	  $sql_unit = $db->query("SELECT * FROM org_name where org_id='".$org_id."'");
	  $rec_unit = $db->db_fetch_array($sql_unit);
	  ?>
	  <input name="org_id" type="hidden" value="<?php echo $org_id;?>"><input name="org_name" type="text" id="org_name"  value="<?php echo $rec_unit[name_org]; ?>" size="50" autocomplete="off" readonly="" >
	  <!--<select name="org_id"  id="org_id" >
                      <option value=""></option>
                       <?php 
			/*		  $sql_unit = $db->query("SELECT * FROM org_name ");
					  while($rec_unit = $db->db_fetch_array($sql_unit)){
					  $count_level = explode("_",$rec_unit[parent_org_id]);
					  $tab = "";
					  		for($i = 2 ;$i<count($count_level);$i++){
								$tab= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							}
					  if($rec_unit[org_id] == $org_id) $selected_unit = "selected";
							else $selected_unit = "";
							print '<option value="'.$rec_unit[org_id].'" '.$selected_unit.'>'.$tab.$rec_unit[name_org].'</option>';
					  } */
					  ?>
        </select>-->
<a href="#data" onClick="txt_data()"><img src="../images/folder_closed.gif" name="showdata" width="16" height="16"  border="0" title="คลิกเลือกหน่วยงาน"></a></td>
    </tr>
    <tr>
      <td height="12" bgcolor="#FFFFFF" >ตำแหน่งภายในหน่วยงาน :  </td>
      <td colspan="2" bgcolor="#FFFFFF">
        <select name="posittion"  id="posittion"  style="display:">
          <option value=""></option>
          <?php 
					//pos_name
					$sql_position = $db->query("select * from position_name ORDER BY pos_level,pos_name ASC ");
					 while($rec_position = $db->db_fetch_array($sql_position)){
					  if($rec_position[pos_id] ==  $posittion) $selected_position= "selected";
							else $selected_position = "";
							print '<option value="'.$rec_position[pos_id].'" '.$selected_position.'>'.$rec_position[pos_name].'</option>';
					  }
					?>
        </select>      </td>
    </tr>
    <tr>
      <td height="5" bgcolor="#FFFFFF" >ตำแหน่งทางวิชาการ : </td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="position_person" type="text" size="30" value="<?php echo $position_person;?>"></td>
    </tr>
	<tr>
      <td height="6" bgcolor="#FFFFFF" >ลำดับในการแสดงผล </td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="display_order" type="text" id="display_order" size="5" maxlength="2" value="<?php echo $display_order;?>" onKeyUp="chkformatnum(this)"></td>
    </tr>
    <tr>
      <td height="6" bgcolor="#FFFFFF" >ระดับ (ซี) </td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="txt_c" type="text" id="txt_c" size="5" maxlength="2" value="<?php echo $txt_c;?>" onKeyUp="chkformatnum(this)"></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" >Email  :</td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="email_person" type="text" id="email_person" value="<?php echo $email_person;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/></td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" >เบอร์ต่อ : </td>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><input name="tel_in" type="text" id="tel_convenient" value="<?php echo $tel_in;?>" size="50" class="<?php echo $text_read;?>" <?php echo $close_text;?>/>
      <br>
<span class="style10">      ex. 0819999999 or 028888888 </span></td>
    </tr>

    <tr>
      <td height="20" valign="top" bgcolor="#FFFFFF" >สถานที่ทำงาน :</td>
      <td colspan="2" bgcolor="#FFFFFF"><textarea name="officeaddress" cols="50" rows="5" id="officeaddress"><?php echo $officeaddress;?>
  </textarea></td>
    </tr>
    <tr id="t1"  >
      <td height="25" bgcolor="#FFFFFF" >กลุ่ม : <font color="#FF0000">*</font></td>
      <td colspan="2" bgcolor="#FFFFFF"><?php  if($_SESSION['session_levelid']==1 || true){?>
          <select name="emp_type_id" id="emp_type_id" >
		  <option value="">--โปรดเลือก--</option>
            <?php 
						$sql_emp_type = "SELECT * FROM emp_type WHERE emp_type_status = '2' ";
						$query_emp_type = $db->query($sql_emp_type);
						while($rs_emp_type = $db->db_fetch_array($query_emp_type)){
							if($rs_emp_type[emp_type_id] == $emp_type_id) $selected_emp_type = "selected";
							else $selected_emp_type = "";
							print '<option value="'.$rs_emp_type[emp_type_id].'" '.$selected_emp_type.'>'.$rs_emp_type[emp_type_name].'</option>';
						}
					?>
          </select>
          
          <?php }?></td>
    </tr>
    <?php if($_SESSION['session_levelid']==1 || true){?>
    <tr>
      <td height="25" bgcolor="#FFFFFF" >ชื่อผู้ใช้ : <font color="#FF0000">**</font></td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="gen_user" type="text" id="gen_user" value="<?php echo $gen_user;?>" size="30"   />
          <?php if($_GET[gen_user_id]){?>
          <input name="old_gen_user" type="hidden" value="<?php echo $gen_user;?>" />
          <?php }?>      </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" >รหัสผ่าน : <font color="#FF0000">**</font></td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="gen_pass" type="password" id="gen_pass" value="<?php echo $gen_pass;?>" size="30"/>      </td>
    </tr>
    <tr>
      <td height="25" bgcolor="#FFFFFF" >ยืนยันรหัสผ่าน : <font color="#FF0000">**</font></td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="re_gen_pass" type="password" id="re_gen_pass" value="<?php echo $gen_pass;?>" size="30"/>      </td>
    </tr>
    <?php }else{ ?>
    <input name="gen_user" type="hidden" id="gen_user" value="<?php echo $gen_user;?>" size="30"   />
    <input name="gen_pass" type="hidden" id="gen_pass" value="<?php echo $gen_pass;?>" size="30" />
    <?php }?>
    <tr  style="display:none" >
      <td height="25" bgcolor="#FFFFFF" >&nbsp;Created by :</td>
      <td colspan="2" valign="middle" bgcolor="#FFFFFF"><input name="gen_by" type="text" class="inputField" id="gen_by"  value="<?php echo $EWT_FOLDER_USER;//$gen_by; ?>" size="50"/ readonly /></td>
    </tr>
    <tr style="display:none" >
      <td height="25" bgcolor="#FFFFFF" >&nbsp;Created Date : </td>
      <td colspan="2" bgcolor="#FFFFFF"><?php 
					if($create_date==''){
					   $create_date=date('d/m/').(date('Y')+543);
					   }else{
					   $create_date=$create_date;
					   }
					?>
          <input name="date_creat" type="text" class="inputField" id="date_creat"  value="<?php echo $create_date;?>" size="50"  readonly="readonly"/></td>
    </tr>
    <tr  style="display:none" >
      <td height="25" bgcolor="#FFFFFF" >&nbsp;Updated by :</td>
      <td colspan="2" bgcolor="#FFFFFF"><input name="last_update_by" type="text" class="inputField" id="last_update_by"  value="<?php echo $EWT_FOLDER_USER;//$last_update_by; ?>" size="50"/ readonly /></td>
    </tr>
    <tr  style="display:none" >
      <td height="25" bgcolor="#FFFFFF" >&nbsp;Last Update date : </td>
      <td colspan="2" bgcolor="#FFFFFF"><?php 
					if($last_update==''){
					   $last_update=date('d/m/').(date('Y')+543);
					  }else{
					   $last_update=$last_update;
					  }
					?>
          <input name="last_update" type="text" class="inputField" id="last_update"  value="<?php echo $last_update;?>" size="50"  readonly="readonly"/></td>
    </tr>
    <tr >
      <td height="25" bgcolor="#FFFFFF" >สถานะ : <font color="#FF0000">*</font>      </td>
      <td colspan="2" bgcolor="#FFFFFF"><?php  if($_SESSION['session_levelid']==1 || true){?>
          <select name="status" id="status" <?php echo $close_select?>>
            <option value="1" <?php if($status==1){ echo "selected";}?>>ใช้งาน</option>
            <option value="2" <?php if($status==2){ echo "selected";}?>>ไม่ใช้งาน</option>
          </select>
          <?php }else{
					 if($status==1){
					    echo $status_name="ใช้งาน";
					  }else if($status==2){
					   echo  $status_name="ไม่ใช้งาน";
					 } ?>
          <input name="status" type="hidden" id="status" value="<?php echo $status;?>" size="30" />
          <?php }?>      </td>
    </tr>
    <?php if(false){?>
    <tr  id="result" style="display:none" >
      <td height="25" bgcolor="#FFFFFF" >&nbsp;Expiredate : </td>
      <td height="25" colspan="2" bgcolor="#FFFFFF"><div id="viewdata">
          <?php if($expiredate!=''){?>
          <input name="expiredate" type="text"  id="expiredate"  value="<?php echo $expiredate;?>" size="12"  class="<?php echo $text_read;?>" <?php echo $close_text;?>/>
          <?php  if($_SESSION['session_levelid']==1){?>
          <img id="cld2" src="../images/cal_24.gif" alt="เปิดปฏิทิน" width="24" height="24" align="absmiddle" class="imgcalendar" style="cursor:pointer" onClick="return showCalendar('expiredate', 'dd/mm/yy');" />
          <?php }?>
          <?php }else{ echo "-";}?>
      </div></td>
    </tr>
    <?php }?>
    <tr>
      <td colspan="3" align="center" bgcolor="#FFFFFF" id="show_status"><input name="save" type="submit" class="submit" id="save" value="บันทึก"  onClick="return chkinput(); "/>
          <input type="hidden" name="proc_action" value="">
          <input name="Submit2" type="button" class="submit" value="ยกเลิก" style="width:80"  onclick="window.location.href='MemberList.php';"/>
          <input name="proc" type="hidden" value="<?php echo $_GET["proc"];?>">
          <input type="hidden" name="gen_user_id" value="<?php echo $_GET[gen_user_id]?>" /></td>
    </tr>
  </table>
</form>
<?php
include('footer.php');
?>
</body>
</html>

<?php
$db->db_close(); 
?>

