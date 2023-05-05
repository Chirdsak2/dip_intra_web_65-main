<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	@include("language/language.php");
	$db->query("USE ".$EWT_DB_USER);
	if($_GET["flag"] =='accept'){
		$update = "update gen_user set  status = '1' where emp_id = '".$_GET[id]."'";
		$db->query($update);
		echo "<script language=\"javascript\">";
		echo "alert('ยืนยันการเป็นสมาชิกเรียบร้อยแล้ว');";
		echo "document.location.href='main.php?filename=index'" ;
		echo "</script>";	
	}
	if($_POST["flag"]=='add'){
		$emp_id = $_POST[cardW0].$_POST[cardW1].$_POST[cardW2].$_POST[cardW3].$_POST[cardW4];
		
		$check_emp="Select * From  gen_user Where emp_id='$emp_id' ";
		$exec_emp= $db->query($check_emp);
		$row_emp = $db->db_num_rows($exec_emp);		
		if($row_emp){  
			?>
				<script language="javascript">
					alert("รหัสบัตรประชาชนหมายเลข <?php echo $emp_id;?> ซ้ำในระบบกรุณากรอกใหม่");
					document.location.href="frm_gen_user.php";
				</script>
			<?php
			exit;
		}
		$check_user="Select * From  gen_user Where gen_user='$gen_user' ";
		$exec_user= $db->query($check_user);
		$row_user= $db->db_num_rows($exec_user);		
		if($row_user){  
			?>
				<script language="javascript">
					alert('Username <?php echo $gen_user;?> ซ้ำในระบบกรุณากรอกใหม่');
					document.location.href='frm_gen_user.php';
				</script>
			<?php
			exit;
		}
		//$expiredate=$_POST['expiredate'];
		$last_update=date('d/m/').(date('Y')+543);
		$insert="
			Insert into  gen_user (
				emp_id,title_thai,name_thai,surname_thai,
				title_eng,name_eng,surname_eng,email_person,
				mobile,officeaddress,emp_type_id,gen_user,
				gen_pass,last_update,gen_by,status,
				expiredate,level_id,last_update_by,create_date,web_use)
			Values(
				'".$emp_id."', '".$_POST['title_thai']."', '".$_POST['name_thai']."', '".$_POST['surname_thai']."',
				'".$_POST['title_eng']."','".$_POST['name_eng']."', '".$_POST['surname_eng']."','".$_POST['email_person']."', 
				'".$_POST['mobile']."', '".$_POST['officeaddress']."','".$_POST['emp_type_id']."' , '".$_POST['gen_user']."', 
				'".$_POST['gen_pass']."',NOW(),'".$_SESSION['session_name']."','2',
				'$expiredate','4','".$_SESSION['session_name']."',NOW(),'".$EWT_FOLDER_USER."')";			  

		$db->query($insert);
		$select_max="select  MAX(gen_user_id) as gen_user_id,name_thai,surname_thai from  gen_user group by name_thai,surname_thai";	
		$query_max=$db->query($select_max);	
		$rst_max=$db->db_fetch_array($query_max);
		$gen_user_id_new=$rst_max[gen_user_id];
		$name = $rst_max["name_thai"]." ".$rst_max["surname_thai"];
		$insert_history="insert into history (gen_user_id,status,edit_date,edit_by) values ('".$gen_user_id_new."','add', NOW(),'".$name ."') ";		
		$db->query($insert_history);

		//sand mail
		$message = '
			<html>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<head></head>
				<body>
					<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
					<tr> 
						<td   valign="middle">
							<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
								<tr> 
									<!--<td width="5" height="100%" background="mainpic/bg_l.gif"></td> -->
									<td valign="middle" bgcolor="FFFFFF"><br>
									  <br>
										<table width="776" height="80%" border="0" cellpadding="2" cellspacing="0" bgcolor="B4BDC7">
											<tr><td width="772" bgcolor="#FFFFFF"><font color="#666666" size="2" face="Tahoma"><strong>เรียนท่านสมาชิก</strong></font></td>
										</tr>
											<tr> 
												<td bgcolor="#FFFFFF"><font color="#666666" size="2" face="Tahoma"><strong>&nbsp;&nbsp;ท่านจำเป็นต้องส่งเอกสารเพื่อยืนยันการสมัครสมาชิก!</strong></font><br>
													<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
														<tr><td bgcolor="#DBDBF2"><font color="#666666" size="2" face="Tahoma">เพื่อความปลอดภัยในกรณีที่มีบุคคลแอบอ้างชื่อของท่านในการสมัครเข้ามาเป็นสมาชิกเว็บไซต์ของ'.$txt_website_of_name2.'<br>ทางผู้ดูแลระบบใคร่ขอรบกวนท่านในการส่งเอกสารบัตรประชาชนเพื่อยืนยันตัวท่านเองมายัง'.$txt_website_of_name2.' ที่หมายเลข'.$txt_website_of_name3.'<br><br>
																	</font><font size="2" face="Tahoma" color="#FF0000"><strong>หมายเหตุ:&nbsp;</strong></font><font color="#666666" size="2" face="Tahoma">กรุณาระบุด้วยว่า </font><font size="2" face="Tahoma"><strong>"สมัครสมาชิกเว็บไซต์"</strong></font><font color="#666666" size="2" face="Tahoma"> ผู้ดูแลระบบจะทำการเปิดบัญชีการใช้งานให้แก่ท่านภายใน 2 วันทำการ ขออภัยในความไม่สะดวก และขอขอบพระคุณในความร่วมมือของท่าน</font>
																	<br>
																	<br>
													<font color="#666666" size="4" face="Tahoma"><strong>'.$txt_website_of_name4.'
													</strong></font><br></td></tr>
												  </table>
																						<br />
											  </td>
										  </tr>
									  </table>
								  </td>
																		<!--<td width="5" height="100%" background="mainpic/bg_r.gif"></td> -->
							  </tr>
																</table>
															</td>
														</tr>
													</table>
				</body>
			</html>';
		/* subject */
		$subject = $txt_website_of_name5;

		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";

		/* additional headers */
		$headers .= "From: Member System \r\n";
		$mail_to = $_POST[email_person];
		@mail($mail_to, $subject, $message, $headers);
		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		//echo "window.open('frm_gen_user2.php','','width=500 , height=400, scrollbars=0,resizable = 0');";
		//echo "alert('กรุณาตรวจสอบ e-mail ของท่านเพื่อยืนยันการเป็นสมาชิก');";
		//echo "document.location.href='main.php?filename=index'" ;
		echo "document.location.href='frm_gen_user2.php?filename=index'" ;
		echo "</script>";	
	}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>สมัครสมาชิก</title>
