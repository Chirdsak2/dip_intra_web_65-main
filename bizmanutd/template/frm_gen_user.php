<?php
	session_start();
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	//===========================================================
	$filename=checkPttVar($filename);
	$_GET["filename"]=checkPttVar($_GET["filename"]);
	$_POST["filename"]=checkPttVar($_POST["filename"]);
	$_REQUEST["filename"]=checkPttVar($_REQUEST["filename"]);
	
	if($flag){ $flag=checkPttVar($flag); }
	if($_GET["flag"]){ $_GET["flag"]=checkPttVar($_GET["flag"]); }
	if($_POST["flag"]){ $_POST["flag"]=checkPttVar($_POST["flag"]); }
	
	if($name_eng){ $name_eng=checkPttVar($name_eng); }
	if($_GET["name_eng"]){ $_GET["name_eng"]=checkPttVar($_GET["name_eng"]); }
	if($_POST["name_eng"]){ $_POST["name_eng"]=checkPttVar($_POST["name_eng"]); }
	
	if($surname_eng){ $surname_eng=checkPttVar($surname_eng); }
	if($_GET["surname_eng"]){ $_GET["surname_eng"]=checkPttVar($_GET["surname_eng"]); }
	if($_POST["surname_eng"]){ $_POST["surname_eng"]=checkPttVar($_POST["surname_eng"]); }
	
	if($title_eng){ $title_eng=checkPttVar($title_eng); }
	if($_GET["title_eng"]){ $_GET["title_eng"]=checkPttVar($_GET["title_eng"]); }
	if($_POST["title_eng"]){ $_POST["title_eng"]=checkPttVar($_POST["title_eng"]); }
	
	if($gen_user){ $gen_user=checkPttVar($gen_user); }
	if($_GET["gen_user"]){ $_GET["gen_user"]=checkPttVar($_GET["gen_user"]); }
	if($_POST["gen_user"]){ $_POST["gen_user"]=checkPttVar($_POST["gen_user"]); }
	
	if($cid){ $cid  = checkNumeric($cid); }
	if($_GET["cid"]){ $_GET["cid"] = checkNumeric($_GET["cid"]); }
	if($_POST["cid"]){ $_POST["cid"] = checkNumeric($_POST["cid"]); }
	
	if($emp_type_id){ $emp_type_id = checkNumeric($emp_type_id); }
	if($_GET["emp_type_id"]){ $_GET["emp_type_id"] = checkNumeric($_GET["emp_type_id"]); }
	if($_POST["emp_type_id"]){ $_POST["emp_type_id"] = checkNumeric($_POST["emp_type_id"]); }
	
	if($d_id){ $d_id  = checkNumeric($d_id); }
	if($_GET["d_id"]){ $_GET["d_id"] = checkNumeric($_GET["d_id"]); }
	if($_POST["d_id"]){ $_POST["d_id"] = checkNumeric($_POST["d_id"]); }
	
	if($emp_id){ $emp_id = checkNumeric($emp_id); }
	if($_GET["emp_id"]){ $_GET["emp_id"] = checkNumeric($_GET["emp_id"]); }
	if($_POST["emp_id"]){ $_POST["emp_id"] = checkNumeric($_POST["emp_id"]); }
	
	$_POST[cardW0] = checkNumeric($_POST[cardW0]);
	$_POST[cardW1] = checkNumeric($_POST[cardW1]);
	$_POST[cardW2] = checkNumeric($_POST[cardW2]);
	$_POST[cardW3] = checkNumeric($_POST[cardW3]);
	$_POST[cardW4] = checkNumeric($_POST[cardW4]);
	
	$email_person= checkMails($email_person);
	$_GET["email_person"] = checkMails($_GET["email_person"]);
	$_POST["email_person"] = checkMails($_POST["email_person"]);
	//===========================================================
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


	$db->query("USE ".$EWT_DB_USER);

	if($_GET["flag"] =='accept'){
	
		$usid = base64_decode ($_GET[uid]);
		$db->query("UPDATE gen_user SET status='1' where gen_user_id = '".$usid."'");
		echo "<script language=\"javascript\">";
		echo "alert('ยืนยันการเป็นสมาชิกเรียบร้อยแล้ว');";
		echo "document.location.href='main.php?filename=index'" ;
		echo "</script>";	
		exit;
	}
	if($_POST["flag"]=='add'){
		if($_POST['title_thai'] != ""){
			$emp_id = $_POST[cardW0].$_POST[cardW1].$_POST[cardW2].$_POST[cardW3].$_POST[cardW4];
			
			$check_emp="Select * From  gen_user Where emp_id='$emp_id' and web_use = '$EWT_FOLDER_USER' ";
			$exec_emp= $db->query($check_emp);
			$row_emp = $db->db_num_rows($exec_emp);		
		/*	if($row_emp){  
				?>
					<script language="javascript">
						alert("รหัสบัตรประชาชนหมายเลข <?php echo $emp_id;?> ซ้ำในระบบกรุณากรอกใหม่");
						document.location.href="frm_gen_user.php";
					</script>
				<?php
				exit;
			}*/
			$check_user="Select * From  gen_user Where gen_user='$gen_user' and web_use = '$EWT_FOLDER_USER' ";
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
															<tr><td bgcolor="#DBDBF2"><font color="#666666" size="2" face="Tahoma">กรุณาคลิก <a href="frm_gen_user.php?flag=accept&uid='.base64_encode($gen_user_id_new).'">ยืนยันการสมัครสมาชิก</a> เพื่อยืนยันการสมัครของท่าน</font>
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
			$headers .= "From: Member System<webmaster@prd.go.th> \r\n";
			$mail_to = $_POST[email_person];
			@mail($mail_to, $subject, $message, $headers);
	
			$db->query("USE ".$EWT_DB_NAME);
			$sql_chk = "select * from member_setting";
			$query_chk = $db->query($sql_chk);
			if($db->db_num_rows($query_chk)>0){
			   $rec=$db->db_fetch_array($query_chk);
			   $member_setting=$rec[set_type];
			 }
			 $db->query("USE ".$EWT_DB_USER);
			 
			 echo "<script language=\"javascript\">";
			 if($member_setting=='1'){
			 //สมัครแล้วเป็นสมาชิกทันที
			  $db->query("UPDATE gen_user SET status='1' where gen_user_id = '".$gen_user_id_new."'");
			  echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
			  
			 }
			 if($member_setting=='2'){
			 //สมัครแล้วยืนยันผ่าน E-Mail		
			 echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว\\nระบบจะส่งข้อความตอบรับไปยัง E-mail ของท่าเพื่อยืนยันการใช้งาน');";
			 @mail($mail_to, $subject, $message2, $headers);
			 }
			if($member_setting=='3'){
			//สมัครแล้วรอการอนุมัติจาก Admin
			echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว\\nกรุณารอการอนุมัติการใช้งานจากเจ้าหน้าที่');";
			@mail($mail_to, $subject, $message, $headers);
			}
			
			 
			//echo "window.open('frm_gen_user2.php','','width=500 , height=400, scrollbars=0,resizable = 0');";
			//echo "alert('กรุณาตรวจสอบ e-mail ของท่านเพื่อยืนยันการเป็นสมาชิก');";
			echo "document.location.href='main.php?filename=index'" ;
			//echo "document.location.href='frm_gen_user2.php?filename=index'" ;
			echo "</script>";	
			exit;
		}
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
	
	/*var CardID=frm.cardW0.value+frm.cardW1.value+frm.cardW2.value+frm.cardW3.value+frm.cardW4.value;
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
/*	if(frm.email_person.value == ""){
		alert('กรุณากรอกรูปแบบ Email  ให้ถูกต้อง')
		frm.email_person.focus()
		frm.email_person.select()
		return false;
	}	*/
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
	return false;
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
			<table width="90%" border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="B4BDC7" style="display:none">
							<tr><td valign="top"><?php echo $txt_website_of_name6;?><br>
							  <br>
						
							<table width="85%" border="0" align="center" cellpadding="0" cellspacing="1">
										<tr>
										  <td ><?php echo $txt_website_of_name8;?></td>
							  </tr>
							  </table>
						</td>
							</tr>
							<tr> 
								<td valign="middle" ><?php echo $txt_website_of_name7;?><br><br>
									<table width="85%" border="0" align="center" cellpadding="10" cellspacing="1">
										<tr><td ><?php echo  $txt_website_of_name3;?>
												<br>
												</td></tr>
									</table>
									<br />
								</td>
							</tr>
						</table><br><br><br>
		<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
		<tr>
		<td bgcolor="#DBDBF2"><font color="#666666" size="4" face="Tahoma"><strong>สมัครสมาชิก</strong></font></td>
		</tr>
		</table>

	  <form name="frm"  action=""  method="post"  enctype="multipart/form-data" onSubmit=" return chkinput();">
	<input name="flag" type="hidden" value="add">
	<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1">
	<tr><td width="31%" height="30">&nbsp;รหัสบัตรประชาชน : </td>
	<td align="left"><input name="cardW0"  type="text"  id="cardW0"  class="textinput"  size="1" maxlength="1" value="<?php echo substr($emp_id,0,1)?>" onKeyPress="return NumberOnly();" onKeyUp=" if(this.value.length==1){this.form.cardW1.value='';this.form.cardW1.focus();}">
	-
	<input name="cardW1"  type="text"  id="cardW1" class="textinput"  size="4" maxlength="4" value="<?php echo substr($emp_id,1,4)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==4){this.form.cardW2.value='';this.form.cardW2.focus();}">
	-
	<input name="cardW2"  type="text"  id="cardW2" class="textinput" size="5" maxlength="5" value="<?php echo substr($emp_id,5,5)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==5){this.form.cardW3.value='';this.form.cardW3.focus();}">
	-
	<input name="cardW3"  type="text" id="cardW3" class="textinput" size="2" maxlength="2" value="<?php echo substr($emp_id,10,2)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==2){this.form.cardW4.value='';this.form.cardW4.focus();}">
	-
	<!--input name="cardW4"  type="text"  id="cardW4" class="textinput" size="1" maxlength="1" value="<?php echo substr($emp_id,12,1)?>" onKeyPress="return NumberOnly();" onKeyUp="if(this.value.length==1){if(!chkIDcard(this.form.cardW0.value,this.form.cardW1.value,this.form.cardW2.value,this.form.cardW3.value,this.form.cardW4.value,this.form)){ alert('รหัสบัตรประขาชนไม่ถูกต้อง');this.form.cardW0.value='';this.form.cardW0.focus();}else{};}"-->
	<input name="cardW4"  type="text"  id="cardW4" class="textinput" size="1" maxlength="1" value="<?php echo substr($emp_id,12,1)?>" onKeyPress="return NumberOnly();"></td>
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
	<td height="30">&nbsp;นามสกุล : <span class="style10">*</span></td>
	<td align="left"><input name="surname_thai" type="text" id="surname_thai"  value="<?php echo $surname_thai;?>" size="50" ></td>
	</tr>
	<tr id="t2" style="display:none">
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
	<td height="30">&nbsp;ชื่อภาษาอังกฤษ :</td>
	<td align="left"><input name="name_eng" type="text" id="name_eng"  value="<?php echo $name_eng;?>" size="50"></td>
	</tr>
	<tr>
	<td height="30">&nbsp;นามสกุลภาษาอังกฤษ :</td>
	<td align="left"><input name="surname_eng" type="text" id="surname_eng"  value="<?php echo $surname_eng;?>" size="50"></td>
	</tr>
	<tr>
	<td height="30">&nbsp;Email : </td>
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
	<!--<tr bgcolor="#DBDBF2">
	<td height="25" colspan="2" align="center" id="show_status" ><input name="save" type="submit" class="submit" id="save" value="บันทึก" onClick="return chkinput(); " />
	<input name="Submit2" type="button" class="submit" value="ยกเลิก" style="width:80"  onclick="window.location.href='main.php?filename=index';"/>
	</td>
	</tr>-->
<tr>
	<td height="30" colspan="2">
	<div id="previewDiv" style="position:absolute; display:none" align="center">
	  <table width="90%"  border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#CCCCCC" >
        <tr>
          <td align="center" bgcolor="#FFFFFF"><img src="mainpic/loading.gif" /></td>
        </tr>
      </table></div></td>
	</tr>
	</table>
	<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
		<tr>
		<td  align="center"  bgcolor="#DBDBF2" id="show_status" ><font color="#666666" size="4" face="Tahoma"><strong><input name="save" type="submit" class="submit" id="save" value="สมัครสมาชิก" />
	<input name="Submit2" type="button" class="submit" value="ยกเลิก" style="width:80"  onclick="window.location.href='main.php?filename=index';"/><input name="setflag" type="hidden" id="setflag" value="0"></strong></font></td>
		</tr>
		</table>
	</form>
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
