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

	?>
<html>
<head>
<title>Page Properties [<?php echo $R[filename];?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

</head>
<body leftmargin="0" topmargin="0" >
<?php
if($_GET["B"] != ''){
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name FROM block WHERE BID = '".$BID."'");
?>
				<script language="JavaScript">
				var filename = window.top.document.getElementById('page').value;
				alert(filename);
				window.location.href = "content_tooltips.php?type=<?php echo $_GET[type];?>&&filename="+filename;
				</script>
				<?php
}
?>
<form name="main_tips" method="post" action="">
<input name="type" id="type" type="hidden" value="<?php echo $_GET[type];?>">
<input name="filename"  id="filename" type="hidden" value="<?php echo $_GET[filename];?>">
</form>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <tr>
        <td height="28" bgcolor="#F3F3EE"><table width="98%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr> 
    <td width="60" height="58"><img src="../images/no_pic_2.gif" width="69" height="76"> </td>
          <td><span class="ewthead">Tool Tips  Management</span>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
				  <nobr><span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="content_tooltips_list.php?type=<?php echo $_GET[type];?>&filename=<?php echo $_GET[filename];?>" target="tooltips_body">Tool Tips</a></span>
				  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="content_tooltips_grouplist.php" target="tooltips_body">กลุ่ม Tool Tips</a></span></nobr>
		  </td>
  </tr>
</table></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr> 
    <td height="10" background="../theme/main_theme/bg.gif" bgcolor="#FF3300"></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#FFFFFF">
	<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
                      <tr > 
                        <td bgcolor="#FFFFFF"><iframe name="tooltips_body" src="content_tooltips_list.php?type=<?php echo $_GET[type];?>&filename=<?php echo $_GET[filename];?>&B=<?php echo $_GET['B']; ?>"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
