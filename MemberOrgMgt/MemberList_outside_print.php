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



	?>
<html>
<head>
<title>Member Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" <?php if($_GET[flag_print]=='print'){ echo "onLoad=\"this.print();this.close();\" "; } ?>>
<?php if($_GET[flag_print]!='print'){ ?>
<?php include("../FavoritesMgt/favorites_include.php");?>
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ข้อมูล<A href="MemberList_outside.php" target="member_body">สมาชิก</A> </span> </td>
    </tr>
  </table>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("พิมพ์ข้อมูลสมาชิก");?>&module=member&url=<?php echo urlencode("MemberList_outside_print.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="MemberList_outside.php"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> 
      กลับ</a><hr>
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
						  </script><!--<input type="hidden" name="limit" value="20">--><input type="hidden" name="flag" value="search">
						  <input type="hidden" name="offset" value="0"> </td>
                        </tr>
                      </table></td>
                  </tr>
              </table></td>
    </tr>
  </table></form>
  <?php
  }
  if($_POST[flag]=='search'){
  ?>
  <table width="94%" border="0" align="center" cellpadding="1" cellspacing="1" class="ewttableuse">
                    <tr class="ewttablehead">
                      <td width="10%" height="25" align="center" >ลำดับการสมัคร</td>
                      <td width="25%" align="center" >ชื่อ - สกุล </td>
                      <td width="10%" align="center" >E-mail</td>
                      <td width="10%" align="center" >เบอร์โทรศัพท์</td>
                      <td width="25%" align="center" >สถานที่ทำงาน</td>
                      <td width="10%" align="center" >กลุ่มสมาชิก</td>
                      <td width="10%" align="center" >วันที่สมัคร</td>
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
					
					
					
					  $sql="SELECT *  FROM `gen_user`
                              LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
                           where $condition gen_user.emp_type_id <> '1'  AND gen_user.web_use = '".$_SESSION["EWT_SUSER"]."'  order by gen_user.name_thai ";
					$sql_member = $sql;//." LIMIT $offset,$limit ";
					$query = $db->query($sql_member);
					$num_rows = $db->db_num_rows($query);
					$rows = mysql_num_rows($db->query($sql));
					$i = 1;
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
							
							//ลำดับการสมัคร
							$sql_regis = "select * from history where gen_user_id ='".$gen_user_id."' and status ='add'";
							$query_regis = $db->query($sql_regis);
							$rec_regis = $db->db_fetch_array($query_regis);
						?>
						<tr bgcolor="<?php echo $bg?>" onMouseOver="this.style.backgroundColor='#FEFEEB';this.style.color='#FF6600'" onMouseOut="this.style.backgroundColor='<?php echo $bg?>';this.style.color='#000000'">
						  <td height="20" align="center" bgcolor="#FFFFFF" nowrap="nowrap"><?php echo $rec_regis[his_id];?></td>
						  <td bgcolor="#FFFFFF">&nbsp;<?php echo $name_thai;?> <?php echo $surname_thai;?></td>
						  <td bgcolor="#FFFFFF"><?php echo $rec[email_person];?></td>
						  <td bgcolor="#FFFFFF"><?php echo $rec[tel_in];?></td>
						  <td bgcolor="#FFFFFF"><?php echo $rec[officeaddress];?></td>
						  <td align="center" bgcolor="#FFFFFF">&nbsp;<?php echo $rec[emp_type_name];?></td>
						  <td align="center" bgcolor="#FFFFFF">&nbsp;<?php echo $rec[create_date];?></td>
					    </tr>
						<?php
								$i++;
								
						}//end while
					}else{
					?>
					<tr bgcolor="#FFFFFF">
						  <td colspan="7" align="center">ไม่พบข้อมูล</td>
    </tr>
					
					
					<?php
					}
					?>

</table><?php if($_GET[flag_print]!='print'){ ?>
<table width="100%" border="0">
					<tr bgcolor="#FFFFFF">
					  <td height="44" colspan="7" align="center" valign="bottom"><input type="button" name="Submit2" value="พิมพ์รายชื่อสมาชิก" onClick="open_page();"></td>
    </tr>
</table><?php }?>
<form name="form2" method="post" action="">
  <input type="hidden" name="namesurname">
  <input type="hidden" name="emp_type_id">
  <input type="hidden" name="flag">
  <input type="hidden" name="offset">
</form>
<script language="javascript1.2">
function open_page(){
		var link_t = 'MemberList_outside_print.php?flag_print=print';
		var link_target = '_blank';
		form2.action = link_t;
		form2.namesurname.value =form1.namesurname.value
		form2.emp_type_id.value =form1.emp_type_id.value
		form2.flag.value =form1.flag.value
		form2.offset.value =form1.offset.value
		form2.target =link_target;
		form2.submit();
}
</script>

<?php } ?>
</body>
</html>
<?php $db->db_close(); ?>
