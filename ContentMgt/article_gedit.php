<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$ptype = "Ag";
$ppms1 = "w";
		
$sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$_GET["cid"]."'");
$G = $db->db_fetch_array($sql_group);
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
 function Chk(c){
				if(document.form1.c_name.value  == ""){
					alert("กรุณาใส่ชื่อกลุ่ม");
					document.form1.c_name.focus();
					return false;
				}
			}
									function choose_pic(c,d){
	formPopUpBg.action = "../FileMgt/gallery_insert.php";
	window.open('','bg_popup','top=60,left=80,width=780,height=480,resizable=1,status=0');
		document.formPopUpBg.o_value.value = c;
		document.formPopUpBg.o_preview.value = d;
		document.formPopUpBg.Flag.value = "SetPic";
		formPopUpBg.submit();
		}
</script>
<style type="text/css">
<!--
body,td,th {
	font-size: 11px;
}
-->
</style></head>
<body leftmargin="0" topmargin="0" bgcolor="#FFFFFF">
<?php include("../FavoritesMgt/favorites_include.php");?>
		<table width="90%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหารกลุ่มข่าว/บทความ</span> </td>
  </tr>
</table>
  <form name="formPopUpBg" method="post" action="" target="bg_popup">
		<input name="o_value" type="hidden" id="o_value" value="">
        <input name="o_preview" type="hidden" id="o_preview" value="">
		<input name="stype" type="hidden" id="stype" value="images">
		<input name="Flag" type="hidden" id="Flag" value="">
</form>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	
		<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( "แก้ไขกลุ่มข่าว/บทความ : ".$G["c_name"]);?>&module=article&url=<?php echo urlencode ( "article_gedit.php?cid=".$_GET["cid"]); ?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	
	<a href="article_group.php"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
      บริหารกลุ่มข่าว/บทความ</a>
	  <?php if($G["c_type"]!='M'){?>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_new.php?cid=<?php echo $_GET["cid"]; ?>"><img src="../theme/main_theme/g_add.gif"  border="0" width="16" height="16" align="absmiddle"> 
      เพิ่มข่าว/บทความ</a>
	  <?php }?>
      <hr>
    </td>
  </tr>
