<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}
		$_SESSION["EWT_OPEN_ARTICLE"] = "";
$db->write_log("view","article","เข้าสู่ Module Add Article");
if($_GET["p"] != ""){
$sql_article = $db->query("SELECT c_name FROM article_group WHERE c_id = '".$_GET["p"]."' ");
$P = $db->db_fetch_row($sql_article);
$txt = "ภายใต้ ".$P[0];
}

	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
//self.parent.document.all.backon.style.display = 'none';
//self.parent.document.all.backoff.style.display = '';
//self.parent.document.all.folderoff.style.display = 'none';
//self.parent.document.all.folderon.style.display = '';
//self.parent.document.all.deloff.style.display = 'none';
//self.parent.document.all.delon.style.display = '';
			 function Chk(c){
				if(document.form1.gname.value  == ""){
					alert("กรุณาใส่ชื่อกลุ่ม");
					document.form1.gname.focus();
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
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<?php 
$disabled1='style="display:none"';
$disabled2='style="display:none"';
if($db->check_permission('art','w','')){ $disabled1='';}
if($db->check_permission('art','a','')){ $disabled2=''; }
$db->query("USE ".$_SESSION["EWT_SDB"]);
?>

<span id="formtext"></span>

<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
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
	
	<a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ( "บริหารกลุ่มข่าว/บทความ".$txt);?>&module=article&url=<?php echo urlencode ( "article_gadd.php?p=".$_GET["p"]); ?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="article_group.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> 
      หน้าหลัก</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="article_new.php"><img src="../theme/main_theme/g_add_document.gif" border="0" width="16" height="16" align="absmiddle"> 
      เพิ่มข่าว/บทความ</a> 
      <hr>
    </td>
  </tr>
</table>
<table width="90%" border="0" align="center"  class="table table-bordered">
  <form name="form1" method="post" action="article_function.php" onSubmit="return Chk();"><tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead">เพิ่มกลุ่มข่าว/บทความ<?php echo $txt; ?>      </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="13%">ชื่อกลุ่มข่าว/บทความ</td>
    <td width="87%"><input name="gname" type="text" id="gname" size="40" class="form-control" style="width:40%;" >
      <br>
      <br>
      ตัวอย่างเช่น ข่าวประชาสัมพันธ์, ข่าวการเมือง, บทความเกี่ยวกับสุขภาพ เป็นต้น<br><br>
      <input type="radio" name="gtype"  value=" " checked >หมวดข่าวทั่วไป<br>
      <input type="radio" name="gtype" value="M" >ดึงข้อมูลจากหมวดอื่น</td>
  </tr>
   <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead">การแสดงผลในหน้าอ่านข่าวทั้งหมด</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="13%">การแสดงผล</td>
    <td width="87%">
	<input name="gshowsearch" type="checkbox"  id="gshowsearch"  value="Y" <?php if($G["c_show_search"]=='Y'){echo 'checked';} ?>>
        แสดง "ค้นหาข่าว"<br>
	<input name="gshowsub" type="checkbox" id="gshowsub"  value="Y" <?php if($G["c_show_sub"]=='Y'){echo 'checked';} ?>> แสดงหมวดย่อย<br>
	<input name="gshowsubnew" type="checkbox" id="gshowsubnew"   value="Y" <?php if($G["c_show_subnew"]=='Y'){echo 'checked';} ?>>
        แสดงข่าวภายใต้หมวดย่อย<br>
	<input name="gshowdetail" type="checkbox" id="gshowdetail"  value="Y" <?php if($G["c_show_detail"]=='Y'){echo 'checked';} ?>>
        แสดงรายละเอียดข่าว<input name="select_template" type="hidden" value="0"></td>
  </tr>
  <!--<tr valign="top" bgcolor="#FFFFFF">
    <td >Template</td>
    <td><select name="select_template"  >
	<option value=""></option>
                            <?php //save_design_function
					$sql_design = "SELECT d_id,d_name FROM design_list ORDER BY d_name ASC";
					$query = $db->query($sql_design);
					while($rec_design = $db->db_fetch_array($query)) {
						$select = '';
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
	<input name="gshowdate" checked="checked" type="radio" id="gshowdate"  value="C" <?php if($G["c_show_date"] == "C"){ echo "checked"; } ?>> แสดงต่อจากหัวข้อข่าว<br>
	<input name="gshowdate" type="radio" id="gshowdate"  value="N" <?php if($G["c_show_date"] == "N"){ echo "checked"; } ?>> แสดงบรรทัดถัดมา	</td>
  </tr>
  <?php
  //กำหนดเรื่องสิทธิ์<br>
$displ_user = 'none';
$displ_org = 'none';
$displ_group = 'none';
$displ_group_personal = 'none';

  ?>
  <tr valign="top" bgcolor="#FFFFFF">
    <td>กำหนดสิทธิ์การมองเห็น</td>
    <td width="87%"><table width="100%" border="0">
      <tr style="display:<?php echo $displ_user;?>" id="tr_user">
        <td width="11%" height="22">รายบุคคล : 
          <input type="hidden" name="hdd_uid" </td>
        <td width="89%" height="22"><span id="txtshow"><?php echo $G[c_name]; ?></span></td>
      </tr>
      <tr  style="display:<?php echo $displ_org;?>" id="tr_org">
        <td width="11%" height="22">รายหน่วยงาน : 
          <input type="hidden" name="hdd_uorg" ></td>
        <td height="22"><span id="txtshowuorg"><?php echo $G[c_name]; ?></span></td>
      </tr>
      <tr style="display:<?php echo $displ_group;?>"  id="tr_group">
        <td width="11%" height="22">รายกลุ่มสิทธิ์ : 
          <input type="hidden" name="hdd_ugroup" ></td>
        <td height="22"><span id="txtshowugroup"><?php echo $G[c_name]; ?></span></td>
      </tr style="display:none">
      <tr  style="display:<?php echo $displ_group_personal;?>"  id="tr_group_personal">
        <td width="11%" height="22">รายกลุ่มบุคคล : 
          <input type="hidden" name="hdd_ugroup_personal" ></td>
        <td height="22"><span id="txtshowugroup_personal"><?php echo $G[c_name]; ?></span></td>
      </tr>
      <tr>
        <td width="11%"><a href="#G" onClick="window.open('member_list_main.php','','width=900 , height=650, scrollbars=1,resizable = 1');"><img src="../images/bar_user.gif" border="0" alt="กำหนดสิทธิ์" width="20" height="20"></a></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td>&nbsp;</td>
    <td> <input type="submit" name="Submit2" value="เพิ่ม" class="btn btn-success"><input name="Flag" type="hidden" id="Flag" value="CreateFolder"> <input name="p" type="hidden" id="p" value="<?php echo $_GET["p"]; ?>">     </td>
  </tr>
  </form>
</table>
<br>

</body>
</html>
<?php $db->db_close(); ?>
