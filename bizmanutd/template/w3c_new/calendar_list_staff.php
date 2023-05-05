<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body >
<script src="../js/jquery/jquery-1.2.2.min.js" type="text/javascript" language="javascript"></script>
<script src="../js/jquery/jquery.flydom.js" type="text/javascript" language="javascript"></script>
<script language="javascript" type="text/javascript">
$(document).ready(
	function() {
		var name =window.opener.document.getElementById('invite_name').value;
		var id  = window.opener.document.getElementById('invite_id').value;
		var invite_name = new Array();
		var invite_id = new Array();
		invite_name_chk = name.split(",");
		invite_id_chk = id.split(",");
		<?php if(count($id) == 0) { ?>
		if( invite_id_chk.length > 0 && invite_name_chk.length >0){
			for(var id_chk in invite_id_chk){
				if(invite_id_chk[id_chk] != "" &&invite_id_chk[id_chk] != ""){
					selectedStaff(invite_id_chk[id_chk], invite_name_chk[id_chk]);
				}
			}
		}
		<?php
			}
		?>
	}	
);

function selectedStaff(id, name) {
	$('#selectedTbl').createAppend(
		'tr', { align:'left', id:'selected'+id}, [
			'td', {  bgcolor:'#FFFFFF', height:'25' }, '&nbsp;&nbsp;&nbsp;<input type="hidden" name="id[]" value="'+id+'" id="id"><input type="hidden" name="name[]" value="'+name+'" id="name"><div align="left" id="divname'+id+'">'+name+'', 
			'td', {  bgcolor:'#FFFFFF', width:'30', align:"center", valign:"middle" }, '<img src="../mainpic/b_delete.gif"  style="cursor:hand;" border="0" onclick="delSelected(\''+id+'\')">'
		]
	);
}

function delSelected(id) {
	$("#selected"+id).remove();
	if($("#chk"+id+":checked").length > 0) { document.getElementById('chk'+id).checked = false; }
}
</script>
<script language="javascript" type="text/javascript">
	function create_Element(div_id,id,name,value,type) {
		var target = document.getElementById(div_id);
		var newHidden = document.createElement("input");
		newHidden.name = name;
		newHidden.id = id;
		newHidden.value = value;
		newHidden.type = type;
		target.appendChild(newHidden); 
	}
	
	function delete_Element(form_id,div_id,obj_id,arrayName,type,chk_value) {
		var target = document.getElementById(div_id)
		chk = document.getElementById(form_id).elements;
		for(var iii = 0;iii < chk.length;iii++) {
			var el = chk[iii];
			if(el.type ==type && el.name == arrayName ) {
				if(el.value==chk_value){
					el.disabled = "disabled";
					target.removeChild(document.getElementById(obj_id)); 
				}
			}
		}
	}
	
	function submitStaff() {
		window.opener.document.getElementById('invite_name').value  ="";
		window.opener.document.getElementById('invite_id').value  ="";
		var node_list = document.getElementsByTagName('input');
		for (var i = 0; i < node_list.length; i++) {
			var node = node_list[i];
			if (node.getAttribute('type') == 'hidden') {
				if(node.getAttribute('id') == 'id') {
					_inv     = window.opener.document.getElementById('invite_name').value;
					_inv_id = window.opener.document.getElementById('invite_id').value  ;
					if(_inv == '') {
						window.opener.document.getElementById('invite_name').value = document.getElementById('divname'+node.value).innerHTML;
						window.opener.document.getElementById('invite_id').value = node.value;
					} else {
						window.opener.document.getElementById('invite_name').value = _inv+','+document.getElementById('divname'+node.value).innerHTML;
						window.opener.document.getElementById('invite_id').value = _inv_id+','+node.value;
					}
				}
			}
		}
		window.close();
	}
</script>
<script language="javascript" type="text/javascript">
	var name =window.opener.document.getElementById('invite_name').value;
	var id  = window.opener.document.getElementById('invite_id').value;
	var invite_name = new Array();
	var invite_id = new Array();
	invite_name_chk = name.split(",");
	invite_id_chk = id.split(",");