</table>
<table width="90%" border="0" align="center" class="table table-bordered">
  <form name="form1" method="post" action="article_function.php" onSubmit="return Chk();"><tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead">แก้ไขกลุ่มข่าว/บทความ      </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อกลุ่มข่าว/บทความ</td>
    <td width="62%"><input name="c_name" type="text" id="c_name"  value="<?php echo $G["c_name"]; ?>" size="50"  class="form-control" style="width:40%;" >
        <input name="cid" type="hidden" id="cid" value="<?php echo $_GET["cid"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="EditGroup">
		<input name="gtype" type="hidden" id="gtype" value="<?php echo $G["c_type"]; ?>">
		<?php if($G["c_type"]=='M'){?>
		<a href="#browse" title="เลือกกลุ่ม" onClick="win2 = window.open('article_gselect.php?cid=<?php echo $_GET["cid"]; ?>&popup=Y','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" > แก้ไขกลุ่ม Multi</a>
		<?php }?></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
      <td>อยู่ภายใต้หมวด</td>
      <td>
	  <?php
	    $sql_group = $db->query("SELECT * FROM article_group WHERE c_id = '".$G["c_parent"]."'");
        $GS = $db->db_fetch_array($sql_group);
		if($G["c_parent"]==0){
		    $gname="กลุ่มข่าว/บทความ";
		}else{
		    $gname=$GS[c_name];
		}
	  ?>
	  <input type="hidden" name="c_parent" value="<?php echo $G["c_parent"];?>"><span id="gname"><?php echo $gname;?></span> <a href="#browse" title="เลือกกลุ่ม" onClick="win2 = window.open('article_select_edit.php?cid=<?php echo $_GET["cid"]; ?>','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0,scrollbars=1');win2.focus();"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle" ></a>	  </td>
  </tr>
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead">การแสดงผลในหน้าเว็บ</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="13%">การแสดงผล</td>
    <td width="87%">
	<input name="gshowsearch" type="checkbox" id="gshowsearch"  value="Y" <?php if($G["c_show_search"]=='Y'){echo 'checked';} ?>>แสดง "ค้นหาข่าว"<br>
	<input name="gshowsub" type="checkbox" id="gshowsub"  value="Y" <?php if($G["c_show_sub"]=='Y'){echo 'checked';} ?>> แสดงหมวดย่อย<br>
	<input name="gshowsubnew" type="checkbox" id="gshowsubnew"   value="Y" <?php if($G["c_show_subnew"]=='Y'){echo 'checked';} ?>> แสดงข่าวภายใต้หมวดย่อย<br>
	<input name="gshowdetail" type="checkbox" id="gshowdetail"  value="Y" <?php if($G["c_show_detail"]=='Y'){echo 'checked';} ?>>
        แสดงรายละเอียดข่าว</td>
  </tr>
  <!-- <tr valign="top" bgcolor="#FFFFFF">
    <td height="35" >Template</td>
    <td><select name="select_template"  >
	<option value=""></option>
                            <?php //save_design_function
					$sql_design = "SELECT d_id,d_name FROM design_list ORDER BY d_name ASC";
					$query = $db->query($sql_design);
					while($rec_design = $db->db_fetch_array($query)) {
						$select = '';
						if($rec_design[d_id] == $G[d_id]) {
							$select = 'selected';
						}
						echo " <option value=\"".$rec_design[d_id]."\"".$select.">".$rec_design[d_name]."</option>";
					}
				?>
                          </select> <input type="button" name="Submit2" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id='+ document.form1.select_template.value +'','','height=600,width=780,scrollbars=1,resizable=1');"></td>
  </tr>
   <tr valign="top" bgcolor="#FFFFFF">
     <td >W3c Template</td>
     <td><select name="select_template_w3c"  >
	<option value=""></option>
                            <?php //save_design_function
					$sql_design = "SELECT d_id,d_name FROM design_list ORDER BY d_name ASC";
					$query = $db->query($sql_design);
					while($rec_design = $db->db_fetch_array($query)) {
						$select = '';
						if($rec_design[d_id] == $G[d_id_w3c]) {
							$select = 'selected';
						}
						echo " <option value=\"".$rec_design[d_id]."\"".$select.">".$rec_design[d_name]."</option>";
					}
				?>
                          </select> <input type="button" name="Submit2" value="Preview" onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/template_preview.php?d_id='+ document.form1.select_template_w3c.value +'','','height=600,width=780,scrollbars=1,resizable=1');"></td>
   </tr>-->
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="13%">การแสดงภาพประกอบข่าว<br></td>
    <td width="87%">
		<input type="radio" name="gshowpic" value="" <?php if($G["c_show_pic"] == ""){ echo "checked"; } ?>>
              ไม่ใช้รูปภาพ<br> <input type="radio" name="gshowpic" value="@detail_news#"  <?php if($G["c_show_pic"] == "@detail_news#"){ echo "checked"; } ?>>
              แสดงรูปประกอบของข่าว<br> <input type="radio" name="gshowpic" value="<?php if($G["c_show_pic"] != "@detail_news#"){ echo $G["c_show_pic"]; } ?>"  <?php if($G["c_show_pic"] != "@detail_news#" AND $G["c_show_pic"] != ""){ echo "checked"; } ?> > 
              <a href="#pop" onClick="choose_pic('window.opener.document.form1.gshowpic[2].value','window.opener.document.all.imgpreview');document.form1.gshowpic[2].checked=true;"><img src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"> 
              เลือกจากไฟล์ : 
              <img src="<?php if($G["c_show_pic"] != "@detail_news#" AND $G["c_show_pic"] != ""){ echo "../ewt/".$_SESSION["EWT_SUSER"]."/".$G["c_show_pic"]; }else{ echo "../images/o.gif"; } ?>" name="imgpreview" width="16" height="16" border="0" align="absmiddle" id="imgpreview"> <?php if($G["c_show_pic"] != "@detail_news#"){ echo $G["c_show_pic"]; } ?>
              </a>      </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="13%">การแสดงวันที่ข่าว</td>
    <td width="87%">
	<input name="gshowdate" type="radio" id="gshowdate"  value="" <?php if($G["c_show_date"] == ""){ echo "checked"; } ?>> ไม่แสดง<br>
	<input name="gshowdate" type="radio" id="gshowdate"  value="C" <?php if($G["c_show_date"] == "C"){ echo "checked"; } ?>> แสดงต่อจากหัวข้อข่าว<br>
	<input name="gshowdate" type="radio" id="gshowdate"  value="N" <?php if($G["c_show_date"] == "N"){ echo "checked"; } ?>> แสดงบรรทัดถัดมา	</td>
  </tr>
  <?php
  //กำหนดเรื่องสิทธิ์<br>