<script language="javascript" src="js/functions.js"></script>
<script src="js/AjaxRequest.js"></script>
<script src="js/excute.js"></script>
<script language="javascript">
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

function validLength(item,min,max){
	return (item.length >= min) && (item.length<=max)
}

function valid2EMail(mailObj){
	if (validLength(mailObj.value,1,50)){
		//return false;
		if (mailObj.value.search("^.+@.+\\..+$") != -1)
			return true;
		else return false;
	}
	return true;
}

function validEMail(mailObj){
	if (validLength(mailObj.value,1,50)){
		//return false;
		if (mailObj.value.search("^.+@.+\(\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)$") != -1)
			return true;
		else return false;
	}
	return true;
}

function chkinput(){
	
	var CardID=frm.cardW0.value+frm.cardW1.value+frm.cardW2.value+frm.cardW3.value+frm.cardW4.value;
	if(frm.cardW0.value=="" || frm.cardW1.value=="" || frm.cardW2.value=="" || frm.cardW3.value=="" || frm.cardW4.value=="" ){ 
		alert("กรุณากรอกรหัสบัตรประชาชน");
		//document.frm.emp_id.focus();
		return false;
	} 
	if(CardID.length < 13){
		alert("กรุณากรอกรหัสบัตรประชาชน");
		//document.frm.emp_id.focus();
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
	if(frm.email_person.value == ""){
		alert('กรุณากรอกรูปแบบ Email  ให้ถูกต้อง')
		frm.email_person.focus()
		frm.email_person.select()
		return false;
	}	
	if(frm.email_person.value != "" && !validEMail(frm.email_person)){
		alert('กรุณากรอกรูปแบบ Email  ให้ถูกต้อง')
		frm.email_person.focus()
		frm.email_person.select()
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
document.getElementById('t1').style.display ='none' ; 
	document.getElementById('t2').style.display ='none' ; 
	document.getElementById('t3').style.display ='none' ; 
	document.getElementById('previewDiv').style.display ='' ; 
}// end check_input

function chk_status(t){
	document.frm.title_thai.value = t.value;
	if(document.frm.title_thai.value == ''){
		var url = 'js/title.php?title_id='+t.value+'';
		load_divForm(url,'div_title_thai','')
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

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr> 
		<td  align="center" valign="top">
			<table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
				<tr> 
					<td width="5" height="100%" background="mainpic/bg_l.gif"></td>
					<td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
<tr> 
<td valign="top" bgcolor="#FFFFFF"><br>
<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
<tr>
<td bgcolor="#DBDBF2"><font color="#666666" size="4" face="Tahoma"><strong>สมัครสมาชิก</strong></font></td>
</tr>
</table>
<div id="previewDiv" style="position:absolute; display:none" align="center">
	  <table width="780" height="480"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" >
        <tr>
          <td align="center" bgcolor="#FFFFFF"><img src="mainpic/loading.gif" /></td>
        </tr>
      </table></div>
<br />
<form name="frm"  action=""  method="post"  enctype="multipart/form-data">
<input name="flag" type="hidden" value="add">
<table width="90%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td width="100%" align="center"></td>
</tr>
<tr>
<td height="30">
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<td bgcolor="#FFFFFF"><br />
	
<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1">
<td width="31%" height="30">&nbsp;รหัสบัตรประชาชน : <span class="style10">*</span></td>
<td align="left"><input name="cardW0"  type="text"  id="cardW0"  class="textinput"  size="1" maxlength="1" value="<?php echo substr($emp_id,0,1)?>" onKeyPress="return NumberOnly();" onKeyUp=" if(this.value.length==1){this.form.cardW1.value='';this.form.cardW1.focus();}">
-
<input name="cardW1"  type="text"  id="cardW1" class="textinput"  size="4" maxlength="4" value="<?php echo substr($emp_id,1,4)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==4){this.form.cardW2.value='';this.form.cardW2.focus();}">
-
<input name="cardW2"  type="text"  id="cardW2" class="textinput" size="5" maxlength="5" value="<?php echo substr($emp_id,5,5)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==5){this.form.cardW3.value='';this.form.cardW3.focus();}">
-
<input name="cardW3"  type="text" id="cardW3" class="textinput" size="2" maxlength="2" value="<?php echo substr($emp_id,10,2)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==2){this.form.cardW4.value='';this.form.cardW4.focus();}">
-
<input name="cardW4"  type="text"  id="cardW4" class="textinput" size="1" maxlength="1" value="<?php echo substr($emp_id,12,1)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==1){if(!chkIDcard(this.form.cardW0.value,this.form.cardW1.value,this.form.cardW2.value,this.form.cardW3.value,this.form.cardW4.value,this.form)){ alert('รหัสบัตรประขาชนไม่ถูกต้อง');this.form.cardW0.value='';this.form.cardW0.focus();}else{};}"></td>
</tr>
<tr id="t1">
<td height="30">&nbsp;คำนำหน้า : <span class="style10">*</span></td>
<td align="left"> <div id="div_title_thai">
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
</div></td>
</tr>
<tr>
<td height="30">&nbsp;ชื่อ : <span class="style10">*</span></td>
<td align="left"><input name="name_thai" type="text" id="name_thai"  value="<?php echo $name_thai;?>" size="50" ></td>
</tr>
<tr>
<td height="30">&nbsp;สกุล : <span class="style10">*</span></td>
<td align="left"><input name="surname_thai" type="text" id="surname_thai"  value="<?php echo $surname_thai;?>" size="50" ></td>
</tr>
<tr id="t2">
<td height="30">&nbsp;Title:</td>
<td align="left"><select name="title_eng" id="title_eng" onChange="chk_status(this);">
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
<td height="30">&nbsp;Name :</td>
<td align="left"><input name="name_eng" type="text" id="name_eng"  value="<?php echo $name_eng;?>" size="50"></td>
</tr>
<tr>
<td height="30">&nbsp;Surname :</td>
<td align="left"><input name="surname_eng" type="text" id="surname_eng"  value="<?php echo $surname_eng;?>" size="50"></td>
</tr>
<tr>
<td height="30">&nbsp;Email : <span class="style10">*</span></td>
<td align="left"><input name="email_person" type="text" id="email_person" value="<?php echo $email_person;?>" size="50"></td>
</tr>
<tr>
<td height="30">&nbsp;เบอร์มือถือ :</td>
<td align="left"><input name="mobile" type="text" id="mobile" value="<?php echo $mobile;?>" size="50" ></td>
</tr>
<tr>
<td height="30">&nbsp;สถานที่ทำงาน :</td>
<td align="left"><textarea name="officeaddress" cols="50" rows="5" id="officeaddress"><?php echo $officeaddress;?></textarea></td>
</tr>
<tr id="t3">
<td height="30">&nbsp;สถานะ :</td>
<td align="left"><select name="emp_type_id" id="emp_type_id" >
<?php 
$sql_title = "SELECT * FROM emp_type where emp_type_status ='4'";
$query_title = $db->query($sql_title);
while($rs_title = $db->db_fetch_array($query_title)){
print '<option value="'.$rs_title[emp_type_id].'">'.$rs_title[emp_type_name].'</option>';
}
?>
</select></td>
</tr>
<tr>
<td height="30">&nbsp;Username :<span class="style10">**</span></td>
<td align="left"><input name="gen_user" type="text" id="gen_user" value="<?php echo $gen_user;?>" size="30" ></td>
</tr>
<tr>
<td height="30">&nbsp;Password : <span class="style10">**</span></td>
<td align="left"><input name="gen_pass" type="password" id="gen_pass" value="<?php echo $gen_pass;?>" size="30"/></td>
</tr>
<tr>
<td height="30">&nbsp;Re Password : <span class="style10">**</span></td>
<td align="left"><input name="re_gen_pass" type="password" id="re_gen_pass" value="<?php echo $gen_pass;?>" size="30"/></td>
</tr>
<tr bgcolor="#DBDBF2">

<td height="25" colspan="2" align="center" id="show_status"><input name="save" type="submit" class="submit" id="save" value="บันทึก" onClick="return chkinput(); " />
<input name="Submit2" type="button" class="submit" value="ยกเลิก" style="width:80"  onclick="window.location.href='main.php?filename=index';"/>
</td>
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
