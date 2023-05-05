<?php
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$path_cal = "";
	$lang_sh1 = explode('_',$sh);
			if($lang_sh1[1] != ''){
				$lang_shw = $lang_sh1[1];
				$lang_sh = '_'.$lang_sh1[1];
				
			}else{
				$lang_sh ='';
				$lang_shw='';
			}
			@include("language/language".$lang_sh.".php");
	function  echod($r) {
		$d = explode('_', $r);
		for($i = 1; $i<count($d); $i++) {
			if($i == count($d)-1) { echo '&nbsp;&nbsp;>';
			} else { echo '&nbsp;&nbsp;'; }
		}
	}
	
	if(!isset($_SESSION["EWT_MID"])){
		print "<script>";
		print "alert('".$text_general_login."');";
		print "location.href = 'ewt_login.php?fn=calendar_editevent.php?event_id=".$event_id."'; ";
		print "</script>";
	}
	if($_GET[event_id]){
		$event_id = $_GET[event_id];
		$sql_main = "SELECT * FROM cal_event  inner join cal_category on cal_event.cat_id = cal_category.cat_id  WHERE event_id = '$event_id' ";
		$query_main = $db->query($sql_main);
		$result_main = $db->db_fetch_array($query_main);
		$date_start = explode("-",$result_main[event_date_start]);
		$date_start = $date_start[2]."/".$date_start[1]."/".($date_start[0]+543);
		$date_end = explode("-",$result_main[event_date_end]);
		$date_end = $date_end[2]."/".$date_end[1]."/".($date_end[0]+543);
		$time_start  = explode(":",$result_main[event_time_start]);
		$time_end  = explode(":",$result_main[event_time_end]);
		if(isset($result_main[event_show_start]) && $result_main[event_show_start] != "0000-00-00"){
			$date_sh_start = explode("-",$result_main[event_show_start]);
			$date_sh_start = $date_sh_start[2]."/".$date_sh_start[1]."/".($date_sh_start[0]+543);
		}
		if(isset($result_main[event_show_end]) && $result_main[event_show_end] != "0000-00-00"){
			$date_sh_end = explode("-",$result_main[event_show_end]);
			$date_sh_end = $date_sh_end[2]."/".$date_sh_end[1]."/".($date_sh_end[0]+543);
		}
	}
	
	$sql_invite  = "select * from cal_invite where event_id = '".$_GET['event_id']."' ";
	$query_invite = $db->query($sql_invite);
	while($rs_invite = $db->db_fetch_array($query_invite)){
		if($rs_invite[person_id]){$id_staff.=$rs_invite[person_id].",";}
		if($rs_invite[division_id]){$id_division.=$rs_invite[division_id].",";}
		$db->query("USE ".$EWT_DB_USER);
		//กรณีเป็นคน
		$sql_staff = "select title.title_thai,name_thai,surname_thai from gen_user inner join title on gen_user.title_thai = title.title_id where gen_user_id = '$rs_invite[person_id]' ";
		$query_staff = $db->query($sql_staff);
		$fetch_staff = $db->db_fetch_array($query_staff);
		if($fetch_staff[name_thai]){ $name_staff.=$fetch_staff[title_thai]." ".$fetch_staff[name_thai]." ".$fetch_staff[surname_thai].",";}
	
		//กรณีเป็นหน่วยงาน
		$sql_division = "select * from org_name where org_id = '$rs_invite[division_id]' ";
		$query_division = $db->query($sql_division);
		$fetch_division = $db->db_fetch_array($query_division);
		if($fetch_division[name_org]){ $name_division.=$fetch_division[name_org].",";}
		
		$db->query("USE ".$EWT_DB_NAME);
		//$name_staff.="name".$rs_invite[person_id].",";
	}
	//$id_staff = substr($id_staff,0,-1);
	$name_staff = substr($name_staff,0,-1);
	//$id_division = substr($id_division,0,-1);
	$name_division = substr($name_division,0,-1);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<?php
include("ewt_script.php");	
?>
<script language="javascript1.2">
	var array_color = Array();
	<?php
		$sql_color = "select * from cal_color";
		$result = $db->query($sql_color);
		while($row_color = $db->db_fetch_array($result)) {
	?>
			array_color[<?php echo $row_color['color_id'];?>] = '<?php echo $row_color['color_color'];?>';
	<?php
		}
	?>
	function change_color(_id) {
		window.document.getElementById('event_color').style.background = '#'+array_color[_id];
	}
	
	function hidden_time(_obj) {
		if(_obj.checked == true) {
			window.document.getElementById('start_time').style.display = 'none';
			window.document.getElementById('end_time').style.display = 'none';
		} else {
			window.document.getElementById('start_time').style.display = '';
			window.document.getElementById('end_time').style.display = '';
		}
	}
	
	function change_color2(_id) {
		var lens=_id.length;
		var colors=_id.substring(0,7);
		var id2=_id.substring(7,lens);
		
		window.document.getElementById('event_color2').style.background = colors;
		document.AddForm.cat_id.value=id2;
	}
