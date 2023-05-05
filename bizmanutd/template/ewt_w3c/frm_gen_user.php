<?php
header ("Content-Type:text/html;charset=UTF-8");
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	@include($path."language/language".$lang_sh.".php");
	include("ewt_template.php");
	$db->access=200;
	
	$db->query("USE ".$EWT_DB_USER);
	    //ewt_user info
	//echo "select url from user_info where EWT_User='".$EWT_FOLDER_USER."'";
	$sql_U=$db->query("select url from user_info where EWT_User='".$EWT_FOLDER_USER."'");
	$RU = $db->db_fetch_array($sql_U);
	$url = $RU[url];
if($_GET["flag"] =='accept'){
		$usid = base64_decode ($_GET[uid]);
		$db->query("UPDATE gen_user SET status='1' where gen_user_id = '".$usid."'");
		echo "<script language=\"javascript\">";
		echo "alert('ยืนยันการเป็นสมาชิกเรียบร้อยแล้ว');";
		echo "document.location.href='".$url."ewt_w3c/'" ;
		echo "</script>";	
		exit;
	}
	if($_POST["flag"]=='add'){
		$emp_id = $_POST[cardW0].$_POST[cardW1].$_POST[cardW2].$_POST[cardW3].$_POST[cardW4];
		
		$check_emp="Select * From  gen_user Where emp_id='$emp_id' and web_use = '$EWT_FOLDER_USER' ";
		$exec_emp= $db->query($check_emp);
		$row_emp = $db->db_num_rows($exec_emp);		
		if($row_emp){  
			?>
				<script language="javascript">
					alert("รหัสบัตรประชาชนหมายเลข <? echo $emp_id;?> ซ้ำในระบบกรุณากรอกใหม่");
					document.location.href="frm_gen_user.php?filename=<?php echo $_POST[filename];?>";
				</script>
			<?
			exit;
		}
		$check_user="Select * From  gen_user Where gen_user='$gen_user' and web_use = '$EWT_FOLDER_USER' ";
		$exec_user= $db->query($check_user);
		$row_user= $db->db_num_rows($exec_user);		
		if($row_user){  
			?>
				<script language="javascript">
					alert('Username <? echo $gen_user;?> ซ้ำในระบบกรุณากรอกใหม่');
					document.location.href='frm_gen_user.php?filename=<?php echo $_POST[filename];?>';
				</script>
			<?
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
		$select_max="select  gen_user_id,name_thai,surname_thai from  gen_user where emp_id ='$emp_id' and  gen_user.emp_type_id <> '1'";	
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
												<td bgcolor="#FFFFFF"><font color="#666666" size="2" face="Tahoma"><strong>&nbsp;&nbsp;ชื่อผู้ใช้ :'.$_POST['gen_user'].'<br>รหัสผ่าน :'.$_POST['gen_pass'].' </strong></font><br>
													<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
														<tr><td bgcolor="#DBDBF2"><font color="#666666" size="2" face="Tahoma">เจ้าหน้าที่จะทำการตรวจสอบข้อมูลของท่าน และจะแจ้งการอนุมัติผ่านเมล์ของท่าน</font>
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
			$message2 = '
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
												<td bgcolor="#FFFFFF"><font color="#666666" size="2" face="Tahoma"><strong>&nbsp;&nbsp;ชื่อผู้ใช้ :'.$_POST['gen_user'].'<br>รหัสผ่าน :'.$_POST['gen_pass'].' </strong></font><br>
													<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
														<tr><td bgcolor="#DBDBF2"><font color="#666666" size="2" face="Tahoma">กรุณาคลิก <a href="'.$url.'ewt_w3c/frm_gen_user.php?flag=accept&uid='.base64_encode($gen_user_id_new).'" accesskey=a>ยืนยันการสมัครสมาชิก</a> เพื่อยืนยันการสมัครของท่าน</font>
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
			$alt1 ="บันทึกข้อมูลเรียบร้อยแล้ว";
			$alt2 ="บันทึกข้อมูลเรียบร้อยแล้ว  ระบบจะส่งข้อความตอบรับไปยัง E-mail ของท่าเพื่อยืนยันการใช้งาน";
			$alt3 ="บันทึกข้อมูลเรียบร้อยแล้วกรุณารอการอนุมัติการใช้งานจากเจ้าหน้าที่";
		/* subject */
		$subject = $txt_website_of_name5;

		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";

		/* additional headers */
		$headers .= "From: Member System \r\n";
		$mail_to = $_POST[email_person];
		//@mail($mail_to, $subject, $message, $headers);

		$db->query("USE ".$EWT_DB_NAME);
		$sql_chk = "select * from member_setting where set_id = '1'";
		$query_chk = $db->query($sql_chk);
		if($db->db_num_rows($query_chk)>0){
		   $rec=$db->db_fetch_array($query_chk);
		   $member_setting=$rec[set_type];
		 }
		//$qSiteEmail=$db->query('SELECT site_email FROM site_info LIMIT 1');
		//$rSiteEmail=$db->db_fetch_array($qSiteEmail);
		$rSiteEmail['site_email'] = 'webmaster@parliament.go.th';
		 $db->query("USE ".$EWT_DB_USER);
		  if($member_setting=='2'){
		  //สมัครแล้วยืนยันผ่าน E-Mail		
		 include($path."lib/libmail.php");
		 $m= new Mail;
		$m->From($rSiteEmail['site_email']);
		$m->To($mail_to);
		$m->Subject(iconv('UTF-8','UTF-8',$subject));
		$m->Body( iconv('UTF-8','UTF-8',$message2) );
		$m->Priority(4);
		$m->Send();
		  }
		 if($member_setting=='3'){
		include($path."lib/libmail.php");
		$m= new Mail;
		$m->From($rSiteEmail['site_email']);
		$m->To($mail_to);
		$m->Subject(iconv('UTF-8','UTF-8',$subject));
		$m->Body( iconv('UTF-8','UTF-8',$message) );
		$m->Priority(4);
		$m->Send();
		}
		?>
		 <script language="javascript" type="text/javascript">
		 <?php
		 if($member_setting=='1'){
		  $db->query("UPDATE gen_user SET status='1' where gen_user_id = '".$gen_user_id_new."'");
		  ?>
		 alert('<?php echo  $alt1; ?>');
		 <?php
		 }
		 if($member_setting=='2'){
		 ?>
		 alert('<?php echo $alt2; ?>');
		 <?php
		 }
		if($member_setting=='3'){
		?>
		alert('<?php echo $alt3; ?>');
		<?php
		}
		 ?>
		document.location.href='main.php?filename=<?php echo $_POST[filename];?>';
		</script>	
		<?php
		exit;
	}
	
	$db->query("USE ".$EWT_DB_NAME);
?>
<?php echo $template_design[0];?>
<script language="JavaScript"  type="text/javascript">
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
	if (frm.gen_user.value.search("^[A-Za-z0-9_]+$")){
					alert("Username is limited to English character  (upper and lower case), number, and underscore only!");
					document.frm.gen_user.focus();
					return false;
		}
	if(frm.gen_pass.value==""){ 
		alert("กรุณากรอก Password");
		document.frm.gen_pass.focus();
		return false;
	} 
	if (frm.gen_pass.value.search("^[A-Za-z0-9_]+$")){
					alert("Password is limited to English character  (upper and lower case), number, and underscore only!");
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
	
	if(document.frm.setflag.value == "1"){
	document.getElementById('t1').style.display ='none' ; 
	document.getElementById('t2').style.display ='none' ; 
	document.getElementById('t3').style.display ='none' ; 
	document.getElementById('previewDiv').style.display ='' ; 
	}else if(document.frm.setflag.value == "0"){
	frm.target = "ewtmember";
	window.open("","ewtmember","scrollbars=1,resizable=1");
	frm.action = "member_view_print.php";
	frm.submit();
	}

}// end check_input


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
 </script>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
			
			
			<?php
$db->query("USE ".$EWT_DB_USER);
			?>
			
		<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
		<tr>
		<td bgcolor="#DBDBF2"><h1><font color="#666666" size="4" face="Tahoma">สมัครสมาชิก</font></h1>
		หมายเหตุ : (*) จำเป็นต้องกรอก
		</td>
		</tr>
		</table>

	  <form name="frm"  action=""  method="post"  enctype="multipart/form-data" onSubmit=" return chkinput();">
	<input name="flag" type="hidden" value="add">
	<input name="filename" type="hidden" value="<?php echo $_GET[filename]; ?>">
	<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1">
	<tr><td width="31%" height="30">&nbsp;รหัสบัตรประชาชน : <span class="style10">*</span></td>
	<td align="left"><input name="cardW0"  type="text"  id="cardW0"  class="textinput"  size="1" maxlength="1" value="<?=substr($emp_id,0,1)?>" onKeyPress="return NumberOnly();" onKeyUp=" if(this.value.length==1){this.form.cardW1.value='';this.form.cardW1.focus();}">
	-
	<input name="cardW1"  type="text"  id="cardW1" class="textinput"  size="4" maxlength="4" value="<?=substr($emp_id,1,4)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==4){this.form.cardW2.value='';this.form.cardW2.focus();}">
	-
	<input name="cardW2"  type="text"  id="cardW2" class="textinput" size="5" maxlength="5" value="<?=substr($emp_id,5,5)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==5){this.form.cardW3.value='';this.form.cardW3.focus();}">
	-
	<input name="cardW3"  type="text" id="cardW3" class="textinput" size="2" maxlength="2" value="<?=substr($emp_id,10,2)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==2){this.form.cardW4.value='';this.form.cardW4.focus();}">
	-
	<input name="cardW4"  type="text"  id="cardW4" class="textinput" size="1" maxlength="1" value="<?=substr($emp_id,12,1)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==1){if(!chkIDcard(this.form.cardW0.value,this.form.cardW1.value,this.form.cardW2.value,this.form.cardW3.value,this.form.cardW4.value,this.form)){ alert('รหัสบัตรประขาชนไม่ถูกต้อง');this.form.cardW0.value='';this.form.cardW0.focus();}else{};}"></td>
	</tr>
	<tr id="t1">
	<td height="30">&nbsp;คำนำหน้า : <span class="style10">*</span></td>
	<td align="left"> <div id="div_title_thai">
	<select name="title_thai" id="title_thai">
	<option value="" >--โปรดเลือก--</option>
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
	<td align="left"><input name="name_thai" type="text" id="name_thai"  value="<?=$name_thai;?>" size="50" ></td>
	</tr>
	<tr>
	<td height="30">&nbsp;นามสกุล : <span class="style10">*</span></td>
	<td align="left"><input name="surname_thai" type="text" id="surname_thai"  value="<?=$surname_thai;?>" size="50" ></td>
	</tr>
	<tr id="t2" style="display:none">
	<td height="30">&nbsp;Title:</td>
	<td align="left"><select name="title_eng" id="title_eng" onChange="chk_status(this);">
	<option value="">--โปรดเลือก--</option>
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
	<td height="30">&nbsp;ชื่อภาษาอังกฤษ :</td>
	<td align="left"><input name="name_eng" type="text" id="name_eng"  value="<?=$name_eng;?>" size="50"></td>
	</tr>
	<tr>
	<td height="30">&nbsp;นามสกุลภาษาอังกฤษ :</td>
	<td align="left"><input name="surname_eng" type="text" id="surname_eng"  value="<?=$surname_eng;?>" size="50"></td>
	</tr>
	<tr>
	<td height="30">&nbsp;Email : <span class="style10">*</span></td>
	<td align="left"><input name="email_person" type="text" id="email_person" value="<?=$email_person;?>" size="50"></td>
	</tr>
	<tr>
	<td height="30">&nbsp;เบอร์มือถือ :</td>
	<td align="left"><input name="mobile" type="text" id="mobile" value="<?=$mobile;?>" size="50" ></td>
	</tr>
	<tr>
	<td height="30">&nbsp;สถานที่ทำงาน :</td>
	<td align="left"><textarea name="officeaddress" cols="50" rows="5" id="officeaddress"><?=$officeaddress;?></textarea></td>
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
	<td height="30">&nbsp;Username :<span class="style10">*</span></td>
	<td align="left"><input name="gen_user" type="text" id="gen_user" value="<?=$gen_user;?>" size="30" ></td>
	</tr>
	<tr>
	<td height="30">&nbsp;Password : <span class="style10">*</span></td>
	<td align="left"><input name="gen_pass" type="password" id="gen_pass" value="<?=$gen_pass;?>" size="30"></td>
	</tr>
	<tr>
	<td height="30">&nbsp;Re Password : <span class="style10">*</span></td>
	<td align="left"><input name="re_gen_pass" type="password" id="re_gen_pass" value="<?=$gen_pass;?>" size="30"></td>
	</tr>
<tr>
	<td height="30" colspan="2">
	<div id="previewDiv" style="position:absolute; display:none" align="center">
	  <table width="90%"  border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC" >
        <tr>
          <td align="center" bgcolor="#FFFFFF"><img src="../mainpic/loading.gif"  alt="loading.gif"></td>
        </tr>
      </table></div></td>
	</tr>
	</table>
	<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
		<tr>
		<td  align="center"  bgcolor="#DBDBF2" id="show_status" ><font color="#666666" size="4" face="Tahoma"><strong><input name="save" type="submit" class="submit" id="save" value="สมัครสมาชิก" >
	<input name="Submit2" type="button" class="submit" value="ยกเลิก" style="width:80"  onclick="window.location.href='main.php?filename=index';"><input name="setflag" type="hidden" id="setflag" value="0"></strong></font></td>
		</tr>
		</table>
	</form>
	<?php $db->query("USE ".$EWT_DB_NAME);?>
	<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>