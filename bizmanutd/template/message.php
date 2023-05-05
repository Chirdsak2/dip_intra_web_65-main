<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include('lib/pager.php');
$db->query("USE ".$EWT_DB_USER);
//Clear temp
/*if($process==''){
		$deldate = date("Y-m-d 00:00:01");
		
		$db->query("delete from n_temp where file_date < '".$deldate."' ");
		$db->query("delete from n_temp_user where temp_date < '".$deldate."'");
}
*///Clear temp

$process=$HTTP_POST_VARS['process'];
$code=$HTTP_POST_VARS['code'];
$m_subject=$HTTP_POST_VARS['m_subject'];
$m_body=$HTTP_POST_VARS['m_body'];
$id=$HTTP_POST_VARS['id'];

function random($len){
	srand((double)microtime()*10000000);
	$chars = "ABCDEFGHJKMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz1234567890";
	$ret_str = "";
	$num = strlen($chars);
	for($i=0;$i<$len;$i++){
		$ret_str .= $chars[rand()%$num];
	}
	return $ret_str;
}
$attachid = random(50);
?>
<html>
<head>
<title><?php echo $F["title"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript">
function ChkMessage(f){
	if (f.mto.value=='' || f.mto.value==0){
	  alert("กรุณาเลือก ผู้รับ");
	} else if (f.m_subject.value==''){
	  alert("กรุณากรอก Subject");
	  f.m_subject.focus();
	}else {
	  return true;
	}
	return false;
}
	function checkfeeall(totalrec){
		if(document.getElementById('chkfeeall').checked == true){
			for(i=1; i<=totalrec.value; i++){
				document.getElementById("chkfee"+i).checked=true;		
			}
		}else{
			for(i = 1; i<=totalrec.value;i++){
				document.getElementById("chkfee"+i).checked=false;
			}
		}
	}
	function checkfeeeach(totalrec){
		var num = 0
		for(i = 1; i<=totalrec.value;i++){
			if(document.getElementById("chkfee"+i).checked==true){
				num = num+1
			}
		}
		if(num==totalrec.value){
			document.getElementById('chkfeeall').checked = true;
		}else{
			document.getElementById('chkfeeall').checked = false;
		}
	}	
function chkchecked(maxx){
    if(maxx==0) {
        alert('กรุณาเลือกรายการที่ต้องการลบ');
		return false; 
   }else {
         return true;
   }
}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="110%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="800" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="5" height="100%" background="mainpic/bg_l.gif"></td>
          <td align="center" valign="top" bgcolor="E3E6EB"><table width="770" height="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="B4BDC7">
              <tr> 
                <td valign="top" bgcolor="#FFFFFF"><br>
                  <table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#A9A9E0">
                    <tr>
                      <td bgcolor="#DBDBF2"><font size="4" face="Tahoma"><strong><font color="#666666">ระบบข้อความ</font></strong></font></td>
                    </tr>
                  </table>
                  <br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="447" valign="top">
		<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="140px" align="right" valign="top">
				<form action="<?php $HTTP_SERVER_VARS['PHP_SELF'];?>" method="post" name="form2">
				<input type="hidden" name="process" value="">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" height="500">
				  <tr>
					<td align="center" valign="top" bgcolor="#F5F5F5"><br />
					<hr>
					  <a href="#" onClick="document.form2.process.value='new';document.form2.submit();">เขียนข้อความใหม่</a> <br>
					<hr />
					<a href="#" onClick="document.form2.process.value='';document.form2.submit();">กล่องข้อความเข้า</a><br>
					<hr>
					<a href="#" onClick="document.form2.process.value='outbox';document.form2.submit();">กล่องข้อความออก</a><br>
					<hr />
					<a href="#" onClick="document.form2.process.value='deletebox';document.form2.submit();">ข้อความที่ถูกลบ</a><br>
					<hr>
					</td>
				  </tr>
				</table>
				</form>
			</td>
			<td valign="top" >
            <?php
				if($process=='new'){
				?>
            <form action="<?php $HTTP_SERVER_VARS['PHP_SELF'];?>" method="post" name="form1"  onSubmit="return ChkMessage(this);">
				<input type="hidden" name="process" value="saveinsert">
				<input type="hidden" name="code" value="<?php echo $attachid; ?>">
				<table width="90%" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="#000000">
				  <tr bgcolor="#FFFFFF">
					<td width="20%" height="20"><strong>จาก : </strong></td>
					<td width="80%">
					<?php
					$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."'"));
					 echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai']; 
					?>					
					</td>
				  </tr>
				  <!--<tr bgcolor="#FFFFFF">
					<td><strong>To :</strong></td>
					<td><input type="text" name="m_name" size="50" readonly=""> <input type="hidden" name="m_to"> <img src="mainpic/businessman_add.gif" border="0" align="absmiddle" style="cursor:hand" onClick="win2=window.open('personal_add.php?title_name=<?php echo $F["title"];?>','personal_add','width=500,height=575,resizable=1;location=0,scrollbars=1');win2.focus();"></td>
				  </tr>
				  -->
				  <tr bgcolor="#FFFFFF">
					<td><strong>ถึง :</strong></td>
					<td><a href="#" onClick="win2=window.open('message_list_name.php?code=<?php echo $attachid;?>','message_list_name','width=750,height=550,top=0,left=0,scrollbar=1');win2.focus();"><img src="mainpic/businessman_add.gif" border="0" align="absmiddle"> <strong>เลือกผู้รับ</strong></a></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td></td>
					<td><IFRAME name="personal_list" src="message_list_show.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" ALIGN="TOP" height="150" scrolling="yes"></IFRAME></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td><strong>หัวข้อ : </strong></td>
					<td><input type="text" name="m_subject" value="<?php echo $m_subject;?>" size="80"></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
                                    <td align="left" valign="top"><strong>ข้อความ :</strong></td>
					<td><textarea  name="m_body" cols="80" rows="20"><?php echo $m_body;?></textarea></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td><strong>ไฟล์แนบ :</strong></td>
				    <td><IFRAME name="attach_add" src="message_file_temp.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" height="25" scrolling="no"></IFRAME></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				  	<td></td>
					<td>
						<table width="100%" border="0" cellspacing="1" cellpadding="1">
						<thead>
						</thead>
						<tbody id="tData">
						  <tr>
							<td><IFRAME name="attach_list" src="message_list_temp.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" ALIGN="TOP" height="100" scrolling="yes"></IFRAME></td>
						  </tr>
						  </tbody>
						</table>					
						</td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td colspan="2" align="center"><input type="submit" name="submit" value="ส่งข้อความ">&nbsp;&nbsp;<input type="reset" name="reset" value="ยกเลิก">
						<input type="hidden" name="mto" value="" id="mto">
					</td>
				  </tr>
				</table>
				</form>
			  <?php
				}else if($process=='reply'){
				$recreply = $db->db_fetch_array($db->query("SELECT * FROM  n_message WHERE id = '".$id."'"));
				$m_subject=$recreply['m_subject'];
				$m_from=$recreply['m_from'];
				$db->query("INSERT INTO n_temp_user (tempcode, temp_gen_user_id, temp_date) 
										VALUES ('$attachid','$m_from','".date("Y-m-d H:m:s")."')");
				?>
				<form action="<?php $HTTP_SERVER_VARS['PHP_SELF'];?>" method="post" name="form1"  onSubmit="return ChkMessage(this);">

				<input type="hidden" name="process" value="saveinsert">
				<input type="hidden" name="code" value="<?php echo $attachid; ?>">
				<table width="90%" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="#000000">
				  <tr bgcolor="#FFFFFF">
					<td width="20%" height="20"><strong>จาก : </strong></td>
					<td width="80%">
					<?php
					$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."'"));
					 echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai']; 
					?>					
					</td>
				  </tr>
				  <!--<tr bgcolor="#FFFFFF">
					<td><strong>To :</strong></td>
					<td><input type="text" name="m_name" size="50" readonly=""> <input type="hidden" name="m_to"> <img src="mainpic/businessman_add.gif" border="0" align="absmiddle" style="cursor:hand" onClick="win2=window.open('personal_add.php?title_name=<?php echo $F["title"];?>','personal_add','width=500,height=575,resizable=1;location=0,scrollbars=1');win2.focus();"></td>
				  </tr>
				  -->
				  <tr bgcolor="#FFFFFF">
					<td><strong>ถึง :</strong></td>
					<td><a href="#" onClick="win2=window.open('message_list_name.php?code=<?php echo $attachid;?>','message_list_name','width=750,height=550,top=0,left=0,scrollbar=1');win2.focus();"><img src="mainpic/businessman_add.gif" border="0" align="absmiddle"> <strong>เลือกผู้รับ</strong></a></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td></td>
					<td><IFRAME name="personal_list" src="message_list_show.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" ALIGN="TOP" height="150" scrolling="yes"></IFRAME></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td><strong>หัวข้อ : </strong></td>
					<td><input type="text" name="m_subject" value="Re: <?php echo $m_subject;?>" size="80"></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				   <td valign="top"><strong>ข้อความ :</strong></td>
					<td><textarea  name="m_body" cols="80" rows="20"><?php echo $m_body;?></textarea></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td><strong>ไฟล์แนบ :</strong></td>
				    <td><IFRAME name="attach_add" src="message_file_temp.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" height="25" scrolling="no"></IFRAME></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				  	<td></td>
					<td>
						<table width="100%" border="0" cellspacing="1" cellpadding="1">
						<thead>
						</thead>
						<tbody id="tData">
						  <tr>
							<td><IFRAME name="attach_list" src="message_list_temp.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" ALIGN="TOP" height="100" scrolling="yes"></IFRAME></td>
						  </tr>
						  </tbody>
						</table>					
						</td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td colspan="2" align="center"><input type="submit" name="submit" value="ส่งข้อความ">&nbsp;&nbsp;<input type="reset" name="reset" value="ยกเลิก">
						<input type="hidden" name="mto" value="" id="mto">
					</td>
				  </tr>
				</table>
				</form>
			  <?php
				}else if($process=='view'){
					$db->query("update n_message set m_flagnewold='2' WHERE  id = '".$id."' ");
				?>
				<form action="<?php $HTTP_SERVER_VARS['PHP_SELF'];?>" method="post" name="form3"  onSubmit="return ChkMessage(this);">
				<input type="hidden" name="process" value="<?php echo $_POST[process]?>">
				<input type="hidden" name="id" value="">
				<?php
					$queryview=$db->query("SELECT * FROM n_message WHERE id = '".$id."' ");
					$recview=$db->db_fetch_array($queryview);
				?>
				<table width="90%" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="#000000">
				  <tr bgcolor="#FFFFFF">
					<td width="20%" height="20"><strong>จาก : </strong></td>
					<td width="80%">
					<?php
					$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$recview['m_from']."'"));
					 echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai']; 
					?>
					</td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td><strong>ถึง :</strong></td>
					<td>
					<?php
						if($in_out){
							$wh="AND m_to!=''";
						}else if($recview['m_flagdel']=='1'){
							$wh="AND m_flagdel ='1'";
						}						
						$queryto=$db->query("SELECT m_to FROM n_message WHERE m_refer = '".$recview['m_refer']."' $wh");
							while($recto=$db->db_fetch_array($queryto)){
								$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$recto['m_to']."'"));
								 if($recname['name_thai']){
								    echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai'].';&nbsp;'; 
								}
							}
					?>
					</td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td nowrap="nowrap"><strong>หัวข้อ : </strong></td>
					<td><?php echo $recview['m_subject'];?></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td colspan="2" height="200" valign="top"><?php echo nl2br($recview['m_body']);?></td>
				  </tr>
				  <?php 
				  		$queryatt=$db->query("SELECT * FROM n_attach WHERE m_id = '".$id."'");
						$chkatt=$db->db_num_rows($queryatt);
						if($chkatt){
				  ?>
				  <tr bgcolor="#FFFFFF">
					<td colspan="2"><strong>ไฟล์แนบ : </strong></td>
				  </tr>
				  <?php
							while($recatt=$db->db_fetch_array($queryatt)){
				  ?>
				  <tr bgcolor="#FFFFFF">
				  	<td></td>
					<td>	<a href="dl.php?file1=<?php echo $recatt[filenametemp]; ?>&file2=<?php echo $recatt[filenamegiven]; ?>" target="_blank">
								<img src="mainpic/b_paperclip.gif" width="16" height="16" border="0" align="absmiddle" alt="<?php echo $recatt[filenamegiven]; ?>"> 
								<?php echo $recatt[filenamegiven]; ?>
								</a>
					</td>
				  </tr>
				  	<?php
							}
						}
					?>
				  <tr bgcolor="#FFFFFF">
					<td colspan="2" align="center"><input  type="button" name="button" value="ย้อนกลับ" onClick="document.form3.process.value='<?php echo $_POST[process2]?>';document.form3.submit();">
					&nbsp;&nbsp;<input type="button" name="button1" value="ตอบกลับ"onClick="document.form3.process.value='reply';document.form3.id.value='<?php echo $id;?>';document.form3.submit();">
					&nbsp;&nbsp;<input type="button" name="button2" value="ส่งต่อ" onClick="document.form3.process.value='forward';document.form3.id.value='<?php echo $id;?>';document.form3.submit();"></td>
				  </tr>
				</table>
				</form>
				<?php
				}else if($process=='forward'){
				$recreply = $db->db_fetch_array($db->query("SELECT * FROM  n_message WHERE id = '".$id."'"));
				$m_subject=$recreply['m_subject'];
				$m_body=$recreply['m_body'];
				$m_from=$recreply['m_from'];
				
				$queryatt=$db->query("SELECT * FROM n_attach WHERE m_id = '".$id."'");
				$chkatt=$db->db_num_rows($queryatt);
				if($chkatt){
						while($recatt=$db->db_fetch_array($queryatt)){
							//copy("file_attach/".$recatt['filenametemp'],"temp/".$recatt['filenametemp']);
							$db->query("INSERT INTO n_temp (temp_code,filenamegiven,filenametemp,file_type,file_size,file_date)
												values ('".$attachid."','".$recatt['filenamegiven']."','".$recatt['filenametemp']."','".$recatt['file_type']."','".$recatt['file_size']."','".date("Y-m-d H:m:s")."')");

						}
				}
				?>
				<form action="<?php $HTTP_SERVER_VARS['PHP_SELF'];?>" method="post" name="form1"  onSubmit="return ChkMessage(this);">
				<input type="hidden" name="process" value="saveinsert">
				<input type="hidden" name="code" value="<?php echo $attachid; ?>">
				<table width="90%" border="0" cellspacing="1" cellpadding="3" align="center" bgcolor="#000000">
				  <tr bgcolor="#FFFFFF">
					<td width="20%" height="20"><strong>จาก : </strong></td>
					<td width="80%">
					<?php
					$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."'"));
					 echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai']; 
					?>					
					</td>
				  </tr>
				  <!--<tr bgcolor="#FFFFFF">
					<td><strong>To :</strong></td>
					<td><input type="text" name="m_name" size="50" readonly=""> <input type="hidden" name="m_to"> <img src="mainpic/businessman_add.gif" border="0" align="absmiddle" style="cursor:hand" onClick="win2=window.open('personal_add.php?title_name=<?php echo $F["title"];?>','personal_add','width=500,height=575,resizable=1;location=0,scrollbars=1');win2.focus();"></td>
				  </tr>
				  -->
				  <tr bgcolor="#FFFFFF">
					<td><strong>ถึง :</strong></td>
					<td><a href="#" onClick="win2=window.open('message_list_name.php?code=<?php echo $attachid;?>','message_list_name','width=750,height=550,top=0,left=0,scrollbar=1');win2.focus();"><img src="mainpic/businessman_add.gif" border="0" align="absmiddle"> <strong>เลือกผู้รับ</strong></a></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td></td>
					<td><IFRAME name="personal_list" src="message_list_show.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" ALIGN="TOP" height="150" scrolling="yes"></IFRAME></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td><strong>หัวข้อ : </strong></td>
					<td><input type="text" name="m_subject" value="Fwd: <?php echo $m_subject;?>" size="80"></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				   <td valign="top"><strong>ข้อความ :</strong></td>
					<td ><textarea  name="m_body" cols="70" rows="20"><?php echo $m_body;?></textarea></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td><strong>ไฟล์แนบ :</strong></td>
				    <td><IFRAME name="attach_add" src="message_file_temp.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" height="25" scrolling="no"></IFRAME></td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
				  	<td></td>
					<td>
						<table width="100%" border="0" cellspacing="1" cellpadding="1">
						<thead>
						</thead>
						<tbody id="tData">
						  <tr>
							<td><IFRAME name="attach_list" src="message_list_temp.php?code=<?php echo $attachid; ?>" frameBorder="0" width="100%" ALIGN="TOP" height="100" scrolling="yes"></IFRAME></td>
						  </tr>
						  </tbody>
						</table>					
						</td>
				  </tr>
				  <tr bgcolor="#FFFFFF">
					<td colspan="2" align="center"><input type="submit" name="submit" value="ส่งข้อความ">&nbsp;&nbsp;<input type="reset" name="reset" value="ยกเลิก">
						<input type="hidden" name="mto" value="" id="mto">
					</td>
				  </tr>
				</table>
				</form>
				<?php
				}else if($process=='saveinsert'){
					//ผู้รับ message
					 $sqltemp="SELECT temp_gen_user_id FROM n_temp_user WHERE tempcode ='".$code."'"; 
						$querytemp=$db->query($sqltemp);
						$num=$db->db_num_rows($querytemp);
							while($rectemp=$db->db_fetch_array($querytemp)){
								$db->query("insert into n_message
																( gen_user_id, m_refer, m_from, m_to, m_flaginout, m_flagdel, m_subject, m_body, m_date, m_flagnewold)
																values
																( '".$HTTP_SESSION_VARS['EWT_MID']."', '".$code."', '".$HTTP_SESSION_VARS['EWT_MID']."', '".$rectemp['temp_gen_user_id']."', '1', '0', '".$m_subject."','".$m_body."','".date("Y-m-d H:m:s")."','1')");
									$recm=$db->db_fetch_array($db->query("SELECT id FROM n_message WHERE gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' ORDER BY id DESC"));
									$querytempfile=$db->query("SELECT * FROM n_temp WHERE temp_code = '".$code."'");
									$numtempfile=$db->db_num_rows($querytempfile);
											if($numtempfile){
													while($rectempfile=$db->db_fetch_array($querytempfile)){
														copy("temp/".$rectemp['filenametemp'],"file_attach/".$rectemp['filenametemp']);
														$db->query("insert into n_attach (m_id, filenamegiven, filenametemp, file_type, file_size, file_date)
																			values
																			('".$recm['id']."', '".$rectempfile['filenamegiven']."', '".$rectempfile['filenametemp']."', '".$rectempfile['file_type']."', '".$rectempfile['file_size']."','".date("Ymd H:m:s")."')");
													}
											}
							}
					//End ผู้รับ message
					
					//Out message
					$db->query("insert into n_message
													( gen_user_id, m_refer, m_from, m_to, m_flaginout, m_flagdel, m_subject, m_body, m_date, m_flagnewold)
													values
													( '".$HTTP_SESSION_VARS['EWT_MID']."', '".$code."', '".$HTTP_SESSION_VARS['EWT_MID']."', '".$m_to."', '2', '0', '".$m_subject."','".$m_body."','".date("Y-m-d H:m:s")."','1')");
						$recm=$db->db_fetch_array($db->query("SELECT id FROM n_message WHERE gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' ORDER BY id DESC"));
						$querytemp=$db->query("SELECT * FROM n_temp WHERE temp_code = '".$code."'");
						$numtemp=$db->db_num_rows($querytemp);
						if($numtemp){
							while($rectemp=$db->db_fetch_array($querytemp)){
								copy("temp/".$rectemp['filenametemp'],"file_attach/".$rectemp['filenametemp']);
								$db->query("insert into n_attach (m_id, filenamegiven, filenametemp, file_type, file_size, file_date)
													values
													('".$recm['id']."', '".$rectemp['filenamegiven']."', '".$rectemp['filenametemp']."', '".$rectemp['file_type']."', '".$rectemp['file_size']."','".date("Ymd H:m:s")."')");
							}
						}
					//End Out message
				?>
				<form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
					<script language="javascript">
						alert('ได้ทำการส่ง Message แล้ว');
						document.formreturn.submit();
					</script>
				</form>
				<?php
				}else if($process=='outbox'){
					$sql="SELECT * FROM n_message WHERE gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' AND m_flagdel='0' AND m_flaginout='2' ORDER BY m_date DESC";
					
					$query=$db->query($sql); 
					$rows=$db->db_num_rows($query);
					//start ส่วนการคำนวณตัดหน้า
					if($limit == ""){ $limit = 20;} //ทำการกำหนดค่าการแสดงเรกคอร์ดต่อpage
					if (empty($offset) || $offset < 0) { $offset=0; }//ทำการกำหนดค่าเริ่มต้นpage
					$sqllist=$sql.CalSplitPage($rows, $offset, $limit);
					// end ส่วนการคำนวณตัดหน้า
					$querylist = $db->query($sqllist);
					$numlist = $db->db_num_rows($querylist);
				?>
				<form action="<?php $HTTP_SERVER_VARS['PHP_SELF'];?>" method="post" name="form1">
				<input type="hidden" name="process" value="<?php echo $_POST[process]?>">
                <input type="hidden" name="process2" value="<?php echo $_POST[process]?>">
				<input type="hidden" name="id" value="">
				<input type="hidden" name="in_out" value="">
				<input name="allrecord" type="hidden" value="<?php echo $numlist;?>">
               <input  type="hidden" name="dels"  value="">        
				<strong><font size="4" face="Tahoma">&nbsp;&nbsp;&nbsp;กล่องข้อความออก </font></strong> 
				<table width="96%"cellspacing="1" cellpadding="1" border="0" align="center" bgcolor="#000000">
				  <tr bgcolor="#CCCCCC">
					<td width="4%" align="center">&nbsp;</td>
					<td width="62%" align="center"><strong>หัวข้อ</strong></td>
					<td width="15%" align="center"><strong>ถึง</strong></td>
					<td width="15%" align="center"><strong>วันที่</strong></td>
					<td width="4%" align="center">
					<?php if($numlist!=0){?>
							<input id="chkfeeall" name="chkfeeall" type="checkbox" value="Y" onClick="checkfeeall(document.getElementById('allrecord')); if(this.checked==true){document.all.dels.value=document.all.allrecord.value*1;}else{document.all.dels.value=0;}">
					<?php }?> 
					</td>
					
				  </tr>
				  <?php
					if($numlist>0){
					$i=1;
					while($reclist=$db->db_fetch_array($querylist)){
					$m_flagnewold=$reclist['m_flagnewold'];
					if($m_flagnewold==1){
						$BG='bgcolor="#FFFFCC"';
					}else{
						$BG='bgcolor="#FFFFFF"';
					}
				  ?>
				  <tr <?php echo $BG;?>>
					<td align="center" nowrap="nowrap">
					<?php 
					if($m_flagnewold=='1'){
					?>
						<img src="mainpic/mail2.gif" border="0" align="absmiddle" width="24">
					<?php 
						}else{
					 ?>
						<img src="mainpic/mail.gif" border="0" align="absmiddle" width="24">
					<?php 
					}
					?>
					</td>
					<td>
					<a href="#"  onClick="document.form1.process.value='view';document.form1.in_out.value='2';document.form1.id.value='<?php echo $reclist['id'];?>';document.form1.submit();">
						<?php 
						$chkattach=$db->db_num_rows($db->query("SELECT id FROM n_attach WHERE m_id ='".$reclist['id']."'"));
						if($chkattach>0){
							echo '<img src="mainpic/b_paperclip.gif" border="0" align="absmiddle"> ';
						}
						echo $reclist['m_subject'];
						?>
					</a>
					</td>
					<td nowrap>
					<?php
						if($in_out){
							$wh="AND m_to!=''";
						}else if($recview['m_flagdel']=='1'){
							$wh="AND m_flagdel ='1'";
						}						
						$k=0;
						$queryto=$db->query("SELECT m_to FROM n_message WHERE m_refer = '".$reclist['m_refer']."' $wh");
							while($recto=$db->db_fetch_array($queryto)){
								$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$recto['m_to']."'"));
								 if($recname['name_thai']){
                                     if($k==0){
                                         echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai'].''; 
										$k=1;
                                     }else{
                                     	echo '<br>'.$recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai']; 
									}
                                 }
							}
					?>
					</td>
					<td align="center" nowrap><?php echo $reclist['m_date'];?></td>
					<td align="center"><input name="chkfee<?php echo $i;?>" id="chkfee<?php echo $i;?>" type="checkbox" value="<?php echo $reclist['id'];?>" onClick="checkfeeeach(document.getElementById('allrecord'));if(this.checked==true){document.all.dels.value=(document.all.dels.value*1)+1;}else{document.all.dels.value=(document.all.dels.value*1)-1;}"></td>
					
				  </tr>
			  <?php
			  $i++;
			  	}
			  ?>
              <tr>
				<td bgcolor="#FFFFFF" colspan="4" align="left" nowrap>หน้า  <?php print CalShowPage($rows, $offset, $startoffset, $limit, $variables);?></td>
                <td bgcolor="#FFFFFF" align="center"><input name="button"  type="button" value="ลบข้อความ"  onClick="if(chkchecked(document.all.dels.value)){if(confirm('คุณแน่ใจหรือไม่ที่ต้องการลบข้อมูลนี้')){document.form1.process.value='delete';document.form1.submit();}}"></td>
                </tr>
			  <?php
			  	}else{
			  ?>
              <tr bgcolor="#FFFFFF">
                <td colspan="5"align="center"><font color="#FF0000"><strong>ไม่มีข้อมูล</strong></font></td>
              </tr>
			  <?php
			  	}
			  ?>
				</table>
				</form>
				<?php
				}else if($process=='deletebox'){
				    // m_flaginout='1'   ข้อความที่ได้รับ      m_flaginout='2'   ข้อความที่ส่งออก 
					// m_flagdel='1' ข้อความที่ลบจาก(in/out box)  m_flagdel='2' ข้อความที่ลบจาก(del box)
					/* ดังนั้นรายการที่จะให้แสดงในกล่องข้อควาที่ถูกลบ จะต้องเป็นข้อความที่
					     - ถูกส่งถึงผู้ใช้  m_to = ผู้ใช้  และยังไม่ล้าง m_flagdel='1'
					     - ผู้ใช้ gen_user_id = ผู้ใช้  เป็นคนส่งไป  m_flaginout='2'  และยังไม่ล้าง m_flagdel='1'
					*/
					$sql="SELECT * FROM n_message 
					WHERE (m_to = '".$HTTP_SESSION_VARS['EWT_MID']."' AND m_flagdel = '1')  
					             OR (gen_user_id = '".$HTTP_SESSION_VARS['EWT_MID']."' AND m_flagdel = '1' AND m_flaginout='2') 
					  ORDER BY m_date DESC";
					$query=$db->query($sql);
					$rows=$db->db_num_rows($query);
					//start ส่วนการคำนวณตัดหน้า
					if($limit == ""){ $limit = 20;} //ทำการกำหนดค่าการแสดงเรกคอร์ดต่อpage
					if (empty($offset) || $offset < 0) { $offset=0; }//ทำการกำหนดค่าเริ่มต้นpage
					$sqllist=$sql.CalSplitPage($rows, $offset, $limit);
					// end ส่วนการคำนวณตัดหน้า
					$querylist = $db->query($sqllist);
					$numlist = $db->db_num_rows($querylist);
				?>
				<form action="<?php $HTTP_SERVER_VARS['PHP_SELF'];?>" method="post" name="form1">
				<input type="hidden" name="process" value="<?php echo $_POST[process]?>">
                <input type="hidden" name="process2" value="<?php echo $_POST[process]?>">
				<input type="hidden" name="id" value="">
				<input type="hidden" name="in_out" value="">
				<input type="hidden" name="allrecord" value="<?php echo $numlist;?>">
               <input  type="hidden" name="dels"  value="">        
				<strong><font size="4" face="Tahoma">&nbsp;&nbsp;&nbsp;ข้อความที่ถูกลบ</font></strong> 
				<table width="96%"cellspacing="1" cellpadding="1" border="0" align="center" bgcolor="#000000">
				  <tr bgcolor="#CCCCCC">
					<td width="4%" align="center">&nbsp;</td>
					<td width="62%" align="center"><strong>หัวข้อ</strong></td>
					<td width="15%" align="center"><strong>จาก</strong></td>
					<td width="15%" align="center"><strong>วันที่</strong></td>
					<td width="4%" align="center">
					<?php if($numlist!=0){?>
							<input id="chkfeeall" name="chkfeeall" type="checkbox" value="Y" onClick="checkfeeall(document.getElementById('allrecord'));if(this.checked==true){document.all.dels.value=document.all.allrecord.value*1;}else{document.all.dels.value=0;}">
					<?php }?> 
					</td>
					
				  </tr>
				  <?php
					if($numlist>0){
					$i=1;
					while($reclist=$db->db_fetch_array($querylist)){
					$m_flagnewold=$reclist['m_flagnewold'];
					if($m_flagnewold==1){
						$BG='bgcolor="#FFFFCC"';
					}else{
						$BG='bgcolor="#FFFFFF"';
					}
				  ?>
				  <tr <?php echo $BG;?>><td align="center" nowrap>
					<?php 
					if($m_flagnewold=='1'){
					?>
						<img src="mainpic/mail2.gif" border="0" align="absmiddle" width="24">
					<?php 
						}else{
					 ?>
						<img src="mainpic/mail.gif" border="0" align="absmiddle" width="24">
					<?php 
					}
					?>
					</td>
					<td>
					<a href="#"  onClick="document.form1.process.value='view';document.form1.id.value='<?php echo $reclist['id'];?>';document.form1.submit();">
						<?php 
						$chkattach=$db->db_num_rows($db->query("SELECT id FROM n_attach WHERE m_id ='".$reclist['id']."'"));
						if($chkattach>0){
							echo '<img src="mainpic/b_paperclip.gif" border="0" align="absmiddle"> ';
						}
						echo $reclist['m_subject'];
						?>
					</a>
					</td>
					<td nowrap> 
					<?php 
					$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$reclist['m_from']."'"));						
						echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai']; ;
					?>
					</td>
					<td align="center" nowrap><?php echo $reclist['m_date'];?></td>
					<td align="center"><input name="chkfee<?php echo $i;?>" id="chkfee<?php echo $i;?>" type="checkbox" value="<?php echo $reclist['id'];?>" onClick="checkfeeeach(document.getElementById('allrecord'));if(this.checked==true){document.all.dels.value=(document.all.dels.value*1)+1;}else{document.all.dels.value=(document.all.dels.value*1)-1;}"></td>
					
				  </tr>
			  <?php
			  $i++;
			  	}
			  ?>
              <tr>
                <td bgcolor="#FFFFFF" colspan="4" align="left" nowrap>หน้า  <?php print CalShowPage($rows, $offset, $startoffset, $limit, $variables);?></td>
                <td bgcolor="#FFFFFF" align="center"><input name="button"  type="button" value="ลบข้อความ"  onClick="if(chkchecked(document.all.dels.value)){if(confirm('คุณแน่ใจหรือไม่ที่ต้องการลบข้อมูลนี้')){document.form1.process.value='deletemsg';document.form1.submit();}}"></td>
              </tr>
			  <?php
			  	}else{
			  ?>
              <tr bgcolor="#FFFFFF">
                <td colspan="5"align="center"><font color="#FF0000"><strong>ไม่มีข้อมูล</strong></font></td>
              </tr>
			  <?php
			  	}
			  ?>
				</table>
				</form>
				<?php
				}else if($process=='deletemsg'){
				 for($del=1;$del<=$_POST[allrecord];$del++){
						$db->query("update n_message set m_flagdel='2' WHERE  id = '".$_POST['chkfee'.$del]."' ");
                 }
							?>
									<form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
                                        <input type="hidden" name="process" value="<?php echo $_POST[process2]?>">
										<script language="javascript">
											alert('ลบข้อมูลเรียบร้อยแล้ว');
											document.formreturn.submit();
										</script>
									</form>
							<?php
				}else if($process=='delete'){
				  for($del=1;$del<=$_POST[allrecord];$del++){
						$db->query("update n_message set m_flagdel='1' WHERE  id = '".$_POST['chkfee'.$del]."' ");
                 }
							?>
									<form action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']?>" method="post" name="formreturn">
                                        <input type="hidden" name="process" value="<?php echo $_POST[process2]?>">
										<script language="javascript">
											alert('ลบข้อมูลเรียบร้อยแล้ว');
											document.formreturn.submit();
										</script>
									</form>
							<?php
				}else{
					$sql="SELECT * FROM n_message WHERE m_to = '".$HTTP_SESSION_VARS['EWT_MID']."' AND m_flaginout = '1' AND m_flagdel='0'  ORDER BY m_date DESC";
					$query=$db->query($sql);
					$rows=$db->db_num_rows($query);
					//start ส่วนการคำนวณตัดหน้า
					if($limit == ""){ $limit = 20;} //ทำการกำหนดค่าการแสดงเรกคอร์ดต่อpage
					if (empty($offset) || $offset < 0) { $offset=0; }//ทำการกำหนดค่าเริ่มต้นpage
					$sqllist=$sql.CalSplitPage($rows, $offset, $limit);
					// end ส่วนการคำนวณตัดหน้า
					$querylist = $db->query($sqllist);
					$numlist = $db->db_num_rows($querylist);
				?>
				<form action="<?php $HTTP_SERVER_VARS['PHP_SELF'];?>" method="post" name="form1">
				<input type="hidden" name="process" value="<?php echo $_POST[process]?>">
				<input type="hidden" name="id" value="">
				<input type="hidden" name="in_out" value="">
				<input name="allrecord" type="hidden" value="<?php echo $numlist;?>">
               <input  type="hidden" name="dels"  value="">        
                                <strong><font size="4" face="Tahoma">&nbsp;&nbsp;&nbsp;กล่องข้อความเข้า </font></strong> 
                                <table width="96%"cellspacing="1" cellpadding="1" border="0" align="center" bgcolor="#000000">
				  <tr bgcolor="#CCCCCC"> 
					<td width="4%" align="center">&nbsp;</td>
					<td width="62%" align="center"><strong>หัวข้อ</strong></td>
					<td width="15%" align="center"><strong>จาก</strong></td>
					<td width="15%" align="center"><strong>วันที่</strong></td>
					<td width="4%" align="center">
					<?php if($numlist!=0){?>
							<input id="chkfeeall" name="chkfeeall" type="checkbox" value="Y" onClick="checkfeeall(document.getElementById('allrecord'));if(this.checked==true){document.all.dels.value=document.all.allrecord.value*1;}else{document.all.dels.value=0;}">
					<?php }?> 
					</td>
				  </tr>
				  <?php
					if($numlist>0){
					$i=1;
					while($reclist=$db->db_fetch_array($querylist)){
					$m_flagnewold=$reclist['m_flagnewold'];
					if($m_flagnewold==1){
						$BG='bgcolor="#FFFFCC"';
					}else{
						$BG='bgcolor="#FFFFFF"';
					}
				  ?>
				  <tr <?php echo $BG;?>>
					<td align="center" nowrap>
					<?php 
					if($m_flagnewold=='1'){
					?>
						<img src="mainpic/mail2.gif" border="0" align="absmiddle" width="24">
					<?php 
						}else{
					 ?>
						<img src="mainpic/mail.gif" border="0" align="absmiddle" width="24">
					<?php 
					}
					?>
					</td>
					<td>
					<a href="#"  onClick="document.form1.process.value='view';document.form1.in_out.value='1';document.form1.id.value='<?php echo $reclist['id'];?>';document.form1.submit();">
						<?php 
						$chkattach=$db->db_num_rows($db->query("SELECT id FROM n_attach WHERE m_id ='".$reclist['id']."'"));
						if($chkattach>0){
							echo '<img src="mainpic/b_paperclip.gif" border="0" align="absmiddle"> ';
						}
						echo $reclist['m_subject'];
						?>
					</a>
					</td>
					<td nowrap> 
					<?php 
					$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$reclist['m_from']."'"));						
						echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai']; ;
					?>
					</td>
					<td align="center" nowrap><?php echo $reclist['m_date'];?></td>
					<td align="center"><input name="chkfee<?php echo $i;?>" id="chkfee<?php echo $i;?>" type="checkbox" value="<?php echo $reclist['id'];?>" onClick="checkfeeeach(document.getElementById('allrecord'));if(this.checked==true){document.all.dels.value=(document.all.dels.value*1)+1;}else{document.all.dels.value=(document.all.dels.value*1)-1;}"></td>
				  </tr>
			  <?php
			  $i++;
			  	}
			  ?>
              <tr>
 					<td bgcolor="#FFFFFF" colspan="4" nowrap>หน้า  <?php print CalShowPage($rows, $offset, $startoffset, $limit, $variables);?></td>
				  	<td bgcolor="#FFFFFF" align="center"><input name="button"  type="button" value="ลบข้อความ"  onClick="if(chkchecked(document.all.dels.value)){if(confirm('คุณแน่ใจหรือไม่ที่ต้องการลบข้อมูลนี้')){document.form1.process.value='delete';document.form1.submit();}}"></td>
               </tr>
			  <?php
			  	}else{
			  ?>
              <tr bgcolor="#FFFFFF">
                <td colspan="5"align="center"><font color="#FF0000"><strong>ไม่มีข้อมูล</strong></font></td>
              </tr>
			  <?php
			  	}
			  ?>
				</table>
				</form>
				<?php }?>
			</td>
		  </tr>
		</table>
	</td>
  </tr>
</table>
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
<?php  $db->db_close(); ?>
