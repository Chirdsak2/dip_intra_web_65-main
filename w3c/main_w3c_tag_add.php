<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
  $db->query("USE ".$EWT_DB_W3C);
  if($_POST[flag]=='add'){
  						$sql_chk = " SELECT  tag_name  FROM  tag_info  WHERE tag_name = '".$_POST["tag_name"]."' ";
						$exec_chk = $db->query($sql_chk);
						$num_chk = $db->db_num_rows($exec_chk);
						if($num_chk > 0){
								?>
								<script type="text/javascript">
									alert('Tag นี้มีในฐานข้อมูลอยู่แล้ว');					
									self.location.href = 'main_w3c_tag_list.php';
								</script>
								<?php
								exit;
						}
					$INSERT = $db->query(" INSERT INTO tag_info (tag_name, section_id, need_status, need_close, tag_grand, tag_parent, tag_parent2, tag_parent3, w3c_notallow  ) 
												VALUES ('".$_POST["tag_name"]."', '".$_POST["section_id"]."','".$_POST["need_status"]."','".$_POST["need_close"]."' ,'".$_POST["tag_grand"]."' ,'".$_POST["tag_parent"]."','".$_POST["tag_parent2"]."','".$_POST["tag_parent3"]."' ,'".$_POST["w3c_notallow"]."'  )");
												?>
								<script type="text/javascript">
									alert('บันทึกข้อมูลเรียบร้อยแล้ว');					
									self.location.href = 'main_w3c_tag_list.php';
								</script>
								<?php
								exit;
  }
    if($_POST[flag]=='edit'){
		$UPDATE = $db->query(" UPDATE tag_info  SET  tag_name = '".$_POST["tag_name"]."',  section_id = '".$_POST["section_id"]."', need_status = '".$_POST["need_status"]."', need_close = '".$_POST["need_close"]."', tag_grand = '".$_POST["tag_grand"]."', tag_parent = '".$_POST["tag_parent"]."', tag_parent2 = '".$_POST["tag_parent2"]."', tag_parent3 = '".$_POST["tag_parent3"]."', w3c_notallow = '".$_POST["w3c_notallow"]."'  WHERE  tag_id = '".$_POST["tag_id"]."' ");
			?>
								<script type="text/javascript">
									alert('บันทึกข้อมูลเรียบร้อยแล้ว');					
									self.location.href = 'main_w3c_tag_list.php';
								</script>
								<?php
								exit;
	}
  
  
  
  //
  if($_GET[flag]=='edit'){
  $flag = 'edit';
 					 $sql_tag = " SELECT *  FROM tag_info  WHERE tag_id = '".$_GET[tag_id]."' ";
					  $exec_tag = $db->query($sql_tag);
					  $rec_tag = $db->db_fetch_array($exec_tag);
  }else{
  $flag = 'add';
  }
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chkInput() {
		if(frm.tag_name.value=='') {
			alert('กรุณากรอก Tag Name');
			frm.tag_name.focus();
			return false;
		} 
		if(frm.section_id.value=='') {
			alert('กรุณาเลือก Tag Section');
			frm.section_id.focus();
			return false;
		}
		if(frm.tag_grand.value=='') {
			alert('กรุณาเลือก Tag แม่');
			frm.tag_grand.focus();
			return false;
		} 
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการ Tag </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="main_w3c_tag_list.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0" align="absmiddle"> 
      การจัดการ Tag </a>&nbsp;&nbsp;&nbsp;
    <hr> </td>
  </tr>
</table>
<form name="frm" method="post" action="main_w3c_tag_add.php" onSubmit="return chkInput();" >
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
    <tr bgcolor="#E7E7E7" >
      <td height="30" colspan="2" class="ewttablehead">เพิ่ม Tag </td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td width="38%">Tag Name</td>
      <td width="62%"><input name="tag_name" type="text" id="tag_name" value="<?php echo $rec_tag[tag_name];?>" size="40"></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Tag Section</td>
      <td><select name="section_id" id="section_id">
          <option value="">========</option>
          <?php
			$sql_options = "SELECT  section_id, section_name FROM  tag_section  ORDER BY  section_id  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?>
        <option value="<?php echo $rec_options[section_id];?>" <?php if($rec_options[section_id]==$rec_tag[section_id]) echo "selected"; ?>>
          <?php echo $rec_options[section_name];?>
          </option>
        <?php
			}
			?>
      </select></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>ต้องมี Tag นี้</td>
      <td><input name="need_status" type="checkbox" id="need_status" value="1" <?php if($rec_tag[need_status]) echo "checked"; ?>></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>ต้องมี Tag ปิด</td>
      <td><input name="need_close" type="checkbox" id="need_close" value="1" <?php if($rec_tag[need_close]) echo "checked"; ?>></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Tag แม่</td>
      <td><select name="tag_grand" id="tag_grand">
          <option value="">========</option>
          <?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?>
        <option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_tag[tag_grand]) echo "selected"; ?>>
          <?php echo $rec_options[tag_name];?>
          </option>
        <?php
			}
			?>
      </select></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Tag นำหน้า 1</td>
      <td><select name="tag_parent" id="tag_parent">
          <option value="">========</option>
          <?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?>
        <option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_tag[tag_parent]) echo "selected"; ?>>
          <?php echo $rec_options[tag_name];?>
          </option>
        <?php
			}
			?>
      </select></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Tag นำหน้า 2 </td>
      <td><select name="tag_parent2" id="tag_parent2">
          <option value="">========</option>
          <?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?>
        <option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_tag[tag_parent2]) echo "selected"; ?>>
          <?php echo $rec_options[tag_name];?>
          </option>
        <?php
			}
			?>
      </select></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>Tag นำหน้า 3 </td>
      <td><select name="tag_parent3" id="tag_parent3">
          <option value="">========</option>
          <?php
			$sql_options = "SELECT DISTINCT tag_name AS tag_name FROM tag_info  ORDER BY  tag_name  ";
			$exec_options = $db->query($sql_options);
			while($rec_options= $db->db_fetch_array($exec_options)) {
				 ?>
        <option value="<?php echo $rec_options[tag_name];?>" <?php if($rec_options[tag_name]==$rec_tag[tag_parent3]) echo "selected"; ?>>
          <?php echo $rec_options[tag_name];?>
          </option>
        <?php
			}
			?>
      </select></td>
    </tr>
    <tr valign="top" bgcolor="#FFFFFF">
      <td>W3C ไม่อนุญาต </td>
      <td><input name="w3c_notallow" type="checkbox" id="w3c_notallow" value="N" <?php if($rec_tag[w3c_notallow]) echo "checked"; ?>></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit2" value="Submit">
          <input type="reset" name="Submit3" value="Reset">
      <input type="hidden" name="flag" value="<?php echo $flag;?>">
	  <input name="tag_id" type="hidden" value="<?php echo $_GET[tag_id];?>" ></td>
    </tr>
  </table>
</form>
<?php $db->query("USE ".$EWT_DB_NAME);?>
</body>
</html>
<?php
$db->db_close(); ?>