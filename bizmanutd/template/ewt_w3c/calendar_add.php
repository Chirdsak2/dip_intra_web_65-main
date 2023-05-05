<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	include("ewt_template.php");
	$path_cal = $path;
	@include("../language/language".$lang_sh.".php");
	
?>
<?php echo $template_design[0];?>
<script language="javascript1.2" type="text/javascript">
	var array_color = Array();
	<?
		$sql_color = "select * from cal_color";
		$result = $db->query($sql_color);
		while($row_color = $db->db_fetch_array($result)) {
	?>
	array_color[<?=$row_color['color_id'];?>] = '<?=$row_color['color_color'];?>';
	<?
		}
	?>
	
	function change_color(_id) {
		window.document.getElementById('event_color').style.background = '#'+array_color[_id];
	}

	function change_color2(_id) {
		var lens=_id.length;
		var colors=_id.substring(0,7);
		var id2=_id.substring(7,lens);
		
		window.document.getElementById('event_color2').style.background = colors;
		document.AddForm.cat_id.value=id2;
	}

	function hidden_time(_obj) {
		if(_obj.checked == true) {
			window.document.getElementById('start_time').style.display = 'none';
			window.document.getElementById('show_time').style.display = 'none';
		} else {
			window.document.getElementById('start_time').style.display = '';
			window.document.getElementById('show_time').style.display = '';
		}
	}
