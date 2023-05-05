<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE db_00_template");
$themes_id = array();
$themes_name = array();
$themes_type = array();
$db->write_log("view","Site Wizard","เข้าสู่ Module Site Wizard");
$sql_menu = $db->query("select * from themes where themes_id ORDER BY themes_id ASC ");
if($db->db_num_rows($sql_menu) > 0){
	while($R=$db->db_fetch_array($sql_menu)){
	array_push($themes_id,$R["themes_id"]);
	array_push($themes_name,$R["themes_name"]);
	array_push($themes_type,$R["themes_type"]);
	}
}
?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Site Wizard</title>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: medium;
	color: #000000;
}
.style2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: xx-small;
}
.style3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: small;
}
.style6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: medium; color: #FFFFFF; }
.style11 {font-size: x-small}
.style12 {color: #0000FF}
-->
</style>
<script language="JavaScript">
		function applydesign(c,d){

		self.location.href = "functiontemplate.php?d_id=" + d+"&thm_id="+c+"&flag=addtheme";
		}
</script>
</head>

<body>
<table width="600" border="0">
  <tr>
    <td colspan="2" valign="top"><img src="images/top_help.jpg" alt="EasyWebTime Help" width="600" height="150" /></td>
  </tr>
  <tr>
    <td width="80%" height="206" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
      <tr>
        <td><table width="100%" border="0" cellpadding="2" cellspacing="1">
          <tr>
            <td height=25 background="images/block_bg_orange.jpg" bgcolor="#000066"><span class="style1">Step 3: Choose WebBlock design</span></td>
          </tr>
          <tr>
            <td height="30" valign="top" bgcolor="#FFFFFF">
				  <div style="overflow:-moz-scrollbars-vertical; overflow-x:auto;overflow-y:auto; width:100%; height:350; " >
				  
				<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" >
			  <tr>
				<td valign="top" align="center" >&nbsp;</td>
			  </tr>
			  <?php
				$i=0;
					$numfile = count($themes_id);
							for($y=0;$y<$numfile;$y++){
						if($i%2== 0){
							echo "<tr bgcolor=\"#FFFFFF\"  align=center height=\"55\">";
						}
						//ดึงรูปภาพ
						$preview_path = "../ewt/template/images/thumbnails_block/template_".$themes_id[$y];
						$preview_path_en = base64_encode($preview_path);
						
			  ?>
			  <td width="25%" valign="top" align="center" ><table width="94%" height="164" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#999999">
				<tr>
				  <td align="center" valign="middle" bgcolor="#FFFFFF"  onClick="applydesign('<?php echo $themes_id[$y]; ?>','<?php echo $_GET[d_id]; ?>')">
				  <img src="img.php?p=<?php echo base64_encode($preview_path); ?>" border="0" align="absmiddle"  style="cursor:hand" width="150"></td>
				</tr>
			  </table>
			   <table width="100%" border="0" cellspacing="2" cellpadding="3">
<tr>
				  <td align="center" valign="middle" bgcolor="#FFFFFF" ><?php echo $themes_name[$y]; ?></td>
				</tr>
				<tr>
				  <td align="right" valign="middle" bgcolor="#FFFFFF" ><a href="#" onClick="applydesign('<?php echo $themes_id[$y]; ?>','<?php echo $_GET[d_id]; ?>')"><img src="../images/magic-wand2.gif" border="0" align="absmiddle"><span class="style12">เลือก design นี้</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
				</tr>
</table>
					</td>
				  <?php 
						if($i%2 == 1){
							echo "</tr>";
						}
			  $i++; } ?>
			  <tr>
				<td valign="top" align="center" >&nbsp;</td>
			  </tr>
			</table>
				  
				  </div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="20%" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
      <tr>
        <td><table width="100%" border="0" cellpadding="2" cellspacing="1">
            <tr>
              <td height="25" background="images/block_bg_dblue.jpg" bgcolor="#000066"><span class="style6">Note:</span></td>
            </tr>
            <tr>
                <td height="30" valign="top" bgcolor="#FFFFFF"><span class="style11">เลือกรูปแบบของบล็อกที่คุณต้องการ</span><span class="style3"><br />
                  <br />
                </span></td>
            </tr>
        </table></td>
      </tr>
    </table>
    <br />    </td>
  </tr>
  <tr>
    <td colspan="2"><span class="style2">&copy; 2008 BizPotential Co., Ltd.</span></td>
  </tr>
</table>
</body>
</html>