</script>
<link href="css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="js/calendar-th.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<script>
	function chk_null(me) {
		if(me.event_title.value == "") {
			alert("<?php echo $text_Gencalendar_alertactivity1;?>");
			me.event_title.focus();
			return false;
		}
		if(me.cat_id.value == ""){
			alert("<?php echo $text_Gencalendar_alertactivity2;?>");
			me.cat_id.focus();
			return false;
		}
	}
function show_regis(obj){
	if(obj.checked == true){
	window.document.getElementById('tr_regis_type').style.display = '';
	
	}else if(obj.checked == false){
	window.document.getElementById('tr_regis_type').style.display = 'none';
	window.document.getElementById('tr_regis').style.display = 'none';
	window.document.getElementById('num_register').value = '';
	window.document.getElementById('type_register').value = '';
	}
}
function show_regis_type(obj){
	if(obj.value=='1'){
	window.document.getElementById('tr_regis').style.display = '';
	}else if(obj.value==''){
	window.document.getElementById('tr_regis').style.display = 'none';
	window.document.getElementById('num_register').value = '';
	}
}
</script>
<table width="90%" height="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
	<tr> 
		<td>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<form name="AddForm" action="calendar_process.php" enctype="multipart/form-data" method="post">
				<input type="hidden" name="flag" value="add_event">
					<tr>
						<td height="30">
							<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1"  bgcolor="#CCCCCC">
								<tr><td><div align="center"><strong><?php echo $text_Gencalendar_texteditactivity ;?></strong></div></td></tr>
							</table>
						</td>
					</tr>
					<tr><td height="3">&nbsp;</td></tr>
					<tr>
						<td>
							<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#EBEBEB">
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textnameactivity;?>  :</td>
									<td><input name="event_title" type="text" id="event_title" size="60" value="<?php print $result_main[event_title];?>"></td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textcatactivity;?>  :</td>
									<td>
										<img src="<?php echo $path_cal;?>images/colorrange.gif" border="1" width="14" height="14" align="absmiddle" style="padding: 0; border-style:solid; border-color:#000000; background:<?php echo $result_main[cat_color]?>" id="event_color2">
										<label>
											<select name="cat_idt" onChange="change_color2(this.value)">
												<option value=""><?php echo $text_Gencalendar_textselectactivity;?></option>
												<?php
													$sql_category = "SELECT * FROM cal_category order by parent_cat_id";
													$result_category = $db->query($sql_category);
													while($row_color = $db->db_fetch_array($result_category)) {
														if($result_main[cat_id] == $row_color[cat_id]) $selected = "selected";
														else $selected = "";
												?><option value = "<?php echo $row_color[cat_color].$row_color[cat_id]?>" <?php echo $selected?>><?php echod($row_color[parent_cat_id]); echo $row_color[cat_name]?></option><?php } ?>
											</select>&nbsp;
											<span style="color:#FF0000">*</span>
										</label>
										<input type="text"  name="cat_id" value="<?php echo $result_main[cat_id]?>"  style="display:none">
									</td>
								</tr>
								<tr bgcolor="#FFFFFF" style="display:none">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textcoloractivity;?>:</td>
									<td>
										<img src="<?php echo $path_cal;?>mainpic/colorrange.gif" border="1" width="14" height="14" align="absmiddle" style="padding: 0; border-style:solid; border-color:#000000; background:#FFFFFF" id="event_color">
										<script>
											var color_id_edit = '<?php print $result_main[color_id]?>';
											for(var color_id in array_color){
												if(color_id == color_id_edit){
													window.document.getElementById('event_color').style.background = '#'+array_color[color_id];
													break;
												}
											}
										</script>
										<select name="col_id" class="body_small" id="event_category" onChange="change_color(this.value)">
										<?php  //=$disp->ddw_list ("select * from event_category",'event_category_name','event_category_id');
											$result = $db->query($sql_color);
											while($row_color = $db->db_fetch_array($result)) {
												if($row_color[color_id] == $result_main[color_id]) $selected = "selected";
												else $selected = "";
												print "<option value = \"$row_color[color_id]\" $selected>$row_color[color_name]</option>";
											}
										?>
										</select> 
									</td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" valign="top" class="text_th"><?php echo $text_Gencalendar_textdetailactivity;?> :</td>
									<td><textarea name="event_detail" cols="60" rows="4" id="event_detail"><?php print $result_main[event_detail]?></textarea></td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th">&nbsp;</td>
								  <td><input name="all_day" type="checkbox" id="all_day" value="1" onClick="hidden_time(this)" <?php if($result_main[event_all_day] == '1'){ print " checked";}?>>&nbsp;<?php echo $text_Gencalendar_textallday;?> </td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textdatestart;?> : </td>
									<td><input name="event_date_start" type="text" size="10" maxlength="10" id="event_date_start" value="<?php print $date_start;?>">&nbsp;<img src="<?php echo $path_cal;?>mainpic/b_calendar.gif" alt="..เปิดปฎิทิน." width="22" height="23" border="0" align="absmiddle" onClick="return showCalendar('event_date_start', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> </td>
								</tr>
								<tr bgcolor="#FFFFFF" id="start_time">
									<td class="text_th"><?php echo $text_Gencalendar_texttimestart;?> : </td>
									<td>
										<select name="event_start_hour" id="event_start_hour">
										<?php 
											for($i=0;$i<=23;$i++) { 
												if($time_start[0] == $i) $selected_time = " selected";
												else $selected_time = "";
										?><option value="<?php echo $i;?>" <?php echo $selected_time?>><?php echo sprintf('%02d', $i);?></option><?php } ?>
										</select>
										&nbsp;:&nbsp;
										<select name="event_start_min" id="event_start_min">
											<option value="00" <?php if($time_start[1] == "00"){print "selected";}?>>00</option>
											<option value="10" <?php if($time_start[1] == "10"){print "selected";}?>>10</option>
											<option value="20" <?php if($time_start[1] == "20"){print "selected";}?>>20</option>
											<option value="30" <?php if($time_start[1] == "30"){print "selected";}?>>30</option>
											<option value="40" <?php if($time_start[1] == "40"){print "selected";}?>>40</option>
											<option value="50" <?php if($time_start[1] == "50"){print "selected";}?>>50</option>
										</select>
									</td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textdateend;?>  :</td>
									<td><input name="event_date_end" type="text" size="10" maxlength="10" id="event_date_end" value="<?php print $date_end;?>">&nbsp;<img src="<?php echo $path_cal;?>mainpic/b_calendar.gif" alt="..เปิดปฎิทิน." width="22" height="23" border="0" align="absmiddle" onClick="return showCalendar('event_date_end', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> </td>
								</tr>
								<tr bgcolor="#FFFFFF" id="end_time">
									<td class="text_th"><?php echo $text_Gencalendar_texttimeend;?> : </td>
									<td>
										<select name="event_end_hour" id="event_end_hour">
											<?php
												for($i=0;$i<=23;$i++) { 
													if($time_end[0] == $i) $selected_time_end = " selected";
													else $selected_time_end = "";
											?><option value="<?php echo $i;?>" <?php echo $selected_time_end?>><?php echo sprintf('%02d', $i);?></option><?php } ?>
										</select>
										&nbsp;:&nbsp;
										<select name="event_end_min" id="event_end_min">
											<option value="00" <?php if($time_end[1] == "00"){print "selected";}?>>00</option>
											<option value="10" <?php if($time_end[1] == "10"){print "selected";}?>>10</option>
											<option value="20" <?php if($time_end[1] == "20"){print "selected";}?>>20</option>
											<option value="30" <?php if($time_end[1] == "30"){print "selected";}?>>30</option>
											<option value="40" <?php if($time_end[1] == "40"){print "selected";}?>>40</option>
											<option value="50" <?php if($time_end[1] == "50"){print "selected";}?>>50</option>
										</select>
									</td>
								</tr>
								<tr bgcolor="#FFFFFF" id="end_time">
									<td class="text_th" valign="center" id="tr_person"><?php echo $text_Gencalendar_textaccessory ;?> : </td>
									<td><input name="invite_name" type="text" id="invite_name" size="70" maxlength="255" value="<?php echo $name_staff?>" readonly>&nbsp;<img src="<?php echo $path_cal;?>mainpic/businessman_add.gif" alt="เพิ่มผู้ที่เกียวข้อง.." width="24" height="24" border="0" align="absbottom" onMouseOver="this.style.cursor='hand';"  onClick="window.open('calendar_list_staff.php','','width=800 , height=500, location=0');"> <input type="hidden" name="invite_id" id="invite_id" value="<?php echo $id_staff;?>"></td>
								</tr>
								<tr bgcolor="#FFFFFF" id="end_time">
									<td valign="center" class="text_th" id="tr_person"><?php echo $text_Gencalendar_textbccessory;?> : </td>
									<td><input name="invite_division" type="text" id="invite_division" size="70" maxlength="255" value="<?php echo $name_division?>" readonly>&nbsp;<img src="<?php echo $path_cal;?>mainpic/businessman_add.gif" alt="<?php echo $text_gencalendar_userconcern_add;?>.." width="24" height="24" border="0" align="absbottom" onMouseOver="this.style.cursor='hand';"  onClick="window.open('calendar_list_division.php','','width=800 , height=500, location=0');"> <input type="hidden" name="invite_divid" id="invite_divid" value="<?php echo $id_division;?>"></td>
								</tr>
								<tr bgcolor="#FFFFFF" id="end_time">
									<td class="text_th" valign="center" id="tr_person"><?php echo $text_Gencalendar_textwebpage;?> : </td>
									<td>
										<select name="typeFiles" onChange="
											if(this.value=='web'){ 
												document.all.link1.style.display=''; 
												document.all.link2.style.display='none'; 
											}else{
												document.all.link1.style.display='none'; 
												document.all.link2.style.display=''; 
											}">
											<option value="web"><?php echo $text_Gencalendar_webpage;?></option>
											<option value="fy" <?php if(ereg('calendar/',$result_main[event_link])){?>selected<?php }?>><?php echo $text_Gencalendar_webfile;?></option>
										</select>
										<DIV id="link1" >
											<input name="event_link" type="text" size="50" value="<?php print $result_main[event_link];?>">
											<img src="mainpic/folder_closed.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_general_Linkfile;?>.." style="cursor:hand" onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.event_link.value','','width=800 , height=500');"> <!--img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="<?php echo $text_general_View;?>" onClick="if(document.AddForm.event_link.value != ''){window.open('calendar_view_link.php?flag=link&img_name='+document.AddForm.event_link.value+'','','width=500 , height=400,scrollbars=1,resizable = 1');}" style="cursor:hand"-->
										</DIV>
										<DIV id="link2" style="display:none"> 
											<input type="file" name="fileupload"> 
											<input type="hidden" name="oldFile" value="<?php print $result_main[event_link];?>">
											<?php if(ereg('calendar/',$result_main[event_link])){?> <a href="<?php print $result_main[event_link];?>" target="_blank"><?php echo $text_Gencalendar_viewfile;?></a><?php }?>
										</DIV>
										<?php if(ereg('calendar/',$result_main[event_link])){?>
											<script language="javascript">
											document.all.link1.style.display='none'; 
											document.all.link2.style.display=''; 
											document.all.event_link.value='';
											</script>
										<?php }?>
									</td>
								</tr>
								<tr bgcolor="#FFFFFF" id="end_time">
									<td class="text_th" valign="center" id="tr_person"><?php echo $text_Gencalendar_textdateshow;?> : </td>
									<td><input name="event_show_start" type="text" size="10" maxlength="10" id="event_show_start" value="<?php echo $date_sh_start?>">&nbsp;<img src="<?php echo $path_cal;?>mainpic/b_calendar.gif" alt="..เปิดปฎิทิน." width="22" height="23" border="0" align="absmiddle" onClick="return showCalendar('event_show_start', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"></td>
								</tr>
								<tr bgcolor="#FFFFFF" id="end_time">
									<td class="text_th" valign="center" id="tr_person"><?php echo $text_Gencalendar_textdateshowend;?> : </td>
									<td><input name="event_show_end" type="text" size="10" maxlength="10" id="event_show_end" value="<?php echo $date_sh_end?>">&nbsp;<img src="<?php echo $path_cal;?>mainpic/b_calendar.gif" alt="..เปิดปฎิทิน." width="22" height="23" border="0" align="absmiddle" onClick="return showCalendar('event_show_end', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"></td>
								</tr>
								<tr bgcolor="#FFFFFF" id="end_time">
									<td class="text_th" valign="center" id="tr_person"><?php echo $text_Gencalendar_textPrivate;?> : </td>
									<td><input type="checkbox" name="event_private" value="1" <?php if($result_main[event_private] == '1'){print 'checked="checked"';}?>>&nbsp;<?php echo $text_Gencalendar_textPrivate;?></td>
								</tr>
								<?php if($result_main[main_event_id_repeat] ==0 || $result_main[main_event_id_repeat] == ""){ ?>
								<tr bgcolor="#FFFFFF" id="end_time">
									<td class="text_th"><?php echo $text_Gencalendar_textRepeatEvent;?> : </td>
									<td>
									<input name="repeat_chk" type="checkbox" value="1" onClick="
										if(this.checked == true){
											document.getElementById('repeat_time').disabled = '';
											for(var i =0;i<document.AddForm.repeat_chk.length;i++){
												document.AddForm.repeat_chk[i].checked = false;
											}
											this.checked = true;
										}
										"
										<?php if($result_main[event_repeat] == '1'){ print "checked"; } ?>>
									<?php echo $text_Gencalendar_textweek;?>
									<input name="repeat_chk" type="checkbox" value="2" onClick="
										if(this.checked == true){
											document.getElementById('repeat_time').disabled = '';
											for(var i =0;i<document.AddForm.repeat_chk.length;i++){
												document.AddForm.repeat_chk[i].checked = false;
											}
											this.checked = true;
										}
									"
									<?php if($result_main[event_repeat] == '2'){ print "checked"; } ?>>
									<?php echo $text_Gencalendar_textmonth;?>
									<input name="repeat_chk" type="checkbox" value="3" onClick="
										if(this.checked == true){
											document.getElementById('repeat_time').disabled = '';
											for(var i =0;i<document.AddForm.repeat_chk.length;i++){
												document.AddForm.repeat_chk[i].checked = false;
											}
											this.checked = true;
										}
									"<?php if($result_main[event_repeat] == '3'){ print "checked"; } ?>>
									<?php echo $text_Gencalendar_textyear;?>&nbsp;&nbsp;<?php echo $head_num;?>&nbsp;
									<input name="repeat_time" id="repeat_time" type="text" size="7" value="<?php echo $result_main[event_repeat_time]?>"></td>
							  </tr>
									<?php }// end if main_event_id_repeat?>
									<tr bgcolor="#FFFFFF"  style="display:<?php if($set_calendar_registor=='Y'){ echo "none";}else{ echo "";} ?> ">
									  <td class="text_th"><?php echo $text_Gencalendar_registor;?> : </td>
									  <td><input type="checkbox" name="add_register" value="1"  id="add_register" <?php 
										  if($result_main[event_registor] == '1'){
											print "checked";
										  }
										  ?> onClick="show_regis(this);">
										<?php echo $text_Gencalendar_registor2;?></td>
									</tr>
									<tr bgcolor="#FFFFFF" id="tr_regis_type" style="display:<?php if($result_main[event_registor] == '1'){ echo "";}else{ echo "none";} ?> ">
									  <td class="text_th">ประเภทการสมัครสมาชิก</td>
									  <td><select id="type_register" name="type_register" onChange="show_regis_type(this);">
													<option value="" <?php if($result_main[event_registor_type]==''){ echo 'selected';}?>>กลุ่มหน่วยงาน</option>
													<option value="1" <?php if($result_main[event_registor_type]=='1'){ echo 'selected';}?>>รายบุคคล[สมาชิกเท่านั้น]</option>
												  </select></td>
									</tr>
									<tr bgcolor="#FFFFFF" id="tr_regis" style="display:<?php if($result_main[event_registor_type] == '1'){ echo "";}else{ echo "none";} ?> ">
									  <td class="text_th">จำนวนที่รับสมัคร</td>
									  <td><input name="num_register" id="num_register" type="text" size="7" value="<?php echo $result_main[event_registor_num];?>">
										คน</td>
									</tr>
									
									<tr bgcolor="#EBEBEB">
										<td colspan="2" class="text_th"><div align="right"> </div></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td><br>
								<div align="right">
									<input type="hidden" name="ref" value="<?php echo $_GET[ref]?>">
									<input type="hidden" name="Flag" value="Edit">
									<input type="hidden" name="event_id" value="<?php print $_GET['event_id']?>">
									<input name="Submit" type="submit" class="BUTTON2" value="<?php echo $text_Gencalendar_textbuttonsubmit;?>" onClick="return chk_null(document.AddForm);">
									<input name="Submit2" type="reset" class="BUTTON2" value="<?php echo $text_Gencalendar_textbuttoncancle;?> " onClick="<?php if($_GET[ref] ==  'yes'){print "window.close();";}else{print "window.location.href = 'main_calendar.php';";}?>">
								</div>
							</td>
						</tr>
					</form>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
<?php $db->db_close(); ?>
