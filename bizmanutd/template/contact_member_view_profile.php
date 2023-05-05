<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];
?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chang_detail(t){
	if(t=='1'){
	document.getElementById('oth').style.display = 'none';
	window.open('contact_main.php','sel', 'height=375,width=445, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
	}else if(t=='2'){
	document.getElementById('oth').style.display = '';
	}
}
function link_sele(t){
//self.parent.location.href="contact_function.php?flag=add_member_unit&groupid="+self.parent.document.getElementById('group_name').value+"&gid="+t;
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.head_table {	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<form  name="frm" method="post" action="">
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="50%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="22"><img src="mainpic/border_24.jpg" width="12" height="32" /></td>
        <td align="center" background="mainpic/border_25.jpg" class="ewtfunction style1">ข้อมูลเจ้าหน้าที่</td>
        <td width="12"><img src="mainpic/border_28.jpg" width="12" height="32" /></td>
      </tr>
    </table></td>
  </tr>
</table>

  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center"><table width="96%" border="0" cellpadding="3" cellspacing="1">
          <tr>
            <?php
			$selete_user="SELECT  * ,  `gen_user`.`title_thai` As `title_thai_gen`, `gen_user`.`title_eng` As `title_eng_gen`,`title`.`title_thai` As  `title_name_thai`,`title`.`title_eng` As  `title_name_eng`
                          FROM
  `gen_user`
  LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
  LEFT OUTER JOIN `title` ON (`gen_user`.`title_thai` = `title`.`title_id`)
  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) 
  LEFT OUTER JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  Where  gen_user.gen_user_id='$gid'  ";
			$exec_user=$db->query($selete_user);
			$rst_user = $db->db_fetch_array($exec_user);

			if($rst_user[path_image]){
			   $path_image="../pic_upload/".$rst_user[path_image];
			}else{
			   $path_image="images/ImageFile.gif";
			}
		?>
            <td width="298" height="20" align="right" bgcolor="#FFFFFF">&nbsp;&nbsp;ชื่อ-นามสกุล :</td>
            <td width="332" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[title_thai]." ".$rst_user[name_thai]."&nbsp;&nbsp;".$rst_user[surname_thai]; ?></td>
            <td width="244" rowspan="3" align="center" bgcolor="#FFFFFF"><img src="img.php?p=<?php echo base64_encode($path_image); ?>" width="98" height="98" /></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp; Name-Surname :</td>
            <td bgcolor="#FFFFFF">&nbsp;<?php if($rst_user[name_eng] != ''){ echo $rst_user[title_eng]." ".$rst_user[name_eng]."&nbsp;&nbsp;".$rst_user[surname_eng];} ?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;ตำแหน่งทางวิชาการ :</td>
            <td bgcolor="#FFFFFF">&nbsp;
                <?php echo $rst_user[position_person]; ?></td>
          </tr>
          <tr>
            <td height="9" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;หน่วยงาน :</td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[name_org];?></td>
          </tr>
          <tr>
            <td height="10" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">ตำแหน่งภายในหน่วยงาน : </td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php if($rst_user[pos_name] != ''){echo $rst_user[pos_name];}else{ echo '-';}?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;Email  : </td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[email_person];?></td>
          </tr>


          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;เบอร์ต่อสะดวก :</td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[tel_in];?></td>
          </tr>

          <tr>
            <td height="9" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;สถานที่ทำงาน :</td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[officeaddress];?></td>
          </tr>
          <tr>
            <td height="10" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">กลุ่ม : </td>
            <td colspan="2" bgcolor="#FFFFFF"> <?php
							$sql = "select * from contact_group where user_id = '$user_id'";
							$query = $db->query($sql);
							$num = mysql_num_rows($query);
							if($num > 0){
					?>
					  <select name="group_name" id="group_name">
					    <option value="">---ไม่เข้ากลุ่ม---</option>
					    <?php
							
							while($R = $db->db_fetch_array($query)){
							echo "<option value=\"".$R[contact_group_id]."\">".$R[contact_group_name]."</option>";
							}
							
						?>
					    </select>
						<?php }else{ echo "-";}?></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <div align="center"><br />
    <br />
    <input name="Submit" type="Button" class="submit"  style="width:100" onClick="gotoadd(<?php echo $gid; ?>);" value="เพิ่มรายชื่อ" />
    &nbsp;
    <input name="Submit2" type="button" class="submit"  style="width:100" onClick="back_go();" value="กลับ" />
</div>
</form>
</body>
</html>
<script language="javascript">
function back_go(){
history.back();
}
function gotoadd(t){
self.parent.location.href="contact_function.php?flag=add_member_unit&groupid="+self.parent.document.getElementById('group_name').value+"&gid="+t;
}
</script>
<?php  $db->db_close(); ?>
