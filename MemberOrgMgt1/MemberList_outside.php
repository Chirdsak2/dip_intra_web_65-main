<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

function chk_status($status){
	switch($status){
			case 1:$status_type = 'ใช้งาน';break;
			case 2:$status_type = 'ไม่ใช้งาน';break;
			default:$status_type = '';break;	
	}
	return $status_type;
}
 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
if(empty($limit)){
$limit = 20;
}

if($_GET["proc"]=='delete'){
$sql_chk = $db->db_fetch_array($db->query("select * from gen_user where emp_type_id ='".$_GET["gen_user_id"]."' "));
$db->query("USE ".$_SESSION["EWT_SDB"]);
$db->write_log("delete","member","ลบสมาชิกชื่อ : ".$sql_chk['name_thai'].'  '.$sql_chk['surname_thai']);
$db->query("USE ".$EWT_DB_USER);
$sql_del = "delete from gen_user where gen_user_id = '".$_GET["gen_user_id"]."'";
$db->query($sql_del);

		echo "<script language=\"javascript\">";
		echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='MemberList_outside.php';" ;
		echo "</script>";
}
if($_GET["proc"]=='approve'){
$sql_update = "update gen_user set  status = '1'  where gen_user_id = '".$_GET["gen_user_id"]."'";
$db->query($sql_update);
$sql_chk = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id ='".$_GET["gen_user_id"]."' "));
$mail_to = $sql_chk['email_person'];
$db->query("USE ".$_SESSION["EWT_SDB"]);
$db->write_log("approve","member","อนุมัติการใช้งานชื่อ : ".$sql_chk['name_thai'].'  '.$sql_chk['surname_thai']);
$db->query("USE ".$EWT_DB_USER);

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
												<td bgcolor="#FFFFFF"><font color="#666666" size="2" face="Tahoma">&nbsp;&nbsp;&nbsp;<br>ขอขอบพระคุณที่ท่านให้ความสนใจเว็บไซต์ของเรา <br>
											    &nbsp;ขณะนี้ชื่อผู้ใช้ของท่านได้รับการยืนยันการใช้งานเป็นสมาชิกเรียบร้อยแล้ว </font><br>
												&nbsp;&nbsp;<font color="#666666" size="2" face="Tahoma">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;username :'.$sql_chk['gen_user'].'<br>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;password : '.$sql_chk['gen_pass'].'<br>
														    <br>
																	
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
		$subject = "ระบบยืนยันสมาชิก";

		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";

		/* additional headers */
		$headers .= "From: Member System <webmaster@prd.go.th>\r\n";
		
		@mail($mail_to, $subject, $message, $headers);



		echo "<script language=\"javascript\">";
		echo "alert('ข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='MemberList_outside.php';" ;
		echo "</script>";
}
if($_GET["proc"]=='approvecancle'){
$sql_update = "update gen_user set  status = '2'  where gen_user_id = '".$_GET["gen_user_id"]."'";
$db->query($sql_update);
$sql_chk = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id ='".$_GET["gen_user_id"]."' "));
$mail_to = $sql_chk['email_person'];
$db->query("USE ".$_SESSION["EWT_SDB"]);
$db->write_log("approve","member","ยกเลิกการใช้งานชื่อ : ".$sql_chk['name_thai'].'  '.$sql_chk['surname_thai']);
$db->query("USE ".$EWT_DB_USER);


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
									<td align="left" valign="middle" bgcolor="FFFFFF"><br>
									  <br>
										<table width="776" height="80%" border="0" cellpadding="2" cellspacing="0" bgcolor="B4BDC7">
											<tr><td width="772" bgcolor="#FFFFFF"><font color="#666666" size="2" face="Tahoma"><strong>เรียนท่านสมาชิก</strong></font></td>
										</tr>
											<tr> 
												<td bgcolor="#FFFFFF"><font color="#666666" size="2" face="Tahoma">&nbsp;&nbsp;เนื่องจาก webmaster@prd.go.th ความจำเป็นบางประการ จึงต้องขอยกเลิกการใช้งานชื่อผู้ใช้นี้ </font>
														    <br>
																	</font><font size="2" face="Tahoma" color="#FF0000"><strong>&nbsp;&nbsp;หมายเหตุ:&nbsp;</strong></font><font color="#666666" size="2" face="Tahoma"> ขออภัยในความไม่สะดวก และขอขอบพระคุณในความร่วมมือของท่าน</font>
																	<br>
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
		$subject = "ระบบยืนยันสมาชิก";

		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=UTF-8\r\n";

		/* additional headers */
		$headers .= "From: Member System <webmaster@prd.go.th>\r\n";
		
		@mail($mail_to, $subject, $message, $headers);
		echo "<script language=\"javascript\">";
		echo "alert('แก้ไขข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='MemberList_outside.php';" ;
		echo "</script>";
}
	?>
