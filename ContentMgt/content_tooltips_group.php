<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("cms","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.close();
				</script>
				<?php
}
if($_GET[flag]=='edit_group'){
$sql = "select * from tips_group  where tips_group_id = '".$_GET[tips_id]."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
}
	?>

<table width="100%" height="300" border="0" cellpadding="3" cellspacing="2">
  <tr>
    <td valign="top" bgcolor="#FFFFFF">	  <form name="form1" method="post" action="content_tooltips_function.php">
      <table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
        <tr bgcolor="#E7E7E7" >
          <td height="30" colspan="2" class="ewttablehead"> กลุ่ม Tool Tips </td>
        </tr>
        <tr valign="top" bgcolor="#FFFFFF">
          <td width="38%">ชื่อกลุ่ม</td>
          <td width="62%"><input name="title" type="text" size="40" value="<?php echo $R[tips_group_name];?>"></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td>&nbsp;</td>
          <td><input type="submit" name="Submit" value="Submit">
		  <input type="button" name="Button" value="ยกเลิก" onClick="document.getElementById('nav').style.display='none';">
		   <input type="hidden" name="type" value="<?php echo $_GET[type];?>">
		  <input type="hidden" name="filename" value="<?php echo $_GET[filename];?>">
		   <input type="hidden" name="tips_id" id="tips_id" value="<?php echo $_GET[tips_id];?>">
		  <input type="hidden" name="flag" value="<?php echo $_GET[flag];?>">
		  <input type="hidden" name="type_name" value="<?php echo $_GET[flag];?>"></td>
        </tr>
      </table>
      
    </form></td>
  </tr>
</table>

<?php $db->db_close(); ?>
