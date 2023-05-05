<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

function GenPic($data){
$s = explode("_",$data);
	for($i=2;$i<count($s);$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}


$sql_group = $db->query("SELECT * FROM temp_main_group ORDER BY Main_Position ASC");
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
			function exit(){
				self.top.ewt_main.location.href = "../ewt_main.php";
				self.location.href = "../ewt_left.php";
			}
		  	function selColor(c){
				Win2=window.open('../ewt_color.php?t='+ c +'','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=100, top=100');
			}
				function hlah(c){
				var n = parent.content_bottom.document.form1.num.value;
							document.getElementById('ah'+n).removeAttribute("style");
							document.getElementById('ah'+c).style.backgroundColor = "#B2B4BF";
							parent.content_bottom.document.form1.num.value = c;
			}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="9D9DA1">
  <tr>
    <td height="40" background="../images/content_bg_left.gif" bgcolor="FBEBEB"><table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="96%"><strong> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
            Website directory</strong></td>
          <td width="4%" align="right">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#FFFFFF">
	<DIV align="center"  style="HEIGHT:100%;OVERFLOW-X: scroll;OVERFLOW-Y: scroll;WIDTH: 100%">
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
          <td><img src="../images/workplace.gif" width="20" height="20" border="0" align="absmiddle"> 
            <strong><a id="ah0" href="content_index.php" target="content_main"  onClick="hlah('0')">My Website</a></strong></td>
  </tr>
  <?php
  $i = 1;
  	while($R = $db->db_fetch_array($sql_group)){
	if($db->check_permission("Fo","w",$R[Main_Group_ID])){
	$sql_sub = $db->query("SELECT COUNT(Main_Group_ID) FROM temp_main_group WHERE Main_Position LIKE '".$R["Main_Position"]."_%'");
	$count_sub = $db->db_fetch_row($sql_sub);

  ?>
        <tr> 
          <td><?php
		  		GenPic($R["Main_Position"]);
		   if($count_sub[0] > 0){ ?><img src="../images/minus.gif" border="0" align="absmiddle"><?php }else{ ?><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php } ?><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;&nbsp;<a id="ah<?php echo $i; ?>" href="content_view.php?gid=<?php echo $R["Main_Group_ID"]; ?>" onClick="hlah('<?php echo $i; ?>')" target="content_main"><?php echo $R["Main_Group_Name"]; ?></a>  
          </td>
  </tr>
  <?php $i++; }} ?>

</table>
</DIV>
</td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>