<html>
<head>
<title>Member Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ข้อมูล<A href="MemberList_outside.php" target="member_body">สมาชิก</A> </span> </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ข้อมูลสมาชิก");?>&module=member&url=<?php echo urlencode("MemberList_outside.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a onMouseOver="this.style.cursor='hand';" onClick="self.location.href='MemberList_outside_print.php';"><span class="MemberHead"><img src="../images/workplace.gif" alt="พิมพ์รายชื่อสมาชิก" width="20" height="20" border="0">พิมพ์รายชื่อสมาชิก</span></a>
        <hr>
      </td>
    </tr>
  </table>
  <form name="form1" method="post" action="">
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="87%" colspan="2" ><table width="60%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewttableuse" style="border-collapse:collapse">
                  <tr>
                    <td>
                      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#B2B2B2" >
                        <tr class="ewttablehead">
                          <td colspan="2">ค้นหา</td>
                        </tr>
                        <tr>
                          <td width="25%" align="left" bgcolor="#FFFFFF"> ชื่อ-สกุล :</td>
                          <td width="75%" align="left" bgcolor="#FFFFFF"><input name="namesurname" type="text" size="50" value="<?php echo $namesurname;?>" /></td>
                        </tr>
                        <tr>
                          <td align="left" bgcolor="#FFFFFF">กลุ่มสมาชิก  : </td>
                          <td align="left" bgcolor="#FFFFFF"><select name="emp_type_id" id="emp_type_id" >
            <option value="">--โปรดเลือก--</option>
            <?php 
						$sql_emp_type = "SELECT * FROM emp_type WHERE emp_type_status = '4' ";
						$query_emp_type = $db->query($sql_emp_type);
						while($rs_emp_type = $db->db_fetch_array($query_emp_type)){
							if($rs_emp_type[emp_type_id] == $emp_type_id) $selected_emp_type = "selected";
							else $selected_emp_type = "";
							print '<option value="'.$rs_emp_type[emp_type_id].'" '.$selected_emp_type.'>'.$rs_emp_type[emp_type_name].'</option>';
						}
					?>
          </select></td>
                        </tr>
                        <tr>
                          <td align="left" bgcolor="#FFFFFF">เรียงข้อมูล</td>
                          <td align="left" bgcolor="#FFFFFF">
						  <select name="sort_by">
						  <option value="" <?php  if($_REQUEST["sort_by"] == ''){ echo "selected";}?>>--โปรดเลือก--</option>
                          <option value="1" <?php  if($_REQUEST["sort_by"] == '1'){ echo "selected";}?>>เรียงข้อมูลตามวันล่าสุด</option>
						  <option value="2" <?php  if($_REQUEST["sort_by"] == '2'){ echo "selected";}?>>เรียงข้อมูลตามสถานะไม่ใช้งานขึ้นก่อนใช้งานอยู่ด้านหลัง</option>
						  </select>
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="#FFFFFF">&nbsp;</td>
                          <td align="left" bgcolor="#FFFFFF">
						  <input name="Submit" type="submit" value="Search"  >
						  &nbsp;
						  <script language="javascript">
						  function clear_data(){
						   frm.namesurname.value='';
						   frm.emp_type_id.value='';
						   frm.level_id.value='';
						   frm.name_org.value='';
						   frm.org_id.value='';
						  }
						  </script><input type="hidden" name="limit" value="20">
						  <input type="hidden" name="offset" value="0"> </td>
                        </tr>
                      </table></td>
                  </tr>
              </table></td>
    </tr>
  </table></form>
  <form name="form2" method="post" action="member_approve_function.php">
    <table width="94%" border="0" align="center" cellpadding="1" cellspacing="1" class="ewttableuse">
                    <tr class="ewttablehead">
                      <td width="10%" height="25" align="center" >&nbsp;</td>
                      <td >ชื่อ - สกุล </td>
                      <td align="center" >กลุ่มสมาชิก</td>
                      <td align="center" >วันที่สมัคร</td>
                      <td width="10%" align="center" >สถานะ</td>
                      <td width="5%" align="center" >อนุมัติ</td>
                    </tr>
					<?php
					if($namesurname){
					   $name=split(' ',$namesurname);
					   if($name[0]  &&  $name[1]=='' ){
					   $condition.="(gen_user.name_thai  like '$name[0]%'  OR  gen_user.surname_thai  like '$name[0]%' or gen_user.name_eng  like '$name[0]%'  OR  gen_user.surname_eng  like '$name[0]%')   AND "; 
					   }
					   if($name[0]    &&   $name[1]){
						 $condition.=" (gen_user.name_thai  like '$name[0]%'  OR  gen_user.surname_thai  like '$name[1]%' or gen_user.name_eng  like '$name[0]%'  OR  gen_user.surname_eng  like '$name[0]%')   and "; 
					   }
					   $db->query("USE ".$_SESSION["EWT_SDB"]);
					   $db->write_log("search","member","ค้นหาสมาชิกชื่อ : ".$namesurname);
					   $db->query("USE ".$EWT_DB_USER);
					}
					if($emp_type_id){
					  $condition.="( gen_user.emp_type_id like '$emp_type_id' )  and ";
					  $sql_chk = $db->db_fetch_array($db->query("select * from emp_type where emp_type_id ='".$_POST["emp_type_id"]."' "));
					  $db->query("USE ".$_SESSION["EWT_SDB"]);
					  $db->write_log("search","member","ค้นหากลุ่มสมาชิก  : ".$sql_chk[emp_type_name]);
					  $db->query("USE ".$EWT_DB_USER);
					}
					
					if($_REQUEST["sort_by"] != ""){
						if($_REQUEST["sort_by"] == "1"){
						$sort = 'create_date DESC,';
						}else if($_REQUEST["sort_by"] == "2"){
						$sort = 'status DESC,';
						}
					}
					
					  $sql="SELECT *  FROM `gen_user`
                              LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
                           where $condition gen_user.emp_type_id <> '1'  AND gen_user.web_use = '".$_SESSION["EWT_SUSER"]."' ";
						   $sql .= " order by $sort gen_user.name_thai ASC";
 					  $sql_member = $sql." LIMIT $offset,$limit ";
					$query = $db->query($sql_member);
					$num_rows = $db->db_num_rows($query);
					$rows = mysql_num_rows($db->query($sql));
					$i = 1;
					$y=0;
					if(!empty($num_rows)){
					while($rec = $db->db_fetch_array($query)){
					//print_r($rec);
						if($bg == "#FFFFFF"){
							$bg = "#FFF8EC";
						}else{
							$bg = "#FFFFFF";
						}
								$gen_user_id=$rec[gen_user_id];
							$title_thai=$rec[title_thai];
							$name_thai=$rec[name_thai];
							$surname_thai=$rec[surname_thai];
							$emp_type_name=$rec[emp_type_name];
							$name_org=$rec[name_org];
							$level_name=$rec[level_name];
						?>
						<tr bgcolor="<?php echo $bg?>" onMouseOver="this.style.backgroundColor='#FEFEEB';this.style.color='#FF6600'" onMouseOut="this.style.backgroundColor='<?php echo $bg?>';this.style.color='#000000'">
						  <td height="20" align="center" bgcolor="#FFFFFF" nowrap="nowrap"><nobr><!--<img src="../images/article_pencil.gif" width="14" height="14" alt="แก้ไขข้อมูลนี้" onMouseOver="this.style.cursor='hand';" onClick="self.location.href='frm_add_member.php?gen_user_id=<?php echo $rec[gen_user_id]?>&emp_id=<?php echo $rec[emp_id]?>&proc=edit';">-->  
						  <?php if($rec[status] != '1'){ ?> <a href="MemberList_outside.php?gen_user_id=<?php echo $rec[gen_user_id]?>&emp_id=<?php echo $rec[emp_id]?>&proc=approve">
						   <img src="../theme/main_theme/g_apply.gif" alt="คลิกเมื่อต้องการใช้งาน" width="16" height="16" border="0"></a><?php }else{ ?>
						   <a href="MemberList_outside.php?gen_user_id=<?php echo $rec[gen_user_id]?>&emp_id=<?php echo $rec[emp_id]?>&proc=approvecancle">
						   <img src="../theme/main_theme/g_applycancle.gif" alt="คลิกเมื่อไม่ต้องการไช้งาน" width="16" height="16" border="0"></a><?php } ?>
						   <a href="Member_outside_edit.php?gen_user_id=<?php echo $rec[gen_user_id]?>">
						  <img src="../theme/main_theme/g_edit.gif" alt="แก้ไขข้อมูล" width="16" height="16" border="0" ></a>
						   <a href="MemberList_outside.php?gen_user_id=<?php echo $rec[gen_user_id]?>&emp_id=<?php echo $rec[emp_id]?>&proc=delete">
						  <img src="../theme/main_theme/g_del.gif" alt="ลบข้อมูล" width="16" height="16" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');" onMouseOver="this.style.cursor='hand';" ></a>
						  </nobr></td>
						  <td bgcolor="#FFFFFF">&nbsp;<a href="#" onClick="window.open('view_profile_outside.php?emp_id=<?php echo $gen_user_id; ?>', 'select_org', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');"><?php echo $name_thai;?> <?php echo $surname_thai;?></a></td>
						  <td align="center" bgcolor="#FFFFFF">&nbsp;<?php echo $rec[emp_type_name];?></td>
						  <td align="center" bgcolor="#FFFFFF">&nbsp;<?php echo $rec[create_date];?></td>
						  <td align="center" bgcolor="#FFFFFF">&nbsp;<?php echo chk_status($rec[status]);?></td>
					      <td align="center" bgcolor="#FFFFFF"><?php if($rec[status] == '1'){ ?><img src="../images/check_24.gif" width="16" height="16"><?php }else{ ?>
				          <input type="checkbox" name="approve_all_<?php echo $rec[gen_user_id]; ?>" value="Y">
						  <input name="gen_user_id_app_<?php echo $y;?>" type="hidden" value="<?php echo $rec[gen_user_id];?>">
				          
				          <?php $y++; } ?></td>
						</tr>
							
						<?php
								$i++;
								
						}//end while
						if($y > 0){
						?>
						<tr bgcolor="#FFFFFF">
					  <td colspan="5" align="center">&nbsp;</td>
                      <td align="center"><input type="submit" name="Submit2" value="อนุมัติ"><input type="hidden" name="numrow" value="<?php echo $y;?>"></td>
					</tr>
						<?php
						}
					}else{
					?>
					<tr bgcolor="#FFFFFF">
						  <td colspan="6" align="center">ไม่พบข้อมูล</td>
    </tr>
		<?php
					}
					?>
				
					
				
