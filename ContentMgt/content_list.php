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

//seach temp_index file name
$sql_temp = "select * from temp_index where filename = '".$_GET[filename]."'";
$T = $db->db_fetch_array($db->query($sql_temp));
$sql_group = $db->query("SELECT * FROM temp_main_group ORDER BY Main_Position ASC");
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style_content.css" rel="stylesheet" type="text/css">
<SCRIPT language=JavaScript>
				function hlah(c,d,e){
				var n = document.form1.num.value;
							document.getElementById('ah'+n).removeAttribute("style");
							document.getElementById('ah'+c).style.backgroundColor = "#B2B4BF";
							document.form1.num.value = c;
							self.top.document.all.group_id.value = d;
							self.top.document.all.gname.innerHTML = e;
			}
</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="9D9DA1">
  <tr> 
    <td valign="top" bgcolor="#FFFFFF">
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"><form name="form1" method="post" action="">
  <tr>
          <td><img src="../images/workplace.gif" width="20" height="20" border="0" align="absmiddle"> 
            <strong>My Website</strong></td>
  </tr>
  <?php
  $i = 0;
  $num_i =='';
  	while($R = $db->db_fetch_array($sql_group)){
	if($db->check_permission("Fo","w",$R[Main_Group_ID])){
	$sql_sub = $db->query("SELECT COUNT(Main_Group_ID) FROM temp_main_group WHERE Main_Position LIKE '".$R["Main_Position"]."_%'");
	$count_sub = $db->db_fetch_row($sql_sub);
	if($T[Main_Group_ID] == $R["Main_Group_ID"]){
	$num_i = $i;
	$main_groupid = $R["Main_Group_ID"];
	$main_groupname = $R["Main_Group_Name"];
	}
  ?>
        <tr> 
          <td>
            <?php
		  		GenPic($R["Main_Position"]);
		   if($count_sub[0] > 0){ ?>
            <img src="../images/minus.gif" border="0" align="absmiddle">
            <?php }else{ ?>
            <img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle">
            <?php } ?>
            <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;&nbsp;<a id="ah<?php echo $i; ?>" href="#select" onClick="hlah('<?php echo $i; ?>','<?php echo $R["Main_Group_ID"]; ?>','<?php echo $R["Main_Group_Name"]; ?>')" ><?php echo $R["Main_Group_Name"]; ?></a> 
            <?php
			if($i == 0){
			$a1 = $R["Main_Group_ID"];
			$a2 = $R["Main_Group_Name"];
			}
			?>
              
             </td>
  </tr>
  <?php $i++; }} ?><input name="num" type="hidden" id="num" value="0">
</form>
</table>
</td>
  </tr>
</table>
</body>
</html>
<script language="JavaScript">
<?php
if($num_i != ''){//cese filename for edit
?>
hlah('<?php echo $num_i; ?>','<?php echo $main_groupid; ?>','<?php echo $main_groupname; ?>');
<?php
}else{
?>
hlah('0','<?php echo $a1; ?>','<?php echo $a2; ?>');
<?php  }?>
</script>
<?php $db->db_close(); ?>