</script>
<form name="form1" method="post" action="calendar_list_staff.php">
	<table width="100%"  style="height:400px" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
		<tr>
			<th bgcolor="#F9F9F9" scope="col" valign="top"><br>
				<table width="90%" style="height:30px" border="0" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC">
					<tr><th style="height:30px" bgcolor="#F4F4FF" align="left">&nbsp;<img src="mainpic/icon_more.gif" width="12" height="7"  alt="icon_more"> <strong>รายชื่อผู้ที่เกี่ยวข้อง</strong></th></tr>
					<tr>
						<th bgcolor="#FFFFFF" scope="col">
							<table width="95%" border="0">
								<tr>
									<th scope="col">
										<div align="left">&nbsp;
											<select name="search_select" id="search_select" onChange="if(this.value == ''){document.getElementById('search_text').style.display = 'none'; }else{document.getElementById('search_text').style.display = '';}">
												<option value="" <?php if($_POST[search_select] == ""){print " selected ";}?>>- แสดงทั้งหมด -</option>
												<option value="1" <?php if($_POST[search_select] == "1"){print " selected ";}?>> ชื่อ - นามสกุล</option>
												<option value="2" <?php if($_POST[search_select] == "2"){print " selected ";}?>>หน่วยงาน</option>
											</select>&nbsp;
											<input name="search_text" type="text" id="search_text"  value="<?php echo $_POST[search_text]?>" <?php if($search_select == ''){print ' style="display:none" ';}?>>&nbsp;
											<input type="submit" name="search" value="ค้นหา">
										</div>
									</th>
								</tr>
								<tr>
									<th scope="col">
										<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
											<tr>
												<th align="center" valign="top" bgcolor="#FFFFFF" scope="col">
													<table width="98%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" align="center">
														<tr>
															<td width="9%" style="height:25px" bgcolor="#F4F4FF" ><div align="center"><strong>เลือก</strong></div></td>
															<td style="height:25px" bgcolor="#F4F4FF"><div align="center"><strong>ชื่อ-นามสกุล</strong></div></td>
														</tr>
														<?php
															$page = $_POST[page];
															if(!$limit) $limit = 10;
															if($page == '' || $page < 1) $page =1;
															$page1 = $page-1;
															if($page1 == '' || $page1 < 0) $page1 = 0;
															
															if( $_POST[search_select] != "" && $_POST[search_text] != "") {
																$wh = " WHERE 1 = 1 ";
																if($_POST[search_select] == "1") {
																	$text = str_replace(" ", "%", trim($_POST[search_text]));
																	$wh .= "AND ( name_thai LIKE '%$text%' OR surname_thai LIKE '%$text%' )";
																} else if($_POST[search_select] == "2") {
																	$text = str_replace(" ", "%", trim($_POST[search_text]));
																	$wh .= "AND (name_org LIKE '%$text%')";
																}
															} else {
																$search_text == "";
															}
															$db->query("USE ".$EWT_DB_USER);
															$select = "select *,title.title_thai,name_thai,surname_thai, name_org, parent_org_id from gen_user inner join title on gen_user.title_thai = title.title_id inner join org_name on org_name.org_id = gen_user.org_id $wh order by org_name.org_id, gen_user_id";
															$query_main = $db->query($select);
															$num_rows = $db->db_num_rows($query_main);
															$num_all = $num_rows;
															if($num_all%$limit == 0) {
																@$page_all = $num_all/$limit;
															} else {
																@$page_all = (int)($num_all/$limit)+1;
															}
															if($page_all == 0) $page_all = 1;
															if($page >= $page_all) { $page1 = $page_all-1; $page = $page_all; }

															$sql_2 = $select." limit ".$page1*$limit.",$limit";
															$query = $db->query($sql_2);
															$num_rows_2 = $db->db_num_rows($query);

															if($num_rows_2 > 0) {
															for($i=1; $i<=$num_rows_2; $i++) {
																$result = $db->db_fetch_array($query);
														?>
														<tr>
														<td style="height:25px" bgcolor="#FFFFFF">
															<div align="center">
																<input name="chk<?php echo $result[gen_user_id]?>" type="checkbox" id="chk<?php echo $result[gen_user_id]?>" value="<?php echo $result[gen_user_id]?>" 
																onClick="
																if(this.checked) {
																	selectedStaff('<?php echo $result[gen_user_id]?>', '<?php echo $result[title_thai]." ".$result[name_thai]." ".$result[surname_thai]?>');
																} else {
																	delSelected('<?php echo $result[gen_user_id]?>');
																}" 
																<?php if(count($_POST[id]) > 0) foreach($_POST[id] as $value){ if($result[gen_user_id] == $value) print "checked";}?>
																>
																<script language="javascript" type="text/javascript">
																<?php if(count($_POST[id]) == 0 && count($_POST[name]) == 0 && $_POST[Submit2] != "บันทึก"){?>
																	if( invite_id_chk.length > 0){
																		for(var id_chk in invite_id_chk){
																			var chk_chk = '<?php echo $result[gen_user_id]?>';
																			if(invite_id_chk[id_chk] == chk_chk){
																				document.getElementById('chk'+chk_chk).checked = true;
																			}
																		}
																	}
																<?php }?>
																</script>
															</div>
														</td>
														<td style="height:25px" bgcolor="#FFFFFF">
														<?php
															$array_org_id = explode('_', $result[parent_org_id]);
															array_pop($array_org_id);
															$parent_org = implode('_', $array_org_id);
															$sql_parent_org = "select * from org_name where parent_org_id = '".$parent_org."'";
															$query_parent_org= $db->query($sql_parent_org);
															$num_rows_parent_org = $db->db_num_rows($query_parent_org);
															if($num_rows_parent_org > 0) {
																$result_parent_org = $db->db_fetch_array($query_parent_org);
																$text_org = $result_parent_org[name_org]."&nbsp;>&nbsp;".$result[name_org];
															} else {
																$text_org = $result[name_org];
															}
														?><?php echo $result[title_thai]." ".$result[name_thai]." ".$result[surname_thai]?>&nbsp;(<?php echo $text_org?>)</td></tr>
														<?php 
															}
														?>
													<tr>
														<td style="height:25px" colspan="2" bgcolor="#FFFFFF">
															<div align="right">หน้าที่ 
																<select name="page" onChange="document.form1.submit();">
																<?php
																	for($i=1;$i<=$page_all;$i++){
																		if($i == $page) $selected = "selected";
																		else $selected = "";
																		print "<option value=\"$i\" $selected>$i</option>";
																	}
																?>
																</select>
																/ <?php echo $page_all?> หน้า&nbsp;
															</div>
														</td>
													</tr>
													<?php  
														} else {
													?>
													<tr><td style="height:25px" colspan="2" bgcolor="#FFFFFF"><div align="center"><strong style="color:#FF0000">ไม่พบข้อมูล</strong></div></td></tr>
													<?php }?>
												</table>
											</th>
											<th width="250" align="center" valign="top" bgcolor="#FFFFFF" scope="col">
												<table width="98%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" align="center" id="selectedTbl">
													<tr>
														<td style="height:25px" bgcolor="#F4F4FF" align="center"><strong>รายชื่อที่ถูกเลือก</strong></td>
													    <td width="30" align="center" bgcolor="#F4F4FF"><strong>ลบ</strong></td>
													</tr>
													<?php
														for($kk=0; $kk<count($id); $kk++) {
													?>
													<tr id="selected<?php echo $id[$kk]; ?>">
														<td style="height:25px" bgcolor="#FFFFFF" align="left" valign="middle">&nbsp;&nbsp;&nbsp;<input type="hidden" name="id[]" value="<?php echo $id[$kk];?>" id="id"><input type="hidden" name="name[]" value="<?php echo $name[$kk];?>" name="name"><div align="left" id="divname<?php echo $id[$kk];?>"><?php echo $name[$kk]?></div></td>
													    <td width="30" align="center" bgcolor="#FFFFFF"><img src="../mainpic/b_delete.gif" alt="ลบ" width="14" height="14" border="0"  style="cursor:hand;" onClick="delSelected('<?php echo $id[$kk]?>')"></td>
													</tr>
													<?php
														}
													?>
												</table>
											</th>
										</tr>
									</table>
								</th>
							</tr>
						</table><br>
					</th>
				</tr>
			</table>
			<table width="100%" border="0" align="center" cellspacing="1">
				<tr><th scope="col"><input type="button" name="Submit2" value="บันทึก" onClick="submitStaff()"><input type="button" name="Submit3" value="ยกเลิก" onClick="window.close();//clear_chkbox(1,<?php echo $i?>,'chk');"></th></tr>
			</table>
		</th>
	</tr>
</table>
<div id="create_hidden"></div>
</form>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
<br>
</body>
</html>
<?php $db->db_close();  ?>