$uid = array();
$uname = array();
$orgid = array();
$orgname = array();
$typeid = array();
$typename = array();
$gruopid = array();
$gruopname = array();
$displ_user = 'none';
$displ_org = 'none';
$displ_group = 'none';
$displ_group_personal = 'none';
  $sql_permission = "select * from article_group_permission where c_id = '".$_GET["cid"]."' ";
  $query_permission = $db->query($sql_permission);
  while($rec_permission = $db->db_fetch_array($query_permission)){
  if($rec_permission[gen_user_id] != ''){array_push($uid,$rec_permission[gen_user_id]); $displ_user = '';  }
  if($rec_permission[org_id] != ''){array_push($orgid,$rec_permission[org_id]);$displ_org = '';}
  if($rec_permission[ug_id] != ''){array_push($gruopid,$rec_permission[ug_id]);$displ_group = '';}
  if($rec_permission[emp_type_id] != ''){array_push($typeid,$rec_permission[emp_type_id]);$displ_group_personal = '';}
  }
    $db->query("USE ".$EWT_DB_USER);
	if( $displ_user  == ''){
		$sql = 'select * from gen_user where gen_user_id IN ('.implode ( ',',$uid).') ';
		  $query = $db->query($sql);
		 while($rec = $db->db_fetch_array($query)){
			array_push($uname,$rec[name_thai].'  '.$rec[surname_thai]); 
		}
	}
	if( $displ_org  == ''){
		$sql = 'select * from org_name where org_id IN ('.implode ( ',',$orgid).') ';
		  $query = $db->query($sql);
		 while($rec = $db->db_fetch_array($query)){
			array_push($orgname,$rec[name_org]); 
		}
	}
	if( $displ_group  == ''){
		$sql = 'select * from user_group where ug_id IN ('.implode ( ',',$gruopid).') ';
		  $query = $db->query($sql);
		 while($rec = $db->db_fetch_array($query)){
			array_push($gruopname,$rec[ug_name]); 
		}
	}
	if( $displ_group_personal  == ''){
		$sql = 'select * from emp_type where emp_type_id IN ('.implode ( ',',$typeid).') ';
		  $query = $db->query($sql);
		 while($rec = $db->db_fetch_array($query)){
			array_push($typename,$rec[emp_type_name]); 
		}
	}
  	$db->query("use  ".$EWT_DB_NAME);
  ?>
  <tr valign="top" bgcolor="#FFFFFF">
    <td>กำหนดสิทธิ์การมองเห็น</td>
    <td width="87%"><table width="100%" border="0">
      <tr style="display:<?php echo $displ_user;?>" id="tr_user">
        <td width="19%" height="22">รายบุคคล : 
          <input type="hidden" name="hdd_uid" value="<?php echo implode ( ',',$uid);?>"></td>
        <td width="81%" height="22"><span id="txtshow"><?php echo implode ( ',',$uname);?></span></td>
      </tr>
      <tr style="display:<?php echo $displ_org;?>"  id="tr_org">
        <td width="19%" height="22">รายหน่วยงาน : 
          <input type="hidden" name="hdd_uorg" value="<?php echo implode ( ',',$orgid);?>"></td>
        <td height="22"><span id="txtshowuorg"><?php echo implode ( ',',$orgname);?></span></td>
      </tr>
      <tr style="display:<?php echo $displ_group;?>"  id="tr_group">
        <td width="19%" height="22">รายกลุ่มสิทธิ์ : 
          <input type="hidden" name="hdd_ugroup" value="<?php echo implode ( ',',$gruopid);?>"></td>
        <td height="22"><span id="txtshowugroup"><?php echo implode ( ',',$gruopname);?></span></td>
      </tr style="display:none">
      <tr  style="display:<?php echo $displ_group_personal;?>"  id="tr_group_personal">
        <td width="19%" height="22">รายกลุ่มบุคคล : 
          <input type="hidden" name="hdd_ugroup_personal" value="<?php echo implode ( ',',$typeid);?>"></td>
        <td height="22"><span id="txtshowugroup_personal"><?php echo implode ( ',',$typename);?></span></td>
      </tr>
      <tr>
        <td width="19%"><a href="#G" onClick="window.open('member_list_main.php','','width=900 , height=650, scrollbars=1,resizable = 1');"><img src="../images/bar_user.gif" border="0" alt="กำหนดสิทธิ์" width="20" height="20"></a></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td>ลำดับข่าว</td>
	<td><input class="form-control" style="width:10%;" type="text" name="c_order" size="4" value="<?php echo $G["d_id"] ?>"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td>&nbsp;</td>
    <td> <input type="submit" name="Submit2" value="บันทึก" class="btn btn-success" >      </td>
  </tr></form>
</table>
<br>
<br>
</body>
</html>
<?php $db->db_close(); ?>
