<?php
	include("../lib/permission1.php");
	include("../lib/include.php");
	include("../lib/function.php");
	include("../lib/user_config.php");
	include("../lib/connect.php");
	
	if (strpos($_SERVER['SERVER_SOFTWARE'], "Win32") === false) {//Win32
		$pos = '0';
		}else{
		$pos = '1';
	}
	if (strpos($_SERVER['SERVER_SOFTWARE'], "Microsoft-IIS") === false) {
		$pos2 = '0';
		}else{
		$pos2 = '1';
	}
	if (strpos($_SERVER['SERVER_SOFTWARE'], "Apache") === false) {//Win32
		$pos = '0';
		}else{
		$pos = '1';
	}
	
	
	$recEbook = $db->db_fetch_array ($db->query("select * from ebook_info where ebook_code like '$ebookCode' "));
	$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '1' ")); 
	$maxSize = $recValue['ebook_value'];
	$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '2' ")); 
	$maxPDFSize = $recValue['ebook_value'];
	$dest = "../ewt/".$_SESSION["EWT_SUSER"]."/ebook/".$recEbook['ebook_code']; //Source ebook
	$destPage = $dest.'/pages/';
	
	if ($proc=='edit') {
		$recPage =$db->db_fetch_array ($db->query("select * from ebook_page where ebook_code like '$ebookCode' "));
		$mode = 'edit';
		$commentPage = ''; 
	}else if ($proc=='del'){
		
	}else {
		if (empty($refPage)) { //ADD
			$recPage =$db->db_fetch_array ($db->query("select * from ebook_page where ebook_code like '$ebookCode' order by ebook_page desc"));
			$refPage = ($recPage['ebook_page']+1);
			$commentPage = '  <span class="style5">(หน้าใหม่)</span>';
		}else{ //Insert
			$recPage = $db->db_fetch_array ($db->query("select * from ebook_page where ebook_code like '$ebookCode' and  ebook_page='$refPage' order by ebook_page desc"));
			$commentPage = '  <span class="style5">(แทรกหน้า)</span>';
			if (!empty($recPage)) {
				print "<script>alert ('หน้า $refPage มีแล้วในระบบ');self.location.href='".$PHP_SELF."?ebookCode=".$ebookCode."';</script>";
			}
		}
		$mode = 'add';
	}
