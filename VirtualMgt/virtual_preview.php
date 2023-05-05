<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language.php");
$sql = $db->query("SELECT v_images,v_width,v_height,v_name FROM virtual_list WHERE v_id = '".$_GET["vid"]."' ");
$R = $db->db_fetch_row($sql);
$g_name = $R[3];
					if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$R[0])) {
						$img = "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/".$R[0];
					}else{
						$img = "../ewt/".$_SESSION["EWT_SUSER"]."/virtual/p_".$R[0];
					}
?>

<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
#Layer1 {
	position:absolute;left:67px;top:22px;width:174px;height:121px;z-index:1;background-color: #666666;border:#FFFFFF solid 2px;filter: alpha(opacity=20);
}
.style5 {font-size: 12px}
-->
</style>
<script type="text/javascript">
function Del(c){
	if(confirm("Are you sure to delete data?")){
		document.form1.SID.value = c;
		form1.submit();
	}
}
</script>
</head>

<body topmargin="0" leftmargin="0">
<div id="testWrap"  style="HEIGHT: <?php echo $R[2]; ?>;OVERFLOW-X: scroll;WIDTH: 100%;margin-right:scroll; margin-left:scroll;position:relative;"><?php
$sql_spot = $db->query("SELECT * FROM virtual_spot WHERE v_id = '".$_GET["vid"]."'");
$i=1;
while($S = $db->db_fetch_array($sql_spot)){
$width = $S[s_x2] - $S[s_x1];
$height = $S[s_y2] - $S[s_y1];
?>
<div id="Layer<?php echo $i; ?>" style="position:absolute;left:<?php echo $S[s_x1]; ?>px;top:<?php echo $S[s_y1]; ?>px;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;z-index:1;background-color: #666666;border:#FFFFFF solid 2px;filter: alpha(opacity=30); cursor:pointer" onMouseOver="this.style.backgroundColor='#FF6600';" onMouseOut="this.style.backgroundColor='#666666';"  onClick="window.open('virtual_spot.php?vid=<?php echo $_GET["vid"]; ?>&sid=<?php echo $S["s_id"]; ?>','','width=800,height=600,scrollbars=1,resizable=1');"><font style="background-color:#333333;color:#FFFFFF; font-family:Tahoma; font-size:14px; font-weight:bold"><?php echo $S["s_name"]; ?></font></div>
<?php $i++; } ?>

<img src="<?php echo $img; ?>">
</div>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><span class="ewthead style5">* หมายเหตุ ในกรณีที่ท่านต้องการทำจุด Hot-sport ท่านสามารถทำได้โดยการ ลากเมาส์ให้ครอบคลุมตรงบริเวณที่ท่านต้องการ</span></td>
  </tr>
</table>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/virtual_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ข้อมูล Virtual  Tour >> <?php echo $g_name;?></span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><form name="form1" method="post" action="virtual_function.php">
      <input type="hidden" name="SID"><input type="hidden" name="Flag" value="Sdel"><input type="hidden" name="vid" value="<?php echo $_GET["vid"]; ?>">
	  <input type="hidden" name="vg_id" value="<?php echo $_GET["vg_id"]; ?>">
    </form>
      <a href="#add"  onClick="window.open('virtual_spot.php?vid=<?php echo $_GET["vid"]; ?>','','width=800,height=600,scrollbars=1,resizable=1');"><img border="0" src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" alt=" <?php echo $text_general_add;?>"> 
      เพิ่ม Hot-spot</a>&nbsp;&nbsp;&nbsp;<a href="#view"  onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_virtual.php?vid=<?php echo $_GET["vid"]; ?>','','width=800,height=600,scrollbars=1,resizable=1');"><img border="0" src="../theme/main_theme/g_view.gif" width="16" height="16" align="absmiddle" alt="Preview"> 
      Preview</a>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="virtual_list.php?gid=<?php echo $_GET["vg_id"]?>"><img src="../theme/main_theme/g_back.gif" alt="กลับ" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_general_back;?></a>
      <hr>
    </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	  <tr class="ewttablehead">
        <td colspan="2" >รายการ Hot-spot ในหน้านี้ </td>
      </tr>
	  <?php
	  $sql_spot = $db->query("SELECT * FROM virtual_spot WHERE v_id = '".$_GET["vid"]."'");
$i=1;
while($S = $db->db_fetch_array($sql_spot)){
	  ?>
      <tr>
        <td width="5%" valign="top" bgcolor="#FFFFFF"><nobr><a href="#edit"  onClick="window.open('virtual_spot.php?vid=<?php echo $_GET["vid"]; ?>&sid=<?php echo $S["s_id"]; ?>','','width=800,height=600,scrollbars=1,resizable=1');"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a> &nbsp; <a href="#del" onClick="Del('<?php echo $S["s_id"]; ?>');"><img src="../theme/main_theme/g_del.gif" width="16" height="16" alt="ลบ" border="0"></a></nobr></td>
        <td width="95%" valign="top" bgcolor="#FFFFFF"><?php echo $S[s_name]; ?></td>
      </tr>
	  <?php } ?>
</table>

</body>
</html>
<?php $db->db_close(); ?>