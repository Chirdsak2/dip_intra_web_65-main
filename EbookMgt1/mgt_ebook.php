<?php
	session_start();
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	$mode = $_REQUEST["mode"];
	$ebookCode = $_REQUEST["ebookCode"];
	$dest = "../ewt/".$EWT_FOLDER_USER."/ebook";
	
	if ($mode=='edit') {
		$rec = $db->db_fetch_array($db->query ("select * from  ebook_info where ebook_code like '$ebookCode' "));
	}
?>
<html>
	<head>
		<title>E-Book</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
		<style type="text/css">
			<!--
				.head_table {	border-bottom:"buttonshadow solid 1px";
				border-left:"buttonhighlight solid 1px";
				border-right:"buttonshadow solid 1px";
				border-top:"buttonhighlight solid 1px";
				}
				.style3 {color: #0000FF}
			-->
		</style>
		<script>
			function chkForm (f) {
				if (f.name.value=='') {
					alert ("กรุณาใส่ชื่อ E-book");
					f.name.focus ();
					return false;
				}
				if (f.w.value=='') {
					alert ("กรุณาใส่ความกว้าง");
					f.w.focus ();
					return false;
				}
				if (f.h.value=='') {
					alert ("กรุณาใส่ความสูง");
					f.h.focus ();
					return false;
				}
				
				if (f.by.value == '') {
					alert ("กรุณาใส่ชื่อผู้สร้าง");
					f.by.focus ();
					return false;
				}
				var input;
				
				input = document.getElementById('pageFile');
				input_old = document.getElementById('pageFileOld');
				if (!input.value && !input_old.value) {
					alert("กรุณาเลือกภาพหน้าปก");
					return false;
				}
				return true;
			}
			
			function getPresetSize (obj) {
				var arrSizeW=new Array();
				var arrSizeH=new Array();
				var id= obj.value;
				<?php
					$queryPre = $db->query ("select * from ebook_preset order by ebook_preset_name");
					while ($recPre=$db->db_fetch_array ($queryPre)) {
						print "arrSizeW[".$recPre['ebook_preset_id']."] = '".$recPre['ebook_preset_w']."'; \n";
						print "arrSizeH[".$recPre['ebook_preset_id']."] = '".$recPre['ebook_preset_h']."'; \n";
					}
				?>
				
				obj.form.w.value = arrSizeW[id];
				obj.form.h.value = arrSizeH[id];
			}
			function chkFile (obj) {
				var f = obj.form;
				var str = "\\";
				var arr = obj.value.split (str);
				var num = arr.length;
				var ffile = arr[num-1];
				arr = ffile.split('.');
				var sur = arr[1];
				sur =  sur.toLowerCase();
				if (sur!='jpg' && sur!='gif' && sur!='png' && sur!='jpeg') {
					alert ("กรุณาเลือกเฉพาะไฟล์รูปภาพ");
					document.getElementById('pageFile').value = "";
					return false;
				}
			}
		</script>
	</head>
	<body leftmargin="0" topmargin="0" >
		<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
			<tr> 
				<td><img src="../theme/main_theme/ebook_function.gif" width="32" height="32" align="absmiddle"> 
				<span class="ewtfunction">การจัดการ E-Book</span> </td>
			</tr>
		</table>
		<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
			<td align="right">
				<a href="mgt_ebook.php" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
				เพิ่ม E-Book  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
				<a href="book_mgt_list.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
				การจัดการ</a><hr>
			</td>
		</table>
		
		<table width="94%" border="0" cellpadding="5" cellspacing="1"  align="center" class="ewttableuse">
			<tr class="ewttablehead">
				<td  colspan="2"><?php    if ($mode=='edit') { print 'กำหนดค่าใน E-Book'; }else {   print 'สร้าง E-Book ใหม่';  }   ?></td> 
			</tr>
			<form name="form1" method="post" action="proc_ebook.php" onSubmit="return chkForm(document.form1);" enctype="multipart/form-data">
				<?php  ?>
				<tr bgcolor="#FFFFFF">
					<td width="10%" height="25"  valign="top">ชื่อE-Book<!--Name--> <span style="color:red;">*</span> </td>
					<td width="90%"  align="left" valign="top"><label>
						<input name="name" type="text" size="50" value="<?php echo $rec['ebook_name']?>">
					</label></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td height="25"  valign="top">รายละเอียด<!--Description--> </td>
					<td  align="left" valign="top"><label>
						<textarea name="desc" cols="50" rows="3"><?php echo $rec['ebook_desc'];?></textarea>
					</label></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td height="25"  valign="top">เลือกขนาด<!--Preset&nbsp;--> </td>
					<td  align="left" valign="top">
						<select name="presetSize" onChange="getPresetSize (this);">
							<option value=""> Custom </option>
							<?php
								$queryPre = $db->query ("select * from ebook_preset order by ebook_preset_name");
								while ($recPre=$db->db_fetch_array ($queryPre)) {
									print "<option value='".$recPre['ebook_preset_id']."'>".$recPre['ebook_preset_name']."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td height="25"  valign="top">เลือกกลุ่ม<!--Preset&nbsp;--> </td>
					<td  align="left" valign="top">
						<select name="groupebook" >
							<?php
								$queryGroup = $db->query ("select * from ebook_group order by g_ebook_name");
								while ($recGroup=$db->db_fetch_array ($queryGroup)) {
									?><option value="<?php echo $recGroup['g_ebook_id']?>" <?php if($recGroup['g_ebook_id']==$rec['g_ebook_id'] or $recGroup['g_ebook_id']==$_SESSION['g_ebook_id']){echo 'selected';}?>><?php echo $recGroup['g_ebook_name']?></option><?php
								}
							?>
						</select>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td height="25"  valign="top">ขนาด<!--Size--> <span style="color:red;">*</span> </td>
					<td  align="left" valign="top"><label>
						ความกว้าง
						<input name="w" type="text" size="5" value="<?php echo $rec['ebook_w']?>">
						X ความสูง
						<input name="h" type="text" size="5" value="<?php echo $rec['ebook_h']?>">
					pixel</label></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td height="25"  valign="top">ผู้สร้าง<!--Create by--> <span style="color:red;">*</span> </td>
					<td  align="left" valign="top">
						<?php
							if (empty($rec['ebook_by'])) {
								$db->query ("USE ".$EWT_DB_USER);
								//print "select name_thai,surname_thai from gen_user where gen_user_id='13' ";
								$arrRec = $db->db_fetch_array($db->query("select name_thai,surname_thai from gen_user where gen_user_id='".$_SESSION["EWT_SMID"]."' "));
								$c_by =  $arrRec['name_thai'].' '.$arrRec['surname_thai'];
								$db->query ("USE ".$_SESSION["EWT_SDB"]."");
								}else{ 
								$c_by = $rec['ebook_by'];
							}
						?>
					<input type="text" name="by" id="by" value="<?php echo $c_by;?>"></td>
				</tr>
				<!-- <tr bgcolor="#FFFFFF">
					<td height="25" valign="top">กำหนดสถานะ<!--Status Show <span style="color:red;">*</span> </td>
					<td  align="left" valign="top"><label>
					<input name="status" type="radio" value="Y" <?php if ($rec['show_status']=='Y') { print 'checked';}?>>
					แสดง 
					<input name="status" type="radio" value="N"  <?php if ($rec['show_status']=='N' || $rec['show_status']=='') { print 'checked';}?>>
					ไม่แสดง</label></td>
				</tr>-->
				<tr bgcolor="#FFFFFF">
					<td height="25" valign="top">ภาพหน้าปก<!--Status Show--> <span style="color:red;">*</span> </td>
					<td  align="left" valign="top">
						<input type="file" name="pageFile" id="pageFile" onChange="chkFile (this);">
						<input type="hidden" name="pageFileOld" id="pageFileOld" value="<?php echo $rec['ebook_cover'];?>" />
						<?php
							if($rec['ebook_cover']!=""){
							?>
                            <a href="<?php echo $dest . '/' . $ebookCode . '/pages/' . $rec['ebook_cover'];?>" target="_self">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $dest . '/' . $ebookCode . '/pages/' . $rec['ebook_cover'];?>" width="16" height="16"  align="absmiddle" border="1" alt="คลิกเพื่อดูภาพ">
							</a>
							<?php
							}
						?>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
				<td height="25" valign="top">กำหนดสถานะ<!--Status Show--> <span style="color:red;">*</span> </td>
				<td  align="left" valign="top"><label>
				  <input name="status" type="radio" value="Y" <?php if ($rec['show_status']=='Y') { print 'checked';}?>>
				  แสดง 
				  <input name="status" type="radio" value="N"  <?php if ($rec['show_status']=='N' || $rec['show_status']=='') { print 'checked';}?>>
				ไม่แสดง</label></td>
			  </tr>
				<tr bgcolor="#FFFFFF">
					<td height="25" align="right" valign="top">&nbsp;</td>
					<td  align="left" valign="top"><label>
						<input type="submit" name="saveButton" value="    บันทึก    ">
						<input type="Button" name="saveButton2" value="  ยกเลิก   " Onclick="window.location.href='book_mgt_list.php?ebookCode=<?=$_SESSION['g_ebook_id']?>';">
						<input type="hidden" name="proc" value="saveEbook">
						<input type="hidden" name="ebookCode" value="<?php echo $rec['ebook_code'];?>">
					</label></td>
				</tr>
				<?php ?>
			</form>
		</table></td>
</tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>