</table>

  </form>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30">หน้าที่ 
        :</strong></font> 
              <?php
// Begin Prev/Next Links 
// Don't display PREV link if on first page 
if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href='$PHP_SELF?offset=$prevoffset&namesurname=$namesurname&emp_type_id=$emp_type_id&sort_by=".$_REQUEST["sort_by"]."'>
<font face=\"MS Sans Serif\" size=\"1\" color=\"red\"><< ก่อนหน้า</font></a>\n\n";
    }
    // Calculate total number of pages in result 
    $pages = intval($rows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($rows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=1;$i<=$pages;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo "<font face=\"MS Sans Serif\" size=\"1\" color=\"blue\">&nbsp;[$i]&nbsp;</font>\n\n"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  "<a href='$PHP_SELF?offset=$newoffset&namesurname=$namesurname&emp_type_id=$emp_type_id&sort_by=".$_REQUEST["sort_by"]."' ". 
                  " ><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">&nbsp;$i&nbsp;</font></a>\n\n"; 
        } 
    } 

    // Check to see if current page is last page 
   if (!((($offset/$limit)+1)==$pages) && $pages!=1 && $rows != 0) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   "<a href='$PHP_SELF?offset=$newoffset&namesurname=$namesurname&emp_type_id=$emp_type_id&sort_by=".$_REQUEST["sort_by"]."'>
		  <font face=\"MS Sans Serif\" size=\"1\" color=\"red\">ถัดไป>></font></a>"; 
    }
?></td>
  </tr>
</table>

</body>
</html>
<?php $db->db_close(); ?>