?>
<html>
	<head>
		<title>Manage Page</title>
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
				.style4 {color: #666666}
				.style5 {color: #FF6600}
			-->
		</style>
		<script language="javascript">
			function chkFile (obj) {
				var f = obj.form;
				var str = "\\";
				var arr = obj.value.split (str);
				var num = arr.length;
				var ffile = arr[num-1];
				arr = ffile.split('.');
				var sur = arr[1];
				sur =  sur.toLowerCase();
				
				
				if ((sur=='pdf' && f.amtFile.value >1) || f.mode.value=='edit') {
					alert ("ไฟล์ PDF เลือกได้ครั้งละไฟล์เท่านั้น");
					return false;
				}
				if (sur!='jpg' && sur!='gif' && sur!='png' && sur!='jpeg' && sur!='pdf') {
					alert ("กรุณาเลือกไฟล์ที่ต้องการ Upload ให้ถูกต้อง");
					f.saveButton.disabled =  true;
					
					return false;
					}else {
					<?php if($pos == '1' || $pos2 == '1'){ ?>
						if (sur=='pdf') {
							//document.getElementById ('pdfout').style.display = '';
							f.saveButton.disabled =false;
						} 
						<?php }else{?>
						f.saveButton.disabled =  true;
					<?php } ?>
					if (sur !='pdf') {
						//document.getElementById ('pdfout').style.display = 'none';
						f.saveButton.disabled =false;
					}
				}
			}
			
			function chkFileInsert (obj) {//เช็คไฟล์ ตอนแทรกหน้า
				var f = obj.form;
				var str = "\\";
				var arr = obj.value.split (str);
				var num = arr.length;
				var ffile = arr[num-1];
				arr = ffile.split('.');
				var sur = arr[1];
				sur =  sur.toLowerCase();
				
				
				if (sur!='jpg' && sur!='gif' && sur!='png' && sur!='jpeg') {
					alert ("กรุณาเลือกไฟล์ที่ต้องการ Upload ให้ถูกต้อง");
					f.saveButton.disabled =  true;
					return false;
				}else{
					f.saveButton.disabled =  false;
				}
			}
			
			function show_loading () {
				if(document.getElementById("modifyType2").checked == true){
					if(document.getElementById("insertPage").value==""){
						alert("กรุณาระบุหน้าที่ต้องการแทรก");
						document.getElementById("insertPage").focus();
						return false;
					}
				}
				document.getElementById("status_load").innerHTML="กำลังอัพโหลดไฟล์ กรุณารอสักครู่...";
			}
			
			function cfmDel (ref) {
				if (confirm ("ยืนยันการลบหน้า "+ref)) {
					self.location.href='proc_ebook.php?proc=delPage&ebookCode=<?php echo $ebookCode;?>&ref='+ref;		   
				}
			}
			
			function chk_all(ele){
				var checkboxes = document.getElementsByName('chk_ebook_page');
				
				if(ele.value=="เลือกทั้งหมด"){
					for (var i = 0; i < checkboxes.length; i++) {
						checkboxes[i].checked = true;
					}
					ele.value="ยกเลิกทั้งหมด";
					}else{
					for (var i = 0; i < checkboxes.length; i++) {
						checkboxes[i].checked = false;
					}
					ele.value="เลือกทั้งหมด";
				}
			}
			
			function delByChek(){
				var ref="";
				var checkboxes = document.getElementsByName('chk_ebook_page');
				
				for (var i = 0; i < checkboxes.length; i++) {
					if(checkboxes[i].checked == true){
						ref = ref+checkboxes[i].value+",";
					}
				}
				if (ref != "" && ref != null) {
					if (confirm ("ยืนยันการลบหน้าที่เลือก")) {
						self.location.href='proc_ebook.php?proc=delPage&ebookCode=<?php echo $ebookCode;?>&ref='+ref;		   
					}
					}else{
					alert("กรุณาเลือกรายการที่ต้องการลบ");
					return false;
				}
			}
			
			
		</script>
	</head>
	<body leftmargin="0" topmargin="0" >
		<form name="form1" method="post" action="proc_ebook.php" enctype="multipart/form-data" onsubmit="show_loading();">
			<?php include("../FavoritesMgt/favorites_include.php");?>
			<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
				<tr> 
					<td><img src="../theme/main_theme/ebook_function.gif" width="32" height="32" align="absmiddle"> 
					<span class="ewtfunction">การจัดการ E-Book</span> </td>
				</tr>
			</table>
			<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
				<td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("การจัดการกลุ่ม E-Book : Modify Page :".$recEbook['ebook_name']);?> &module=ebook&url=<?php echo urlencode("mgt_page.php?ebookCode=".$_GET['ebookCode']);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; 
					<a href="mgt_ebook.php" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
					เพิ่ม E-Book  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
					<a href="book_mgt_list.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
					การจัดการ</a><hr>
				</td>
			</table>
			
			<table width="70%" border="0" cellpadding="5" cellspacing="1" bgcolor="FFFFFF" align="center" class="ewttableuse">
				<tr>
					<td  colspan="2" class="ewttablehead"> Modify Page : &quot; <?php echo $recEbook['ebook_name'];?> &quot;  </td>
				</tr>
				<tr>
					<td colspan="2" valign="top"> 
						<input type="radio" name="modifyType" id="modifyType1" value="1" onclick="self.location.href='mgt_page.php?ebookCode=<?php echo $ebookCode;?>&type=1';" <?php echo ($_GET['type']!=2 ? "checked":"");?>> เพิ่มหน้า
						<input type="radio" name="modifyType" id="modifyType2" value="2" onclick="self.location.href='mgt_page.php?ebookCode=<?php echo $ebookCode;?>&type=2';" <?php echo ($_GET['type']==2 ? "checked":"");?>> แทรกหน้า 
					</td>
				</tr>
			</table>
			<br>
			<?php 
				if($_GET['type']!=2){
			?>
			<table width="70%" border="0" cellpadding="5" cellspacing="1" bgcolor="FFFFFF" align="center" class="ewttableuse">
				<tr>
					<td  colspan="2" class="ewttablehead"> เพิ่มหน้า  </td>  
				</tr>
				<!--<span id="rowPic">-->
				<tr bgcolor="#FFFFFF">
					<td width="38%" height="12" valign="top">จำนวนไฟล์ที่ Upload </td>
					<td width="62%"  align="left" valign="top">
						<?php 
							if  (empty($amtFile)) {
								$amtFile = 1;
							}
						?>
						<input name="amtFile" type="text" size="5" value="<?php echo $amtFile;?>">
						<input type="button" name="Button" value="Ok" onClick="self.location.href='mgt_page.php?amtFile='+this.form.amtFile.value+'&ebookCode=<?php echo $ebookCode;?>';"> 
					<input name="lastPage" type="hidden"  value="<?php echo $refPage;?>">				</td>
				</tr>
				<?php 
					$i=0;
					while ($i < $amtFile) {
					?>
					<tr bgcolor="#FFFFFF">
						<td height="7" valign="top"><b>หน้า  <?php echo $refPage;?>  </b>  <?php echo $commentPage?>  : </td>
						<td width="81%"  align="left" valign="top">
						<input type="file" name="pageFile<?php echo $refPage?>" onChange="chkFile (this);"><br>
						<font color="red">
							* ต้องเป็นไฟล์นามสกุล GIF,PNG,JPG,JPEG /ขนาดไฟล์ไม่เกิน 
							<?php echo $maxSize;?>
							K<br>
							<?php 
								if($pos == '1' || $pos2 == '1'){
									if ($mode!='edit' && $amtFile ==1) {  
									?>
									*
									PDF ขนาดไฟล์ไม่เกิน 
									<?php echo $maxPDFSize;?> M
									<?php } 
								}
							?>
							</font>
							<br>
						</td>
					</tr>
					<tr bgcolor="#FFFFFF" id="pdfout" style="display:none">
						<td height="6" align="right" valign="top">&nbsp;</td>
						<td  align="left" valign="top">PDF Output: Zoom
							
							<input name="zoom" type="text" size="5" value="100"> % Quality 
							<input name="quality" type="text" size="5" value="100"> 
						% </td>
					</tr>
					<?php 
						$refPage++;
						$i++;
					} // while ?>
					<tr bgcolor="#FFFFFF">
						<td height="25" align="right" valign="top">&nbsp;</td>
						<td  align="left" valign="top"><label>
							<input type="submit" name="saveButton" value="Save" disabled>
							<input type="hidden" name="ebookCode" value="<?php echo $ebookCode;?>">
							<input type="hidden" name="proc" value="savePage">
							<input type="hidden" name="mode" value="<?php echo $mode;?>">
						</label><span id="status_load"></span>
						</td>
					</tr>
					<?php ?>
			</table>
			<?php 
				}else{
			?>
			<table width="70%" border="0" cellpadding="5" cellspacing="1" bgcolor="FFFFFF" align="center" class="ewttableuse" >
				<tr>
					<td  colspan="2" class="ewttablehead"> แทรกหน้า  </td>  
				</tr>
				<!--<span id="rowPic">-->
				<tr bgcolor="#FFFFFF">
					<td width="38%" height="12" valign="top">กรุณาระบุหน้าที่ต้องการแทรก</td>
					<td width="62%"  align="left" valign="top">
						หน้า <input name="insertPage" type="text" id="insertPage" size="2">
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
						<td height="7" valign="top"></td>
						<td width="81%"  align="left" valign="top"><input type="file" name="pageFileInsert" onChange="chkFileInsert (this);">
							<font color="red">
							* การแทรกหน้าต้องเป็นไฟล์นามสกุล GIF,PNG,JPG,JPEG /ขนาดไฟล์ไม่เกิน 
							<?php echo $maxSize;?>
							K
							</font>
							<br>
						</td>
						
					</tr>
				<tr bgcolor="#FFFFFF">
						<td height="25" align="right" valign="top">&nbsp;</td>
						<td  align="left" valign="top"><label>
							<input type="submit" name="saveButton" value="Save" disabled>
							<input type="hidden" name="ebookCode" value="<?php echo $ebookCode;?>">
							<input type="hidden" name="proc" value="savePage">
							<input type="hidden" name="mode" value="<?php echo $mode;?>">
						</label><span id="status_load"></span>
						</td>
					</tr>
					<?php ?>
			</table>
			<?php 
				}
			?>
			<br>
			<!--
			<table width="70%" border="0" cellpadding="5" cellspacing="1" bgcolor="FFFFFF" align="center" class="ewttableuse">
				<tr>
					<td><a href="mgt_page.php?ebookCode=<?php echo $ebookCode;?>"><img src="images/element_new.png" alt="เพิ่มหน้า" width="16" height="16" border="0" align="absmiddle">เพิ่มหน้า</a> | <img src="images/element_new_before.png" alt="แทรกหน้า" width="16" height="16" align="absmiddle">แทรกหน้า
						<input name="insertPage" type="text" id="insertPage" size="2" onblur="if (this.form.insertPage.value!='') {self.location.href='mgt_page.php?ebookCode=<?php echo $ebookCode;?>&refPage='+this.form.insertPage.value}else{ alert('กรุณาระบุหน้าที่ต้องการแทรก');this.form.insertPage.focus();}">
						<input type="button" name="Button" value="แทรก" onClick="if (this.form.insertPage.value!='') {self.location.href='mgt_page.php?ebookCode=<?php echo $ebookCode;?>&refPage='+this.form.insertPage.value}else{ alert('กรุณาระบุหน้าที่ต้องการแทรก');this.form.insertPage.focus();}"></td>
					<td align="right"><a href="<?php echo $dest.'/index.html';?>" target="_blank"><img src="../theme/main_theme/g_view.gif" width="16" height="16" alt="Preview E-Book" border="0" align="absmiddle"> แสดง E-Book</a></td>
				</tr>
			</table>
			<br>
			-->
			<table width="70%" border="0" cellpadding="5" cellspacing="1" bgcolor="FFFFFF" align="center" class="ewttableuse">
				<tr>
					<td align="left"><button type="button" onclick="window.open('<?php echo $dest.'/index.html';?>');"><img src="../theme/main_theme/g_view.gif" width="16" height="16" alt="Preview E-Book" border="0" align="absmiddle"> แสดง E-Book</button></td>
				</tr>
			</table>
			<br>
			<table width="40%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
				<tr>
					<td valign="top" bgcolor="#F4F4F4" class="MemberTitle">
						<table width="100%" border="0" cellpadding="5" cellspacing="1" class="ewttableuse">
							<input type="hidden" name="Flag2" value="DelGroup">
							<input type="hidden" name="cid2" >
							<input type="hidden" name="rss_title2" >
							<input type="hidden" name="rss_url2" >
							<input type="hidden" name="rss_row2" >
							<tr align="center"  class="ewttablehead">
								<td width="10%" ><input name="btn_chk_all" id="btn_chk_all" type="button" onclick="chk_all(this);" value="เลือกทั้งหมด"/></td> 
								<td width="10%" > </td> 
								<td width="40%" >หน้า</td>
								<td width="40%" >วันที่แก้ไข</td>
								<!--<td width="10%" >ประเภท</td>-->
							</tr>
							<?php
								$page = 1;
								$sql1="select * from ebook_page where ebook_code like '$ebookCode'  order by ebook_page";
								$exc1=mysql_query($sql1);
								$num_rows = mysql_num_rows($exc1);
								
								if(!$_GET[curPage]) $_GET[curPage]=1;
								$limit = 10;
								$Totalpages=ceil($num_rows/$limit);
								
								$start = ($_GET[curPage]-1)*$limit;
								$query=mysql_query($sql1."  LIMIT $start,$limit");
								$count=mysql_num_rows($query);
								
								$num = 0;
								if($count > 0){
									while ($rec = $db->db_fetch_array($query)) {
										
									?>
									<tr bgcolor="#FFFFFF">
										<td align="center" >
											<input type="checkbox" name="chk_ebook_page" id="" value="<?php echo $rec['ebook_page'];?>">
										</td>
										<td  align="center"  >
											<a href="<?php echo $destPage.$rec['ebook_page_file'];?>" target="_blank"><img src="../theme/main_theme/g_view.gif" width="16" height="16" alt="ดูหน้านี้"  border="0"></a> 
											<!--a href="<?php //echo $PHP_SELF;?>?proc=edit&refPage=<?php //echo $rec['ebook_page'];?>&ebookCode=<?php //echo $ebookCode;?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไขหน้านี้" border="0"></a--> 
											<!--<a href="javascript:cfmDel ('<?php echo $rec['ebook_page'];?>');"><img src="../theme/main_theme/g_del.gif" width="16" height="16" alt="ลบหน้านี้" border="0"></a>-->
										</td>
										<td height="25" align="center" valign="top"><?php echo $rec['ebook_page'];?></td>
										<td height="25" align="center" valign="top">
											<?php
												$arrDate = explode ('-',$rec['ebook_page_date']);
												print $arrDate['2'].'/'.$arrDate['1'].'/'.$arrDate['0'];
											?>
										</td>
										<!--
											<td  align="center" valign="top">
											<?php
												$iconFile = $rec['ebook_page_type'].'.gif';
												print ' <img src="images/icon/'.$iconFile.'" width="14" height="16" align="absmiddle" alt="'.$rec['ebook_page_type'].' ไฟล์">';
											?>
											
											</td>
										-->
									</tr>
									<?php  
										$page++;
									}// while
									}else{
									echo '<tr bgcolor="#FFFFFF"><td align="center" colspan="4">ไม่พบข้อมูล</td></tr>';
								}
							?>
							<?php		
								
								if($Totalpages==1){
									$p1=$p2=$p3=$p4=1;
									}else if($_GET[curPage]==1){
									$p1=1;
									$p2=$_GET[curPage];
									$p3=$_GET[curPage]+1;
									$p4=$Totalpages;
									}else if($_GET[curPage]==$Totalpages){
									$p1=1;
									$p2=$_GET[curPage]-1;
									$p3=$_GET[curPage];
									$p4=$Totalpages;
									}else{
									$p1=1;
									$p2=$_GET[curPage]-1;
									$p3=$_GET[curPage]+1;
									$p4=$Totalpages;
								}
								
							?>
							<tr bgcolor="#FFFFFF">
								<td  colspan="5"><input type="button" value="ลบที่เลือก" onclick="delByChek();"></td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td  colspan="5">&nbsp;&nbsp;<strong>หน้า : </strong> ( หน้า <?php echo $_GET[curPage]; ?> จากทั้งหมด <?php echo $Totalpages; ?> หน้า ) <a href="?curPage=<?php echo $p1; ?>&ebookCode=<?php echo $ebookCode;?>"><img src="../images/arrow_first.gif" alt="หน้าแรก" width="10" height="12" hspace="5" border="0" /></a> <a href="?curPage=<?php echo $p2; ?>&ebookCode=<?php echo $ebookCode;?>"><img src="../images/arrow_prev.gif" alt="ย้อนกลับ" width="7" height="12" hspace="3" border="0" /></a> <a href="?curPage=<?php echo $p3; ?>&ebookCode=<?php echo $ebookCode;?>"><img src="../images/arrow_next.gif" alt="ถัดมา" width="7" height="12" hspace="3" border="0" /></a> <a href="?curPage=<?php echo $p4; ?>&ebookCode=<?php echo $ebookCode;?>"><img src="../images/arrow_last.gif" alt="หน้าสุดท้าย" width="10" height="12" hspace="5" border="0" /></a> &nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
<?php $db->db_close(); ?>