</script>
<script language="javascript" type="text/javascript">
	function chk_null(me) {
		if(me.event_title.value == "") {
			alert("<?php echo $text_Gencalendar_alertactivity1;?>");
			me.event_title.focus();
			return false;
		}
		if(me.cat_id.value == "") {
			alert("<?php echo $text_Gencalendar_alertactivity2;?>");
			me.cat_idt.focus();
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
	<?php
			$mainwidth = $F["d_site_content"];
			if($_GET['cur_year'] == ''){ $cur_year = date('Y');}
			?>
	<!-- เริ่มต้นกิจกรรมทั้งหมด-->
	<?php
	if(!isset($_SESSION["EWT_MID"])) {
		print "<script language=\"javascript1.2\" type=\"text/javascript\">";
		print "alert('".$text_general_login."');";
		print "location.href = 'ewt_login.php?fn=calendar_add.php'; ";
		print "</script>";
	}
	
	function echod($r) {
		$d=explode('_',$r);
		for($i=1;$i<count($d);$i++){
			if($i==count($d)-1){
				echo '&nbsp;&nbsp;>';
			}else{
				echo '&nbsp;&nbsp;';
			}
		}
	}
	//echo $_SESSION["EWT_MID"];
	?>
	<table width="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
	<tr> 
		<td>
		<form name="AddForm" action="calendar_process.php" enctype="multipart/form-data" method="post">
				<input type="hidden" name="flag" value="add_event">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="30" colspan="2">
							<table width="100%"  border="0" cellpadding="0" cellspacing="1"  bgcolor="#CCCCCC">
								<tr><td><div align="center"><h1><?php echo $text_Gencalendar_textaddactivity;?></h1></div></td></tr>
							</table>						</td>
					</tr>
					<tr><td height="3" colspan="2">&nbsp;</td></tr>
					<tr>
						<td colspan="2">
							<table width="100%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#EBEBEB">
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textnameactivity;?>  :</td>
									<td><input name="event_title" type="text" id="event_title" size="60" alt="<?php echo $text_Gencalendar_textnameactivity;?>"> <span style="color:#FF0000">*</span> </td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textcatactivity;?>  :</td>
									<td>
										<img src="<?=$path_cal;?>mainpic/colorrange.gif" name="event_color2" width="14" height="14" border="1"  id="event_color2" style="padding: 0; border-style:solid; border-color:#000000; background:#FFFFFF" alt="colorrange.gif">
										<label>
										 <?php
											  if($_SESSION["EWT_SMID"]=="" || $_SESSION["EWT_SMTYPE"]=="Y"    ){
													$sql_category = "SELECT * FROM cal_category order by parent_cat_id";
											}else{
													$sql_category = "SELECT * FROM cal_cat_permission RIGHT JOIN cal_category ON calcp_catid= cat_id 
																		WHERE  calcp_uid = '".$_SESSION["EWT_SMID"]."'   OR calcp_id is null   ORDER  BY parent_cat_id";
											}
											  ?>
											<select name="cat_idt" onChange="change_color2(this.value)" title="<?php echo $text_Gencalendar_textcatactivity;?>">
												<option value=""><?php echo $text_Gencalendar_textselectactivity;?></option>
												<?php  
													$result_category = $db->query($sql_category);
													while($row_color = $db->db_fetch_array($result_category)) {
												?><option value = "<?php echo $row_color[cat_color].$row_color[cat_id]?>"><?php echod($row_color[parent_cat_id]); echo $row_color[cat_name]?></option><?php
													}
												?>
											</select>&nbsp;
											<span style="color:#FF0000">*</span>										</label><input type="text"  name="cat_id" value="" alt="รหัส" style="display:none">								  </td>
								</tr>
								
								<tr bgcolor="#FFFFFF">
									<td width="120" valign="top" class="text_th"><?php echo $text_Gencalendar_textdetailactivity;?> :</td>
									<td><textarea name="event_detail" cols="60" rows="4" id="event_detail" title="<?php echo $text_Gencalendar_textdetailactivity;?>"></textarea></td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th">&nbsp;</td>
									<td><input name="all_day" type="checkbox" id="all_day" value="1" onClick="hidden_time(this)" alt="<?php echo $text_Gencalendar_textallday;?>">&nbsp;<?php echo $text_Gencalendar_textallday;?> </td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textdatestart;?> : </td>
									<td>
										<input name="event_date_start" type="text" size="10" maxlength="10" id="event_date_start" alt="<?php echo $text_Gencalendar_textdatestart;?>" value="<?=date('d/m/').(date('Y')+543);?>"readonly>
										<img src="<?=$path_cal;?>mainpic/b_calendar.gif" alt="..<?php echo $text_Gencalendar_textaltopen;?>." width="22" height="23" border="0"  onClick="return showCalendar('event_date_start', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">									</td>
								</tr>
								<tr bgcolor="#FFFFFF" id="start_time">
									<td class="text_th"><?php echo $text_Gencalendar_texttimestart;?> : </td>
									<td>
										<select name="event_start_hour" id="event_start_hour" title="ชั่วโมง">
											<? for($i=0;$i<=23;$i++) { ?>
											<option value="<?=$i;?>"><?=sprintf('%02d', $i);?></option>
											<? } ?>
										</select>
										&nbsp;:&nbsp;
										<select name="event_start_min" id="event_start_min"  title="นาที">
											<option value="00">00</option>
											<option value="10">10</option>
											<option value="20">20</option>
											<option value="30">30</option>
											<option value="40">40</option>
											<option value="50">50</option>
										</select>									</td>
								</tr>
								<tr bgcolor="#FFFFFF">
									<td width="120" class="text_th"><?php echo $text_Gencalendar_textdateend;?>  :</td>
									<td>
										<input name="event_date_end" type="text" size="10" maxlength="10" id="event_date_end"  alt="<?php echo $text_Gencalendar_textdateend;?>" value="<?=date('d/m/').(date('Y')+543);?>" readonly>
										<img src="<?=$path_cal;?>mainpic/b_calendar.gif" alt="..<?php echo $text_Gencalendar_textaltopen;?>." width="22" height="23" border="0"  onClick="return showCalendar('event_date_end', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">									</td>
								</tr>
								<tr bgcolor="#FFFFFF" id="show_time" >
									<td class="text_th"><?php echo $text_Gencalendar_texttimeend;?> : </td>
									<td>
										<select name="event_end_hour" id="event_end_hour" title="ชั่วโมง">
											<? for($i=0;$i<=23;$i++) { ?>
											<option value="<?=$i;?>"><?=sprintf('%02d', $i);?></option>
											<? } ?>
										</select>
										&nbsp;:&nbsp;
										<select name="event_end_min" id="event_end_min" title="นาที">
											<option value="00">00</option>
											<option value="10">10</option>
											<option value="20">20</option>
											<option value="30">30</option>
											<option value="40">40</option>
											<option value="50">50</option>
										</select>									</td>
								</tr>
								<tr bgcolor="#FFFFFF" style="display:none" >
									<td class="text_th"  ><?php echo $text_Gencalendar_textaccessory ;?> : </td>
									<td>
										<input name="invite_name" type="text" id="invite_name" size="70" alt="<?php echo $text_Gencalendar_textaccessory ;?> " maxlength="255" > 
										<!--<img src="<?=$path_cal;?>mainpic/businessman_add.gif" alt="<?php echo $text_Gencalendar_textalt;?>.." width="24" height="24" border="0"  onMouseOver="this.style.cursor='hand';"  onClick="window.open('calendar_list_staff.php','','width=800 , height=500, scrollbars=1,resizable = 1');">-->
										<input type="hidden" name="invite_id" id="invite_id" alt="ซ่อน">									</td>
								</tr>
								<tr bgcolor="#FFFFFF" style="display:none">
									<td  class="text_th" id="tr_division"><?php echo $text_Gencalendar_textbccessory;?> : </td>
									<td>
										<input name="invite_division" type="text" id="invite_division" size="70" alt="<?php echo $text_Gencalendar_textbccessory;?>" maxlength="255" > 
										<!--<img src="<?=$path_cal;?>mainpic/businessman_add.gif" alt="<?php echo $text_Gencalendar_textalt2;?>.." width="24" height="24" border="0"  onMouseOver="this.style.cursor='hand';"  onClick="window.open('calendar_list_division.php','','width=800 , height=500, scrollbars=1,resizable = 1');">-->
										<input type="hidden" name="invite_divid" id="invite_divid" alt="ซ่อน">									</td>
								</tr>
								<tr bgcolor="#FFFFFF" >
									<td class="text_th"  ><?php echo $text_Gencalendar_textwebpage;?> : </td>
									<td>
										<select name="typeFiles" onChange="if(this.value=='web') { document.all.link1.style.display=''; document.all.link2.style.display='none'; } else { document.all.link1.style.display='none'; document.all.link2.style.display=''; }" title="<?php echo $text_Gencalendar_textwebpage;?>">
											<option value="web"><?php echo $text_Gencalendar_webpage;?></option>
											<option value="fy"><?php echo $text_Gencalendar_webfile;?></option>
										</select>
										<DIV id="link1" >
											<input name="event_link" type="text" size="50" alt="<?php echo $text_Gencalendar_textwebpage;?>">
											<!--<img src="<?=$path_cal;?>mainpic/folder_closed.gif" height="16" width="16"  alt="Link.." style="cursor:hand" onClick="window.open('calenda_search_page.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.all.event_link.value','','width=800 , height=500');"> 
											<img src="<?=$path_cal;?>mainpic/document_view.gif" height="24" width="24"  alt="<?php echo $text_Gencalendar_textlookimg;?>" onClick="if(document.AddForm.event_link.value != ''){window.open('calendar_view_link.php?flag=link&amp;img_name='+document.AddForm.event_link.value+'','','width=500 , height=400,scrollbars=1,resizable = 1');}" style="cursor:hand">-->
										</DIV>
										<DIV id="link2" style="display:none"> <input type="file" name="fileupload" alt="Browse ..."> </DIV>									</td>
								</tr>
								<tr bgcolor="#FFFFFF" >
									<td class="text_th"  ><?php echo $text_Gencalendar_textdateshow;?> : </td>
									<td>
										<input name="event_show_start" type="text" size="10" maxlength="10" id="event_show_start" alt="<?php echo $text_Gencalendar_textdateshow;?>" value="">
										<img src="<?=$path_cal;?>mainpic/b_calendar.gif" alt="..<?php echo $text_Gencalendar_textaltopen;?>." width="22" height="23" border="0"  onClick="return showCalendar('event_show_start', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">									</td>
								</tr>
								<tr bgcolor="#FFFFFF" >
									<td class="text_th"  ><?php echo $text_Gencalendar_textdateshowend;?> : </td>
									<td>
										<input name="event_show_end" type="text" size="10" maxlength="10" id="event_show_end" alt="<?php echo $text_Gencalendar_textdateshowend;?>" value="">
										<img src="<?=$path_cal;?>mainpic/b_calendar.gif" alt="..<?php echo $text_Gencalendar_textaltopen;?>." width="22" height="23" border="0"  onClick="return showCalendar('event_show_end', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">									</td>
								</tr>
								<tr bgcolor="#FFFFFF" >
									<td class="text_th"  ><?php echo $text_Gencalendar_textPrivate;?> : </td>
									<td><label><input type="checkbox" name="event_private" value="1" checked="checked" alt="<?php echo $text_Gencalendar_textPrivate;?>"><?php echo $text_Gencalendar_textPrivate;?></label></td>
								</tr>
								<tr bgcolor="#FFFFFF" >
									<td class="text_th"><?php echo $text_Gencalendar_textRepeatEvent;?> : </td>
									<td>
										<input name="repeat_chk" type="checkbox" value="1"  alt="<?php echo $text_Gencalendar_textRepeatEvent;?>" onClick="if(this.checked == true) { document.getElementById('repeat_time').disabled = ''; for(var i =0;i<document.AddForm.repeat_chk.length;i++) { document.AddForm.repeat_chk[i].checked = false; } this.checked = true; }" >
										<?php echo $text_Gencalendar_textweek;?>
										<input name="repeat_chk" type="checkbox" value="2" alt="<?php echo $text_Gencalendar_textweek;?>" onClick="if(this.checked == true) { document.getElementById('repeat_time').disabled = ''; for(var i =0;i<document.AddForm.repeat_chk.length;i++) { document.AddForm.repeat_chk[i].checked = false; } this.checked = true; }">
										<?php echo $text_Gencalendar_textmonth;?>                  
										<input name="repeat_chk" type="checkbox" value="3" alt="<?php echo $text_Gencalendar_textmonth;?> " onClick="if(this.checked == true) { document.getElementById('repeat_time').disabled = ''; for(var i =0;i<document.AddForm.repeat_chk.length;i++) { document.AddForm.repeat_chk[i].checked = false; } this.checked = true; }">
										<?php echo $text_Gencalendar_textyear;?>
										&nbsp;&nbsp;<?php echo $head_num;?>
										<input name="repeat_time" id="repeat_time" type="text" size="7" alt="<?php echo $text_Gencalendar_textyear;?>">									</td>
								</tr>
								<tr bgcolor="#FFFFFF" style="display:none">
								  <td class="text_th"><?php echo $text_Gencalendar_registor;?> : </td>
								  <td><input type="checkbox" name="add_register" value="1"  id="add_register" alt="<?php echo $text_Gencalendar_registor;?>" onClick="show_regis(this);">
									<?php echo $text_Gencalendar_registor2;?></td>
								</tr>
								<tr bgcolor="#FFFFFF" id="tr_regis_type" style="display:none ">
								  <td class="text_th">ประเภทการสมัครสมาชิก</td>
								  <td><select name="type_register"  id="type_register" onChange="show_regis_type(this);" title="ประเภทการสมัครสมาชิก">
												<option value="">กลุ่มหน่วยงาน</option>
												<option value="1">รายบุคคล[สมาชิกเท่านั้น]</option>
											  </select></td>
								</tr>
								<tr bgcolor="#FFFFFF" id="tr_regis" style="display:none ">
								  <td class="text_th">จำนวนที่รับสมัคร</td>
								  <td><input name="num_register" id="num_register" type="text" size="7" alt="จำนวนที่รับสมัคร">
									คน</td>
								</tr>
								
								<tr bgcolor="#EBEBEB"><td colspan="2" class="text_th"><div align="right"> </div></td></tr>
							</table>						</td>
					</tr>
					<tr>
						<td width="29%">&nbsp;	</td>
				    <td width="71%"><br>
    <div align="left">
							  <input type="hidden" name="filename" value="<?php echo $_GET[filename];?>" alt="ซ่อน">
								<input type="hidden" name="Flag" value="Add" alt="ซ่อน">
								<input name="Submit" type="submit" class="BUTTON2" value="<?php echo $text_Gencalendar_textbuttonsubmit;?>" onClick="return chk_null(document.AddForm);">
						  </div>		</td>
					</tr>
			</table>	
		</form>
		</td>
	</tr>
</table>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>